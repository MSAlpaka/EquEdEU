# Security and DSGVO

**Inhalt**

1. [Authentifizierung](#authentifizierung)
2. [Datenschutz](#datenschutz)
3. [Rollenbasierte Sichtbarkeit](#rollenbasierte-sichtbarkeit)

## Authentifizierung

- JWT-basierte Authentifizierung mit Login, Logout und Refresh  
- Optionale Zwei-Faktor-Authentifizierung (TOTP)  
​:codex-file-citation[codex-file-citation]{line_range_start=19 line_range_end=24 path=docs/projektplan/EEE_HoofCare_Projektplan_2025.md git_url="https://github.com/MSAlpaka/EquEdEU/blob/main/docs/projektplan/EEE_HoofCare_Projektplan_2025.md#L19-L24"}​

## Datenschutz

- Token-Blacklist und Upload-Verschlüsselung  
- Pseudonymisierte GPT- und Feedback-Daten  
​:codex-file-citation[codex-file-citation]{line_range_start=33 line_range_end=37 path=docs/entscheidungen/EEE_Projektentscheidungen_2025.md git_url="https://github.com/MSAlpaka/EquEdEU/blob/main/docs/entscheidungen/EEE_Projektentscheidungen_2025.md#L33-L37"}​

## Rollenbasierte Sichtbarkeit

Zugriff auf Kurse, Zertifikate und QMS-Daten erfolgt strikt nach Rolle:

- Teilnehmer:innen sehen nur eigene Daten  
- Instructor:innen sehen nur ihnen zugewiesene Kurse  
- Certifier und ServiceCenter haben erweiterte Rechte  
​:codex-file-citation[codex-file-citation]{line_range_start=15 line_range_end=19 path=docs/entscheidungen/EEE_Projektentscheidungen_2025.md git_url="https://github.com/MSAlpaka/EquEdEU/blob/main/docs/entscheidungen/EEE_Projektentscheidungen_2025.md#L15-L19"}​

Öffentliche Zertifikate können über einen QR-Link verifiziert werden, weitere Daten werden nur mit Einwilligung sichtbar.
