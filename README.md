# Equed Core Extension / Equed Core Erweiterung

## Overview / \U00dcberblick

Equed Core is the central TYPO3 extension that provides shared domain models, translation utilities and QMS hooks for the EEE HoofCare platform. The code follows TYPO3 13 conventions and requires PHP 8.2 or higher.

Equed Core ist die zentrale TYPO3-Extension f\u00fcr gemeinsame Domain-Modelle, \u00dcbersetzungsdienste und QMS-Hooks der EEE HoofCare Plattform. Die Erweiterung basiert auf TYPO3 13 und setzt PHP 8.2 oder neuer voraus.

### Architecture / Architektur

- Domain models for audit trails, uploads and language data
- QMS hook system with escalation logic
- Integration of `GptTranslationService` for multilingual content

## Installation

1. Repository klonen:
   `git clone https://github.com/equed/equed-core.git typo3conf/ext/equed_core`
2. PHP (>=8.2) sowie Composer installieren, falls noch nicht vorhanden.
   PHP sollte im `PATH` verfügbar sein. Composer kann via Paketmanager oder
   [https://getcomposer.org/](https://getcomposer.org/) installiert werden.
3. Setup-Skript ausführen (installiert Abhängigkeiten und führt die ersten
   Datenbankbefehle aus):
   `./setup.sh`
4. Extension im TYPO3 Backend aktivieren (falls nicht durch das Skript erfolgt)
5. Datenbankschema per CLI aktualisieren (optional, falls Skript genutzt):
   `vendor/bin/typo3 database:updateschema`
6. Caches leeren

Alle Schemadefinitionen liegen als YAML unter `Configuration/Schema/Domain/Model/`.
Die bisher übliche Datei `ext_tables.sql` wird nicht mehr benötigt.

## Configuration / Konfiguration

### PageTS / UserTS

Include the shipped PageTS and UserTS configurations to register backend modules and default permissions.

### Environment variables

`GPT_TRANSLATION_API_KEY` and `GPT_TRANSLATION_ENDPOINT` konfigurieren den GptTranslationService.
`EQUED_LMS_API_BASE` kann genutzt werden, um die Basis-URL des LmsIntegrationService zu überschreiben (Standard: `https://equed-lms.local/api`).

Beispiel f\u00fcr eine `.env` Datei:

```bash
GPT_TRANSLATION_API_KEY=your-key
GPT_TRANSLATION_ENDPOINT=https://api.example.com/translate
```

### Using the GptTranslationService

Instantiate the service with a `HttpClientInterface` implementation and call
`translate()` to get the translated string:

```php
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Equed\EquedCore\Service\GptTranslationService;

// $client is an instance of HttpClientInterface
$service = new GptTranslationService($client);
echo $service->translate('Hello world', 'de');
```

### Caching Tags

In `LocalConfiguration.php` lassen sich zus\u00e4tzliche Caching-Tags definieren:

```php
'cache_hash' => [
    'excluded_parameters' => ['gptCache'],
],
```

Repositories use a lightweight in-memory `ArrayCache` by default. The service
implements `Psr\SimpleCache\CacheInterface` and is registered through
`Configuration/Services.yaml`, so custom implementations can be swapped via the
Symfony container.

## Testing / Tests ausführen

The extension ships with unit and functional tests. Before running them,
ensure that all development dependencies are installed via `composer`.
`vendor/bin/phpunit` only exists after running `composer install`. Afterwards
the static analysis and test suite can be executed using the provided composer
scripts:

```bash
composer install
# `vendor/bin/phpunit` is only available after installing the dependencies
composer phpcs
composer phpstan
composer test
```

## License

This project is licensed under the [GNU General Public License v2.0 or later](LICENSE).
