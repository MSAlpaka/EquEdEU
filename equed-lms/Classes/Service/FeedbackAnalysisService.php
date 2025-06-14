<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\CourseFeedback;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Equed\EquedLms\Service\LogService;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedCore\Service\GptClientInterface;
use Equed\EquedLms\Service\TranslatedLoggerTrait;

/**
 * Service for analyzing feedback using GPT, with configurable feature toggle.
 */
final class FeedbackAnalysisService
{
    use TranslatedLoggerTrait;
    private const GPT_API_URL = 'https://api.openai.com/v1/chat/completions';
    private const MIN_TEXT_LENGTH = 10;

    public function __construct(
        private readonly GptClientInterface $gptClient,
        GptTranslationServiceInterface $translationService,
        LogService $logService,
        private readonly string $openAiApiKey,
        private readonly bool $feedbackAnalysisEnabled
    ) {
        $this->injectTranslatedLogger($translationService, $logService);
    }

    /**
     * Analyze feedback; returns analysis array with 'summary', 'clusters', 'suggestedRating' or null.
     *
     * @param CourseFeedback $feedback Feedback entity
     * @return array<string, mixed>|null
     */
    public function analyzeFeedback(CourseFeedback $feedback): ?array
    {
        if (!$this->feedbackAnalysisEnabled) {
            return null;
        }

        $text = $feedback->getOriginalComment();
        if ($text === '' || mb_strlen($text) < self::MIN_TEXT_LENGTH) {
            return null;
        }

        $prompt = $this->translationService->translate(
            'feedback.analysis.prompt',
            ['feedback' => $text]
        );

        $payload = [
            'model'       => 'gpt-3.5-turbo',
            'messages'    => [['role' => 'user', 'content' => $prompt]],
            'temperature' => 0.3,
        ];

        $headers = [
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer ' . $this->openAiApiKey,
        ];

        try {
            $response = $this->gptClient->postJson(
                self::GPT_API_URL,
                $headers,
                $payload
            );

            $body = $response->getBody()->getContents();
            $result = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
            $content = $result['choices'][0]['message']['content'] ?? '';

            if (!str_contains($content, '{')) {
                return null;
            }

            $analysis = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
            if (!is_array($analysis)) {
                return null;
            }

            $feedback->setAnalysisSummary($analysis['summary'] ?? '');
            $feedback->setAnalysisTopics(json_encode($analysis['clusters'] ?? [], JSON_THROW_ON_ERROR));
            $feedback->setSuggestedRating((float) ($analysis['suggestedRating'] ?? 0.0));

            return $analysis;
        } catch (ClientExceptionInterface | JsonException $e) {
            $this->logTranslatedError('feedback.analysis.error', ['error' => $e->getMessage()]);

            return null;
        }
    }
}
