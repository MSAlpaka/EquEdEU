
# EEE HoofCare – Projektplan (Stand: Juni 2025)

## 1. Projektziele
- Modulare Ausbildung zur Barhufbearbeitung auf EQF-Level 3–5
- Vollständige Digitalisierung: LMS + React-App + Zertifizierungslogik
- Qualitätsmanagement (ISO 17024, AZAV), Anerkennungsstruktur
- Shop-Anbindung & Factoring für aktive Nutzer:innen

## 2. Technische Systemarchitektur

### 2.1 `equed-core`
- Übersetzung (EN, DE, FR, ES, SW, EASY)
- Glossarverwaltung mit EASY-Versionen
- Organisationsstruktur (Center, Regionen)
- Nutzerverwaltung, Upload-Handling
- YAML-Settings, DSGVO-konform

### 2.2 `equed-auth`
- JWT-basierte Authentifizierung (Login, Logout, Refresh)
- SSO-fähige Architektur (App, Shop, LMS, Admin)
- Rollenbasierte Claims
- TOTP-basierte 2FA
- Passwort-Reset, Userinfo-Endpoint
- Zentrale Token-Verwaltung

### 2.3 `equed-lms`
- Kursstruktur (Program > Instance > UserRecord)
- Module, Lessons, Prüfungen, GPT-Auswertung
- Feedbacksystem (freiwillig, anonymisiert)
- Fortschritt & Badge-Vergabe
- Instructor-Dashboard & Prüfungstools

### 2.4 `equed-cert`
- Digitale Zertifikate mit QR, PDF, C-Cards
- Badge-System (Grau bis Gold)
- CrossOver & externe Anerkennung (`equed-recognition` integriert)
- Rezertifizierungslogik bei Spezialkursen

### 2.5 `equed-qms`
- Falltypen: Incident, Complaint, Audit
- QMS-Dashboard für Certifier & ServiceCenter
- GPT-unterstützte Auswertung bei Feedback/Prüfung
- Dokumentation von Verstößen gegen Standards

### 2.6 `equed-instructor`
- Kursübersicht und Bewertung für Instructor:innen
- Zugriff auf Submissions, Fortschritte, Feedback
- Rolle klar getrennt von Center & Admin

### 2.7 `equed-center`
- Zentrale Kursverwaltung (eigenes Center)
- Instructor-Zuweisung & Standortsteuerung
- Kursmaterial-Management
- Schnittstelle zum Shop (Dropshipping)

### 2.8 `equed-admin`
- Gesamtsicht auf alle Systembereiche
- Benutzerverwaltung, Freigaben, Statistik
- Glossarredaktion, Fehlerberichte, QMS-Verwaltung

### 2.9 `equed-app` (React)
- Mobiler Kurszugriff, Offlinefähigkeit
- Foto-Uploads & Fallberichte
- Zertifikatsanzeige mit QR
- Zielpfad-Funktion („Ich will Esel bearbeiten“)
- Kein Zugriff auf Bewertung / Zertifizierung

### 2.10 `equed-shop`
- Dropshipping-Funktion für aktive Teilnehmende
- Aboverwaltung (Pro-Funktionen, Factoring)
- Fakturierung & Integration mit Nutzerstatus
- Ersetzt `equed-commerce` (nicht separat)

## 3. Rollen & Rechte

| Rolle        | Beschreibung |
|--------------|--------------|
| Teilnehmer:in | Kursbuchung, Bearbeitungen, Feedback |
| Instructor    | Durchführung, Bewertung, keine Kurserstellung |
| Certifier     | Prüfung, Zertifikatsfreigabe, QMS-Bearbeitung |
| ServiceCenter | Eskalation, Koordination, Zertverifikation |
| Admin         | Volle Systemrechte |

## 4. Sicherheit & DSGVO
- JWT, 2FA, Token-Blacklist
- Upload-Verschlüsselung
- Sichtbarkeit strikt rollenbasiert
- Feedback & GPT-Auswertung anonymisiert & versioniert

## 5. Zeitplan (Roadmap, Auszug)
- Juli 2025: equed-core, equed-lms, equed-auth
- August: cert, qms, app
- September: instructor, center, erste Kurse
- Oktober: admin, shop, Livesystem

---

© 2025 Equine Education Europe Ltd.
