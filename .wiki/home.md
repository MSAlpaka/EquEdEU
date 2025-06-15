# EquEdEU Wiki

**Inhalt**

1. [Überblick](#überblick)
2. [Systemarchitektur](System-Architecture.md)
3. [Kurse & Zertifizierung](Course-System.md)
4. [Badges & Zertifikate](Badges-and-Certification.md)
5. [GPT & QMS](GPT-and-QMS.md)
6. [App](App-Features.md)
7. [Glossar](Glossary.md)
8. [Entscheidungen](Decision-Log.md)
9. [Sicherheit](Security-and-DSGVO.md)
10. [Entwicklung](Development-Standards.md)
11. [Mitwirken](Contribution-Guide.md)
12. [FAQ](FAQ.md)

## Überblick

EquEdEU ist ein modulares Ausbildungssystem für Barhufbearbeitung. Alle Extensions befinden sich in einem gemeinsamen Monorepo. Die Plattform kombiniert ein TYPO3‑Backend, ein React‑Frontend und eine Quality‑Management‑Integration. Kernziel ist eine langfristig wartbare Lösung nach EQF‑ und ISO‑17024‑Standards.

Die enthaltenen Extensions sind in der Projektübersicht aufgelistet:

Ordner	Beschreibung
equed-core	Zentrale Dienste: Übersetzung, Glossar, YAML
equed-auth	Authentifizierung (JWT, SSO, 2FA, Token)
equed-lms	Lernplattform: Kurse, Prüfungen, Feedback
equed-cert	Zertifikate, Badges, Crossover, Recognition
equed-qms	QMS-Fälle, GPT-Prüfungsauswertung, Feedback
equed-instructor	Instructor-Dashboard, Kursbewertung, Fortschritt
equed-center	Trainingszentren, Kursorte, Kursverwaltung
equed-admin	Systemweite Verwaltung, Rollen, Zert-Freigabe
equed-app	React-App für mobile Lernansicht, Upload, Badge
equed-shop	Dropshipping, Aboverwaltung, Material & Faktura

ruby
Kopieren
​:codex-file-citation[codex-file-citation]{line_range_start=5 line_range_end=18 path=README.md git_url="https://github.com/MSAlpaka/EquEdEU/blob/main/README.md#L5-L18"}​

Das gesamte Projekt setzt auf Qualitätsmanagement, DSGVO-Konformität und eine einheitliche Versionierung. Weitere Details befinden sich in den jeweiligen Wiki-Seiten.
