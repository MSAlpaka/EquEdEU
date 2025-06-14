<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\ViewHelpers;

use Equed\EquedLms\ViewHelpers\UserRoleViewHelper;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Repository\UserProfileRepositoryInterface;
use Equed\EquedLms\Domain\Model\UserProfile;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use PHPUnit\Framework\TestCase;

final class UserRoleViewHelperTest extends TestCase
{
    use ProphecyTrait;

    public function testRenderReturnsTranslatedRole(): void
    {
        $translator = $this->prophesize(GptTranslationServiceInterface::class);
        $translator->isEnabled()->willReturn(true);
        $translator->translate('role.instructor', [], 'equed_lms')->willReturn('Instructor');

        $profile = $this->prophesize(UserProfile::class);
        $profile->getIsCertifier()->willReturn(false);
        $profile->isInstructor()->willReturn(true);

        $repo = $this->prophesize(UserProfileRepositoryInterface::class);
        $repo->findByFeUser(7)->willReturn($profile->reveal());

        $viewHelper = new UserRoleViewHelper($translator->reveal(), $repo->reveal());
        $ref = new \ReflectionProperty($viewHelper, 'arguments');
        $ref->setAccessible(true);
        $ref->setValue($viewHelper, ['userId' => 7]);

        $this->assertSame('Instructor', $viewHelper->render());
    }
}
