# NetManagement Testing Matrix

The browser suite in `tests/Browser` is the executable baseline for the seeded
accounts and role-based workflows. Run it against a dedicated test database,
not a development or production database.

```powershell
php artisan db:seed
php artisan serve
php artisan dusk
```

Run one testing category with PHPUnit groups:

```powershell
php artisan dusk --group=smoke
php artisan dusk --group=security
php artisan dusk --group=e2e
```

| Category | Dusk coverage | Additional execution |
| --- | --- | --- |
| UAT | Role dashboards, customer complaint entry, operational pages | Business owner validates acceptance criteria |
| Alpha | Admin and marketing operational pages | Internal defect triage |
| Beta | Public registration entry point and seeded user flows | Pilot users and representative browsers |
| System / E2E | Role navigation and customer-to-support entry flow | Run with production-like integrations |
| Regression | Dashboard and core route smoke across every role | Run after every release |
| Smoke | Public home, registration, and all role dashboards | Run before deeper suites |
| Sanity | Authenticated dashboard-to-profile navigation | Run after a focused change |
| Exploratory | Navigation continuity and form-control checks | Charter-based manual sessions |
| Performance / Load | No reliable latency assertion belongs in Dusk | k6/JMeter against an isolated environment |
| Stress | Not a browser assertion | Increase load until the agreed failure threshold |
| Usability | Complaint form labels, controls, and navigation | Observe representative users |
| Security / Penetration | Role page coverage and session boundary baseline | OWASP ZAP/Burp plus API and authorization tests |
| Compatibility | Responsive browser controls and standard HTML controls | Matrix of supported Chrome, Edge, Firefox, and viewport sizes |

The suite intentionally does not claim that a page is secure, performant, or
usable merely because it rendered. Those categories require dedicated tools,
test data, thresholds, and human observation.
