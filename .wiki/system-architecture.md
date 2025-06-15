# System Architecture

**Inhalt**

1. [Überblick](#überblick)
2. [Extensions](#extensions)
3. [Schnittstellen](#schnittstellen)

## Überblick

Der Projektplan beschreibt die technische Struktur der Plattform. Jedes Modul ist über Composer installierbar und folgt der TYPO3‑13‑Architektur. Die Kernmodule sind:

- `equed-core` – Übersetzungen, Glossar, Organisationsstruktur  
- `equed-auth` – JWT-basierte Authentifizierung mit SSO  
- `equed-lms` – Kurse, Prüfungen, GPT-Auswertung  
- `equed-cert` – QR-Zertifikate, Badge-System  
- `equed-qms` – Qualitätsmanagement (Incident, Complaint, Audit)  
- `equed-instructor` – Instructor-Dashboard  
- `equed-center` – Kursorte und Materiallogistik  
- `equed-admin` – zentrale Verwaltung und Statistik  
- `equed-app` – React-App  
- `equed-shop` – Dropshipping und Aboverwaltung

Diese Liste ist im Projektplan festgelegt:
​:codex-file-citation[codex-file-citation]{line_range_start=12 line_range_end=74 path=docs/projektplan/EEE_HoofCare_Projektplan_2025.md git_url="https://github.com/MSAlpaka/EquEdEU/blob/main/docs/projektplan/EEE_HoofCare_Projektplan_2025.md#L12-L74"}​

## Extensions

Jede Extension ist eigenständig, nutzt aber gemeinsame Services aus `equed-core`. Die Auth-Extension stellt SSO‑Funktionen bereit, die App und das Shop-Modul greifen darauf zu.

## Schnittstellen

- REST‑API (TYPO3 Extbase / PSR-7)  
- JWT für alle Frontend-Clients  
- Interne Events basieren auf PSR‑14  
- GPT-Anbindung über einen PSR‑18‑konformen HTTP‑Client  
- Uploads werden serverseitig verschlüsselt gespeichert

Weitere Details zur API-Struktur finden sich in den jeweiligen Extension-Repositories.
