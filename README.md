# EquEdEU

Zentrales Monorepo für alle Extensions des digitalen Hufpflege-Ausbildungssystems **EquEd**.

## 📦 Enthaltene Extensions

| Ordner             | Beschreibung |
|--------------------|--------------|
| `equed-core`        | Zentrale Dienste: Übersetzung, Glossar, YAML, DSGVO |
| `equed-auth`        | Authentifizierung (JWT, SSO, 2FA, Token) |
| `equed-lms`         | Lernplattform: Kurse, Prüfungen, Feedback |
| `equed-cert`        | Zertifikate, Badges, Crossover, Recognition |
| `equed-qms`         | QMS-Fälle, GPT-Prüfungsauswertung, Feedbackanalyse |
| `equed-instructor`  | Instructor-Dashboard, Kursbewertung, Fortschritt |
| `equed-center`      | Trainingszentren, Kursorte, Kursverwaltung |
| `equed-admin`       | Systemweite Verwaltung, Rollen, Zert-Freigabe |
| `equed-app`         | React-App für mobile Lernansicht, Upload, Badge |
| `equed-shop`        | Dropshipping, Aboverwaltung, Material & Faktura |

## 📁 Dokumentation

- Alle Projektdefinitionen befinden sich im Ordner [`docs/`](./docs/)
- Projektplan: [`docs/projektplan/`](./docs/projektplan/)
- Projektentscheidungen: [`docs/entscheidungen/`](./docs/entscheidungen/)
- Technische Architektur: `./.codex/`

## 🛠 Entwicklung & Architektur

- Basierend auf **TYPO3 13**, **PHP 8.2+**, **React (App)**
- Clean Code, DDD, GPT-gestützte Auswertungen, Barrierefreiheit
- Internationale Ausrichtung: EN, DE, FR, ES, SW, EASY
- Zukünftige Erweiterbarkeit für SSO, Recognition, Partnerportale

## 🔄 Übersetzungen synchronisieren

Zum Abgleich der XLF-Sprachdateien mit dem Translation-Server wird der TYPO3
CLI-Befehl `translation:sync` eingesetzt.

### Voraussetzungen

- PHP 8.2 oder neuer mit den Erweiterungen `xml` und `gd`
- [Composer](https://getcomposer.org/)

### Lokaler Aufruf

```bash
composer install
vendor/bin/typo3 translation:sync
```

---

© 2025 [Equine Education Europe Ltd.](https://equed.eu) – alle Rechte vorbehalten.
