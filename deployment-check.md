# ✅ EquEd LMS Deployment Check

## 🔐 Security
- [ ] .env-Datei korrekt gesetzt
- [ ] JWT-Secret gesetzt
- [ ] Admin-BE-User aktiv
- [ ] Fileadmin- und Uploads-Berechtigungen eingeschränkt

## ⚙️ System
- [ ] Composer autoload funktioniert
- [ ] Datenbank erreichbar
- [ ] API-Keys gesetzt (GPT, Stripe)
- [ ] Logging-Verzeichnis beschreibbar: var/log
- [ ] Pre-commit-Hook installiert (`php-cs-fixer`)

## 🌍 App & API
- [ ] Token-Login funktioniert
- [ ] Instructor- und SC-Rollen greifen korrekt
- [ ] Zertifikate werden ausgelöst
- [ ] QMS-Workflow getestet

## 🔁 Tests
- [ ] PHPUnit-Tests laufen (optional)
- [ ] Model/TCA/YAML konsistent
- [ ] CLI-Commands registriert
