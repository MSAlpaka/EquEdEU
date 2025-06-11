# Installation

Diese Anleitung beschreibt die Einrichtung der Equed Core Extension.

## Systemvoraussetzungen

- TYPO3 13
- PHP 8.2 oder h\u00f6her
- MySQL 8+

## Schritte

Composer muss installiert sein. Siehe [https://getcomposer.org/](https://getcomposer.org/).

Führen Sie anschließend das bereitgestellte Setup-Skript aus, um Abhängigkeiten zu installieren und das Schema zu aktualisieren:

```bash
./setup.sh
```

Alternativ lassen sich die einzelnen Befehle manuell ausführen:

```bash
composer require equed/equed-core
vendor/bin/typo3 extension:activate equed_core
vendor/bin/typo3 database:updateschema
vendor/bin/typo3 cache:flush
```

## PageTS und UserTS

Die Extension stellt Beispielkonfigurationen bereit. Includen Sie sie in Ihrem Seiten- bzw. Benutzer-TSconfig, um Backend-Module und Dateipfade zu registrieren.

## .env Beispiel

Falls Sie dotenv nutzen, legen Sie folgende Werte an:

```env
GPT_TRANSLATION_API_KEY=your-key
GPT_TRANSLATION_ENDPOINT=https://api.example.com/translate
FILE_STORAGE_BASE=/var/www/files
```

## LmsIntegrationService

Die Basis-URL für Anfragen an das externe LMS kann über die Umgebungsvariable
`EQUED_LMS_API_BASE` konfiguriert werden:

```env
EQUED_LMS_API_BASE=https://equed-lms.local/api
```

Wird kein Wert gesetzt, verwendet der Service die obige Standard-URL.

## GptTranslationService

Der Service nutzt die Umgebungsvariablen `GPT_TRANSLATION_API_KEY` und
`GPT_TRANSLATION_ENDPOINT` zur Konfiguration. Ein Beispiel findet sich im
[README](README.md#environment-variables). Laut Projektentscheidungen wird die
Live-\u00dcbersetzung per GPT angebunden, wobei die Antwort vor dem Speichern
best\u00e4tigt werden muss (siehe Projektentscheidungen Zeilen 27570ff.).
