# Architektur

Die Extension orientiert sich an Domain-Driven Design. Jedes Domain-Modell (z.B. `AuditLog` oder `DocumentUpload`) bildet eine eigenst\u00e4ndige fachliche Einheit ab. Laut Projektentscheidungen ist die Datenbankstruktur ab TYPO3 13 als YAML definiert, *"ext_tables.sql wird nicht mehr gepflegt"* (Projektentscheidungen Zeile 33100ff.).

Die aktuellen Schemadefinitionen liegen unter `Configuration/Schema/Domain/Model/` und werden von TYPO3 direkt zur Migration verarbeitet.
## QMS-Eskalationslogik

Gem\u00e4\u00df Projektentscheidungen sieht die Eskalationslogik mehrere Stufen vor. Bei fehlenden Instruktoren oder unbeantworteten Submissions informiert das System automatisch die zust\u00e4ndigen Rollen (Zeilen 32015-32025). Dabei wird ein Eskalationslevel von Erinnerung bis zur Sperrung durchlaufen (Zeilen 32033-32039).

## Integration mit equed-lms

Einige Tabellen wie `Language` werden projektspezifisch auch im LMS genutzt. Das Upload-Handling wird \u00fcber das Domain-Modell `DocumentUpload` geteilt.

## Sicherheitsmodell

Der Projektplan definiert die Rollen *Teilnehmer:in, Instructor, Certifier, ServiceCenter* (Zeile 18). Zugriff und Sichtbarkeit werden rollenbasiert gesteuert (Zeile 53).

## \u00dcbersetzungs-Workflow

Der `GptTranslationService` erm\u00f6glicht eine hybride \u00dcbersetzung, wobei die Standardsprache EN durch DE, FR, ES, SW und EASY erg\u00e4nzt wird (Projektplan Zeilen 41-44). Die Serviceklasse generiert Vorschl\u00e4ge, die laut Projektentscheidungen manuell best\u00e4tigt werden m\u00fcssen (Zeilen 27570-27594).
