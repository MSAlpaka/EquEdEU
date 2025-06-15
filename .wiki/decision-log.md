# Decision Log

Diese Seite fasst die wichtigsten Projektentscheidungen zusammen.

## Kernpunkte (Stand Juni 2025)

1. **Modulstruktur**  
   - `equed-core`, `equed-auth`, `equed-lms`, `equed-cert`, `equed-qms`, `equed-instructor`, `equed-center`, `equed-admin`, `equed-app`, `equed-shop`  
   - App, Shop und LMS nutzen ein gemeinsames SSO  
​:codex-file-citation[codex-file-citation]{line_range_start=9 line_range_end=14 path=docs/entscheidungen/EEE_Projektentscheidungen_2025.md git_url="https://github.com/MSAlpaka/EquEdEU/blob/main/docs/entscheidungen/EEE_Projektentscheidungen_2025.md#L9-L14"}​

2. **Rollen**  
   - Teilnehmende, Instructor:innen, Certifier, ServiceCenter und Admin  
​:codex-file-citation[codex-file-citation]{line_range_start=15 line_range_end=19 path=docs/entscheidungen/EEE_Projektentscheidungen_2025.md git_url="https://github.com/MSAlpaka/EquEdEU/blob/main/docs/entscheidungen/EEE_Projektentscheidungen_2025.md#L15-L19"}​

3. **Kurse & Prüfungen**  
   - Struktur: Program → CourseInstance → UserCourseRecord  
   - GPT-Auswertung liefert Vorschläge, Instructor gibt final frei  
​:codex-file-citation[codex-file-citation]{line_range_start=20 line_range_end=25 path=docs/entscheidungen/EEE_Projektentscheidungen_2025.md git_url="https://github.com/MSAlpaka/EquEdEU/blob/main/docs/entscheidungen/EEE_Projektentscheidungen_2025.md#L20-L25"}​

4. **DSGVO & Sicherheit**  
   - JWT, 2FA, Token-Blacklist  
   - Uploads verschlüsselt  
   - Feedback und GPT-Daten sind pseudonymisiert und versioniert  
​:codex-file-citation[codex-file-citation]{line_range_start=33 line_range_end=37 path=docs/entscheidungen/EEE_Projektentscheidungen_2025.md git_url="https://github.com/MSAlpaka/EquEdEU/blob/main/docs/entscheidungen/EEE_Projektentscheidungen_2025.md#L33-L37"}​

5. **QMS**  
   - Falltypen: Incident, Complaint, Audit  
   - Nur ServiceCenter schließt Fälle endgültig ab  
​:codex-file-citation[codex-file-citation]{line_range_start=39 line_range_end=42 path=docs/entscheidungen/EEE_Projektentscheidungen_2025.md git_url="https://github.com/MSAlpaka/EquEdEU/blob/main/docs/entscheidungen/EEE_Projektentscheidungen_2025.md#L39-L42"}​

6. **Weiteres**  
   - Rezertifizierung nur bei bestimmten Kursen  
   - Specialty-Voraussetzungen pro Rolle (z. B. EMT-Pflicht für Instructoren)  
​:codex-file-citation[codex-file-citation]{line_range_start=49 line_range_end=55 path=docs/entscheidungen/EEE_Projektentscheidungen_2025.md git_url="https://github.com/MSAlpaka/EquEdEU/blob/main/docs/entscheidungen/EEE_Projektentscheidungen_2025.md#L49-L55"}​

Die ergänzende Datei `Projektentscheidungen.txt` fasst diese Punkte ebenfalls komprimiert zusammen:
​:codex-file-citation[codex-file-citation]{line_range_start=1 line_range_end=11 path=equed-core/Projektentscheidungen.txt git_url="https://github.com/MSAlpaka/EquEdEU/blob/main/equed-core/Projektentscheidungen.txt#L1-L11"}​
