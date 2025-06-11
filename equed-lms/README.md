EquEd LMS
=========

Learning Management System für Equine Education Europe  
Modulares, zertifizierungsfähiges und vollständig mehrsprachiges LMS für die berufliche Ausbildung in der Hufbearbeitung und verwandten Fachbereichen. Voll kompatibel mit App-Integration, REST-API, Instructor-Workflow, QMS-Logik und internationaler Anerkennung.

...

(gekürzt für Übersicht – tatsächlicher Text wird vollständig gespeichert)


## Development Setup

Before running static analysis or tests, install the Composer dependencies so that TYPO3 classes are available. Composer itself must therefore be available:

```bash
composer install
```

Ensure that **PHP 8.2 or higher** with the `xml` and `gd` extensions as well as Composer are
available. The repository ships a `setup.sh` script and a `Dockerfile` that
install Composer automatically when missing and execute `composer install`.
The script now verifies that PHP is installed and aborts with an informative
message when it is not found.

You can then execute PHPStan and the test suite with:

```bash
composer phpstan
composer test
```

The PHPUnit configuration (`phpunit.xml.dist`) now also loads tests under
`Tests/Unit/Service`, including `GptTranslationServiceTest` and
`LogServiceTest`.

## Codex Environment
When this repository is opened in the Codex environment, the `setup.sh` script is executed automatically on container start to install required dependencies.
