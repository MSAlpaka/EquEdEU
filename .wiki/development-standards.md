# Development Standards

**Inhalt**

1. [Code Style](#code-style)
2. [Static Analysis](#static-analysis)
3. [Monorepo](#monorepo)
4. [Testing](#testing)

## Code Style

Die Extensions folgen dem PSR‑12‑Standard. Der Composer-Befehl `phpcs` prüft den Code:
​:codex-file-citation[codex-file-citation]{line_range_start=43 line_range_end=44 path=equed-core/composer.json git_url="https://github.com/MSAlpaka/EquEdEU/blob/main/equed-core/composer.json#L43-L44"}​​:codex-file-citation[codex-file-citation]{line_range_start=44 line_range_end=45 path=equed-core/.github/workflows/ci.yml git_url="https://github.com/MSAlpaka/EquEdEU/blob/main/equed-core/.github/workflows/ci.yml#L44-L45"}​

## Static Analysis

PHPStan ist verpflichtend und wird auf Level 7 ausgeführt:
​:codex-file-citation[codex-file-citation]{line_range_start=38 line_range_end=44 path=equed-core/composer.json git_url="https://github.com/MSAlpaka/EquEdEU/blob/main/equed-core/composer.json#L38-L44"}​​:codex-file-citation[codex-file-citation]{line_range_start=42 line_range_end=44 path=equed-core/.github/workflows/ci.yml git_url="https://github.com/MSAlpaka/EquEdEU/blob/main/equed-core/.github/workflows/ci.yml#L42-L44"}​

## Monorepo

Alle Extensions liegen in einem gemeinsamen Repository und nutzen Composer. Abhängigkeiten werden mit `composer install` eingerichtet:
​:codex-file-citation[codex-file-citation]{line_range_start=21 line_range_end=30 path=equed-core/README.md git_url="https://github.com/MSAlpaka/EquEdEU/blob/main/equed-core/README.md#L21-L30"}​​:codex-file-citation[codex-file-citation]{line_range_start=17 line_range_end=30 path=equed-lms/README.md git_url="https://github.com/MSAlpaka/EquEdEU/blob/main/equed-lms/README.md#L17-L30"}​

## Testing

Unit- und Functional-Tests werden mit PHPUnit ausgeführt (`composer test`).  
Beispielkonfigurationen liegen in `phpunit.xml.dist` innerhalb der Extensions.
