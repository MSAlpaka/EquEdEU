<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Traits;

use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\Attributes\After;
use PHPUnit\Framework\Attributes\PostCondition;
use PHPUnit\Framework\TestCase;
use Prophecy\Exception\Doubler\DoubleException;
use Prophecy\Exception\Doubler\InterfaceNotFoundException;
use Prophecy\Exception\Prediction\PredictionException;
use Prophecy\Prophecy\MethodProphecy;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;

/**
 * Local copy of ProphecyTrait to avoid dependency issues.
 *
 * @mixin TestCase
 */
trait ProphecyTrait
{
    /**
     * @var Prophet|null
     */
    private $prophet;

    /**
     * @var bool
     */
    private $prophecyAssertionsCounted = false;

    /**
     * Create a prophecy for the given class or interface.
     *
     * @template T of object
     * @param class-string<T>|null $classOrInterface
     * @return ObjectProphecy<T|object>
     *
     * @throws DoubleException
     * @throws InterfaceNotFoundException
     */
    protected function prophesize(?string $classOrInterface = null): ObjectProphecy
    {
        static $isPhpUnit9;
        $isPhpUnit9 = $isPhpUnit9 ?? method_exists($this, 'recordDoubledType');

        if (! $isPhpUnit9) {
            // PHPUnit 10.1
            $this->registerFailureType(PredictionException::class);
        } elseif (\is_string($classOrInterface)) {
            // PHPUnit 9
            \assert($this instanceof TestCase);
            $this->recordDoubledType($classOrInterface);
        }

        return $this->getProphet()->prophesize($classOrInterface);
    }

    #[PostCondition]
    protected function verifyProphecyDoubles(): void
    {
        if ($this->prophet === null) {
            return;
        }

        try {
            $this->prophet->checkPredictions();
        } catch (PredictionException $e) {
            throw new AssertionFailedError($e->getMessage());
        } finally {
            $this->countProphecyAssertions();
        }
    }

    #[After]
    protected function tearDownProphecy(): void
    {
        if (null !== $this->prophet && ! $this->prophecyAssertionsCounted) {
            // Some Prophecy assertions may have been done in tests themselves even when a failure happened before checking mock objects.
            $this->countProphecyAssertions();
        }

        $this->prophet = null;
    }

    private function countProphecyAssertions(): void
    {
        \assert($this instanceof TestCase);
        \assert($this->prophet !== null);
        $this->prophecyAssertionsCounted = true;

        foreach ($this->prophet->getProphecies() as $objectProphecy) {
            foreach ($objectProphecy->getMethodProphecies() as $methodProphecies) {
                foreach ($methodProphecies as $methodProphecy) {
                    \assert($methodProphecy instanceof MethodProphecy);
                    $this->addToAssertionCount(\count($methodProphecy->getCheckedPredictions()));
                }
            }
        }
    }

    private function getProphet(): Prophet
    {
        if ($this->prophet === null) {
            $this->prophet = new Prophet();
        }

        return $this->prophet;
    }
}
