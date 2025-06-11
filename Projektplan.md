# EEE HoofCare – Vollständiger Projektplan

## 1. Projektziele und Vision
- Etablierung eines modularen Ausbildungssystems für Barhufbearbeitung.
- Digitales und praxisnahes Lernen via LMS & App.
- Vollständige Umsetzung aller Standards (EQF, ISO, AZAV, ZFU).
- Integration von Dropshipping, Recognition Awards, QMS, Factoring.

## 2. Technische Systemarchitektur

### 2.1 equed-core
- GPT Translation Service für EN, DE, FR, ES, SW, EASY.
- DSGVO-konforme Verarbeitung, konfigurierbare YAML-Settings.

### 2.2 equed-lms
- Kursstruktur: CourseProgram → CourseInstance → UserCourseRecord.
- Funktionen: Module, Lessons, Quizzes, Submissions, Fortschritt.
- Rollen: Teilnehmer:in, Instructor, Certifier, ServiceCenter.
- Glossar mit Fach- & EASY-Definitionen.

### 2.3 equed-cert
- QR-Zertifikate mit Badge-Logik, Farbcode & Öffentlicher Seite.
- Zertifizierung durch Instructor oder ServiceCenter.
- CrossOver-Logik & externe Anerkennungen integriert.

### 2.4 equed-qms
- Falltypen: SystemIncident, GlobalComplaint, QmsAudit.
- GPT-Auswertung bei Feedback & Prüfungsantworten.
- Admin- & Certifier-Workflow.

### 2.5 App (React-basiert)
- Offlinefähig, SPA, Kursansicht, Badge-Status.
- Uploads (Kamera), kein Zugriff auf Bewertung oder QMS.

## 3. Funktionale Besonderheiten
- Fortschrittsanzeige: Prozentbalken + Badge.
- Wiederholungsmöglichkeit bei Nichtbestehen.
- Instructor-Bereich mit Uploads, Bewertungen, Prüfungstatus.
- Specialty-Kurse mit Voraussetzungen.

## 4. Sprachen & Übersetzung
- Sprachen: EN (default), DE, FR, ES, SW + EASY.
- Hybrid-Übersetzung über GPT mit `GptTranslationService`.
- Technische Umsetzung: Fallbacklogik, Übersetzungsfiles, YAML/LLL.

## 5. Zertifizierungsstruktur
- Badge-Stufen: Grau, Bronze, Silber, Gold.
- Recognition Award (Advanced Specialist).
- Digitale QR-Zertifikate, öffentlicher Verifizierungslink.

## 6. Sicherheit & DSGVO
- Login via JWT, optional 2FA.
- Rollenbasierte Sichtbarkeit & Zugriff.
- Uploads verschlüsselt gespeichert.

## 7. Zeitplan 2025
- Mai–Juli: Implementierung Core, LMS, Zertifizierung.
- August–Oktober: App, Dropshipping, Recognition-System.
- September: Betatests, Liveschaltung, Zertifikatsfunktion.

## 8. Umsetzungsmethodik
- Command → Execute: Nur du steuerst Aufgaben.
- Keine Skeletons, keine Vorschläge ohne Kontext.
- Ziel: Perfekter, produktionsreifer Code mit echtem Inhalt.

---

© 2025 Equine Education Europe Ltd. | EEE HoofCare | All rights reserved.


## 🔄 Ergänzungen (Mai 2025)

### Update zu 2.3 equed-cert
- Zertifizierung erfolgt wahlweise durch Instructor, Certifier oder ServiceCenter, abhängig vom Kurs.
- Specialty-Kurse können individuell konfiguriert werden (z. B. requiresExternalValidation = true → Certifier oder ServiceCenter).

### Ergänzung zu 2.4 equed-qms
- Eskalationslogik: Certifier bearbeitet einfache Fälle; ServiceCenter übernimmt bei QMS-relevanten Verstößen oder tierschutzrelevanten Situationen.
- Strukturierte Dokumentations- & Feedbackpflicht für Specialty-Prüfungen integriert.

### Ergänzung zu 5. Zertifizierungsstruktur
- Rezertifizierungen sind nicht generell vorgesehen.
- Für ausgewählte Programme (z. B. Rehabilitation HoofCare, Emergency & Triage) erfolgt eine Pflichtaktualisierung alle 3 Jahre via Kurzmodul oder Fallbericht.
- Automatische Erinnerungslogik im LMS wird implementiert.

### Ergänzung zu 2.3 und öffentlich sichtbarer Zertifikatsverifikation
- Öffentliche Zertifikatsseite erreichbar über QR-Code.
- Zusätzlich: Öffentliche Suchfunktion unter equed.eu/verify (Suchkriterien: Name, Kurs, Zert-Nr.).
- Optional verknüpfbar mit öffentlichem Nutzerprofil bei aktiver Freigabe.

### Ergänzung zu 1. Projektziele
- Alle Curricula basieren auf EQF-kompatiblen Lernzielen (Level 3–5) und erfüllen ISO 17024–relevante Anforderungen.
- Die Programmlogik ist so aufgebaut, dass Qualitätssicherung und externe Anerkennung (z. B. ZFU, MFHEA) möglich sind.

## 🔄 Ergänzungen (Mai 2025 – vollständig)

### Update zu 2.2 equed-lms
- GPT-basierte Auswertung von Fallarbeiten ist systemseitig integriert.
- Instructor muss GPT-Vorschläge bestätigen oder korrigieren (kein Autopass).
- Bewertungsstruktur: freie Gewichtung möglich, automatische Rasterprüfung, Versionierung aktiv.
- Instructor-Overrides werden systemisch dokumentiert.
- Feedbacksystem: freiwillig, Instructor sieht Feedback nur bei expliziter Freigabe durch TN.
- Durchschnittliche Bewertungen sind nur intern sichtbar.
- Feedbackexport ist für Admin und ServiceCenter möglich.

### Update zu 2.5 App (React-basiert)
- App ist für alle aktiven Kursteilnehmenden kostenlos.
- Keine Abo-Stufen, stattdessen zubuchbare Module:
  - Pro-Funktionen (Kamera, Berichte): 14,90 €/Monat
  - Dropshipping: 2 €/Monat
  - Factoring: 3 % vom Rechnungsbetrag
- Instructor:innen erhalten Pro-Zugang dauerhaft kostenlos.
- Zielpfad-Funktion aktiv („Ich will Esel bearbeiten“).
- Öffentliche Profile nur per aktivem Opt-in sichtbar.

### Update zu 4. Sprachen & Übersetzung
- EASY-Versionen sind optional aktivierbar im Profil oder Kurs.
- Standardsprachen (EN, DE, FR, ES, SW) werden automatisch veröffentlicht.
- EASY & kritische Inhalte benötigen manuelle Freigabe durch Redaktion/Admin.
- Sprachwahl im Profil jederzeit umstellbar.

### Update zu 6. Sicherheit & DSGVO
- GPT-Bewertungen werden versioniert und mit Instructor-Override dokumentiert.
- Bilder in Fallarbeiten werden nicht durch GPT ausgewertet – Instructor bewertet diese manuell.

### Ergänzung zu 7. Zeitplan 2025
- Mai–Juni: finale Definition Feedback, GPT, Preisstruktur, App-Module
- Juli: Abrechnungssystem & Recognition-Logik
- August–Oktober: Livesystem, App-Zielpfade, Easy-Übersetzung, Betatest