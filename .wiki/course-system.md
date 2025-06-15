# Course System

**Inhalt**

1. [Kursstruktur](#kursstruktur)
2. [Module & Prüfungen](#module--prüfungen)
3. [Zertifikatslogik](#zertifikatslogik)

## Kursstruktur

Laut Projektentscheidung ist die Lernplattform wie folgt aufgebaut:

- **Program → CourseInstance → UserCourseRecord** – zentrale Hierarchie für alle Kurse  
- Badges (Grau, Bronze, Silber, Gold) und Specialty-Awards sind integriert  
- GPT-Auswertung liefert einen Vorschlag, den Instructor bestätigen muss  
​:codex-file-citation[codex-file-citation]{line_range_start=20 line_range_end=25 path=docs/entscheidungen/EEE_Projektentscheidungen_2025.md git_url="https://github.com/MSAlpaka/EquEdEU/blob/main/docs/entscheidungen/EEE_Projektentscheidungen_2025.md#L20-L25"}​

## Module & Prüfungen

- Prüfungsformen: Multiple Choice, Freitext, Uploads und Fallberichte  
- TrainingRecord (TR) ist pro Kurs und Teilnehmer verpflichtend  
- Specialty-Kurse werden nach bestimmten Voraussetzungen freigeschaltet  
​:codex-file-citation[codex-file-citation]{line_range_start=20 line_range_end=25 path=docs/entscheidungen/EEE_Projektentscheidungen_2025.md git_url="https://github.com/MSAlpaka/EquEdEU/blob/main/docs/entscheidungen/EEE_Projektentscheidungen_2025.md#L20-L25"}​

## Zertifikatslogik

- Digitale Zertifikate werden über das Modul `equed-cert` generiert  
- Öffentliche Verifikation per QR-Code und Suche unter `equed.eu/verify`  
- Rezertifizierungen sind nur für ausgewählte Programme nötig  
​:codex-file-citation[codex-file-citation]{line_range_start=81 line_range_end=89 path=docs/projektplan/EEE_HoofCare_Projektplan_v1.txt git_url="https://github.com/MSAlpaka/EquEdEU/blob/main/docs/projektplan/EEE_HoofCare_Projektplan_v1.txt#L81-L89"}​

Weitere Informationen zu Badges und Verifikation finden sich in [Badges and Certification](Badges-and-Certification.md).
