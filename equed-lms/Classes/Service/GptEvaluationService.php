<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use DateTimeImmutable;
use Equed\EquedLms\Domain\Service\ClockInterface;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Equed\EquedLms\Service\LogService;
use TYPO3\CMS\Core\Http\RequestFactory;
use Equed\EquedLms\Domain\Model\Submission;
use Equed\EquedLms\Domain\Repository\SubmissionRepositoryInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;

/**
 * Service to perform GPT-based evaluation of user submissions.
 */
final class GptEvaluationService
{
    private const MIN_TEXT_LENGTH = 20;

    public function __construct(
        private readonly SubmissionRepositoryInterface $submissionRepository,
        private readonly RequestFactory                $requestFactory,
        private readonly LogService           $logService,
        private readonly GptTranslationServiceInterface $translationService,
        private readonly string                        $openAiApiKey,
        private readonly bool                          $evaluationEnabled,
        private readonly string                        $openAiApiUrl,
        private readonly ClockInterface                $clock
    ) {
    }

    /**
     * Evaluate all pending submissions via GPT.
     *
     * @return int Number of submissions successfully evaluated
     */
    public function evaluatePending(): int
    {
        if (! $this->evaluationEnabled) {
            return 0;
        }

        $pending = $this->submissionRepository->findPendingForAnalysis();
        $count   = 0;

        foreach ($pending as $submission) {
            if ($this->evaluateSubmission($submission) !== null) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Evaluate a single submission via GPT.
     *
     * @param Submission $submission
     * @return array<string,mixed>|null Analysis result or null on failure
     */
    public function evaluateSubmission(Submission $submission): ?array
    {
        $content = $submission->getTextContent();
        if ($content === null || mb_strlen($content) < self::MIN_TEXT_LENGTH) {
            return null;
        }

        $prompt = $this->translationService->translate(
            'submission.evaluation.prompt',
            ['content' => $content]
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
            $response = $this->requestFactory->request(
                $this->openAiApiUrl,
                'POST',
                [
                    'headers' => $headers,
                    'body'    => json_encode($payload, JSON_THROW_ON_ERROR),
                    'timeout' => 15,
                ]
            );

            $body   = $response->getBody()->getContents();
            $result = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
            $message = $result['choices'][0]['message']['content'] ?? '';

            if (! str_contains($message, '{')) {
                return null;
            }

            $analysis = json_decode($message, true, 512, JSON_THROW_ON_ERROR);
            if (! is_array($analysis)) {
                return null;
            }

            $submission
                ->setGptAnalysisStatus('done')
                ->setGptScore((float) ($analysis['suggestedScore'] ?? 0.0))
                ->setGptSummary($analysis['summary'] ?? '')
                ->setGptSuggestion($analysis['suggestion'] ?? '')
                ->setGptAnalysisData(json_encode($analysis, JSON_THROW_ON_ERROR))
                ->setAnalyzedAt($this->clock->now());

            $this->submissionRepository->update($submission);

            return $analysis;
        } catch (ClientExceptionInterface | JsonException $e) {
            $this->logService->logError(
                $this->translationService->translate(
                    'submission.evaluation.error',
                    ['error' => $e->getMessage()]
                )
            );

            return null;
        }
    }
}
