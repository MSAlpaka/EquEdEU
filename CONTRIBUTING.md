# Beitragen zu EquEdEU

Dieses Monorepo enthält alle Extensions der EquEdEU Plattform. Wir freuen uns über jeden Beitrag, solange dieser die folgenden Regeln beachtet.

## 1. Überblick

EquEdEU ist ein modulares E-Learning-System basierend auf TYPO3 und einer React-App. Ziel ist ein getesteter, DSGVO-konformer und EQF-tauglicher Code für internationale Aus- und Weiterbildung. Das Repository enthält unter anderem die Extensions `equed-core`, `equed-lms`, `equed-cert`, `equed-qms`, `equed-app`, `equed-center`, `equed-instructor` und `equed-admin`.

## 2. Voraussetzungen & lokale Installation

1. **Repository klonen**
   ```bash
   git clone https://github.com/equed/equedeu.git
   cd EquEdEU
   ```
2. **TYPO3-Umgebung einrichten**
   - PHP ≥ 8.2 mit `xml` und `gd`
   - Composer installieren
3. **Extensions vorbereiten**
   - In jedem Unterordner (`equed-*`) `composer install` ausführen
   - Falls vorhanden: `setup.sh` starten, um TYPO3-Befehle (Aktivierung, DB-Update, Cache) automatisch auszuführen
4. **React-App (falls genutzt)**
   ```bash
   cd equed-app
   npm install
   ```
   Danach stehen `npm test` und `npm run build` zur Verfügung.

## 3. Coding Guidelines

- **PHP**: PSR-12, strikte Typisierung, PHPStan auf Level `max`
- **JavaScript / TypeScript**: ESLint und Prettier beachten
- **Tests**: Jede Extension enthält PHPUnit-Tests. Führe `composer test` vor jedem Commit aus.
- **React**: Nutzt TypeScript. Struktur gemäß `src/`-Ordner einhalten und Hooks klar trennen
- **Dateien**: Keine personenbezogenen Daten in Beispieldaten oder Logs ablegen

## 4. Commit-Konventionen

- Aussagekräftige Nachrichten (optionaler [Conventional Commits](https://www.conventionalcommits.org/)). Beispiele:
  - `feat(lms): add attendance tracking`
  - `fix(core): correct timezone handling`
- Deutsche oder englische Messages sind erlaubt, sollten aber konsistent sein
- Kleinere Änderungen können `docs:` oder `chore:` nutzen

## 5. Branching & Pull Requests

1. Branch vom aktuellen `main` anlegen:
   - `feature/<thema>` für neue Features
   - `bugfix/<thema>` für Fehlerbehebungen
   - `hotfix/<thema>` für kritische Korrekturen
2. Lokale Tests und `composer phpstan`/`composer phpcs` ausführen
3. Pull Request erstellen und auf Review warten
4. Mindestens eine Review-Approval vor dem Merge erforderlich
5. Squash-Merge bevorzugt, um die Historie sauber zu halten

## 6. Tests & Qualitätssicherung

- `composer phpcs`  – PSR-12 Code Style Prüfung
- `composer phpstan` – statische Analyse auf höchstem Level
- `composer test` – PHPUnit-Tests
- React-Komponenten: `npm test` (z. B. mit Playwright/Jest)
- Alle Checks laufen ebenfalls in GitHub Actions (`.github/workflows/*`)

## 7. DSGVO-relevante Änderungen

- Pseudonymisierung für Logs und GPT-Auswertungen beachten (siehe [Projektentscheidungen](docs/entscheidungen/EEE_Projektentscheidungen_2025.md#5-dsgvo--sicherheit))
- Keine personenbezogenen Daten ins Repository hochladen
- Zugriffsbeschränkungen (JWT, 2FA, Token-Blacklist) respektieren
- Bei Unsicherheiten Rücksprache mit dem Datenschutzbeauftragten halten

## 8. Sicherheitsmeldungen

Sicherheitslücken bitte **nicht** öffentlich melden. Schreibe eine E-Mail an [security@equed.eu](mailto:security@equed.eu). Details findest du in [SECURITY.md](SECURITY.md).

## 9. Verhaltenskodex

Wir erwarten ein respektvolles Miteinander. Der [Code of Conduct](.github/CODE_OF_CONDUCT.md) gilt für alle Repositories und Kommunikationskanäle.

## 10. Empfohlene Tools

- **VS Code** mit den Erweiterungen: PHP Intelephense, ESLint, Prettier, TYPO3 Snippets
- Optional: Git Hooks (z. B. `pre-commit` für CS Fixer)

Danke für dein Interesse an EquEdEU! Wir freuen uns auf deine Beiträge.
