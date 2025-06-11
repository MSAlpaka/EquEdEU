## 📦 CHANGELOG – EquEd LMS Extension

### [1.1.0] – Erweiterungen & Vollintegration (SSO, App, QMS)

#### ✅ Neue Features

- 🔐 **SSO / API-Login via Token**
  - `AuthController::tokenLoginAction()` erstellt
  - `TokenService` für `fe_users.api_token`
  - Middleware-Integration mit `X-Equed-Token` Header
  - neue Route `/auth/token` per `Routes.yaml`

- 🤝 **ServiceCenter-Dashboard (API)**
  - voll API-basiertes SC-Frontend
  - `ServiceCenterDashboardApiController` + `ServiceCenterDashboardService`
  - Zugriffsschutz & Tokenprüfung via Middleware
  - SPA-ready Datenstruktur für Zertifikate, QMS, Submissions

- 🤖 **GPT-basierte Feedback-Analyse**
  - `FeedbackAnalysisService` integriert OpenAI GPT für Freitext
  - automatische Bewertungsvorschläge (`suggestedRating`)
  - `AnalyzePendingFeedbackCommand` (CLI/Scheduler)
  - `Feedback`-Modell erweitert um `analysisSummary`, `analysisTopics`, `suggestedRating`

- 📬 **Auto-Freigabe nach Feedback**
  - `CourseCompletionValidatedEvent` + `AutoCertificationListener`
  - Bewertungsschwelle definierbar (z. B. GPT ≥ 3.5)
  - `CourseStatusUpdaterService` triggert Zertifikat + Notifikation

- ⚠️ **QMS-Eskalation**
  - `QmsCaseEscalatedEvent` + Listener
  - `QmsEscalationService` erstellt PDF & sendet Mail an Admin + SC
  - `TrainingCenter.php` + `getServiceCenter()->getEmail()` logisch integriert

---

### 🔧 Erweiterungen bestehender Dateien

- `Routes.yaml`: neue Routen für SC, Auth, Token, Dashboard
- `ApiTokenMiddleware.php`: erweitert für neue API-Zugänge (auth, SC, token)
- `ext_tables.sql`: ergänzt um `api_token` für fe_users
- `TCA/Overrides/fe_users.php`: neues Feld `api_token` im Backend sichtbar

---

### 🛠 Verbesserungen

- 🔁 Repositories um neue Query-Methoden ergänzt:
  - `FeedbackRepository::findByUserAndCourse()`
  - `FeedbackRepository::findUnanalyzed()`
- 🧪 alle EventListener in `ext_localconf.php` korrekt registriert
- 🔍 vollständiger SPA-/App-Datenfluss für:
  - Lektionen, Progress, Zertifikate, Kursdaten, QMS

---

### [1.0.0] – Initial Stable Release (Live-System)

*(siehe vorherige Version für Details)*