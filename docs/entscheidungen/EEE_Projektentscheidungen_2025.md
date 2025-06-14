
# Projektentscheidungen – EEE HoofCare (Stand: Juni 2025)

Dieses Dokument enthält die vollständige, strukturierte und optimierte Zusammenfassung aller getroffenen Projektentscheidungen für das EquEd-System.

## 1. Systemstruktur & Architektur
- Module: `equed-core`, `equed-auth`, `equed-lms`, `equed-cert`, `equed-qms`, `equed-instructor`, `equed-center`, `equed-admin`, `equed-app`, `equed-shop`
- Integration: App, Shop und LMS nutzen gemeinsames Auth-System (SSO)
- Recognition-Logik ist in `equed-cert` eingebettet
- `equed-shop` enthält das ehemalige `equed-commerce`

## 2. Rollen & Rechte
- **Teilnehmende**: nur eigener Fortschritt, Feedback und Prüfungsergebnisse
- **Instructor:innen**: Zugriff nur auf eigene Kurse und Bewertungen
- **Certifier**: Validierung von Prüfungen, keine SC-Zugriffe
- **ServiceCenter**: Eskalationen, Prüfzuweisung, QMS-Filter
- **Admin**: vollständiger Zugriff

## 3. Kursstruktur & Zertifizierung
- Struktur: Program → CourseInstance → UserCourseRecord
- Badges: Grau, Bronze, Silber, Gold; Specialty-Awards integriert
- Prüfungsstruktur: MC, Freitext, Uploads, Fallberichte
- GPT-Auswertung: Vorschlag + Instructor-Freigabe
- TrainingRecord (TR): Pflichtdokumentation pro Kurs & TN
- Specialtys freigeschaltet nach Voraussetzungen

## 4. Frontend- & App-Logik
- App: Uploads, Offline-Funktion, Badge-Status, keine Bewertung
- Sichtbarkeit:
  - Bewertung: nur "bestanden / nicht bestanden" oder kursabhängig mit Punkten
  - Zertifikate: Einzelseiten mit QR & Badge, kein globales Zertifikatsprofil

## 5. DSGVO & Sicherheit
- JWT, 2FA, Token-Blacklist
- Uploadverschlüsselung
- Feedback & GPT: pseudonymisiert, versioniert
- Profil-Sichtbarkeit & Datenschutzeinstellungen für Nutzende

## 6. QMS & Incident-System
- Falltypen: Incident, Complaint, Audit
- Nur ServiceCenter schließt QMS-Fälle ab (je nach Fall Certifier möglich)
- Instructor kann QMS-Marker im Kurs setzen

## 7. Glossar & Übersetzung
- EASY- und Fachmodus
- Vorschlagsfunktion über strukturiertes Formular
- GPT-Hybridübersetzung mit Fallback (EN > DE > EASY)

## 8. Zusatzfunktionen & Optionen
- Dropshipping: aktiv nur mit Kursstatus & Abo
- Rezertifizierung: nur bei bestimmten Kursen (z. B. EMT, REH)
- Specialty-Voraussetzungen pro Rolle (z. B. EMT = Pflicht für Instructor)
- Zertifikate einzeln teilbar
- Sichtbarkeit nicht bestandener Prüfungen: nur intern
- QMS-Feedback verpflichtend nur bei bestimmten Kursen

## 9. Optionale strategische Erweiterungen
- Community: Forum, Ask the Specialist, Events
- Gamification: Wochenchallenges, Levelsystem, Rankings
- Live-Module: Webinare, Live-Kurse
- Partnerportal: Hersteller, Sponsoren, Weiterbildungsnetzwerke
- Intelligente Empfehlungen: KI-basiert nach Ziel und Region

---

© 2025 Equine Education Europe Ltd.
