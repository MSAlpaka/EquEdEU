<?php
namespace Equed\Core\Service;
interface UuidGeneratorInterface { public function generate(): string; }
interface ClockInterface { public function now(): \DateTimeImmutable; }
