# NetManagement Testing Matrix

The Playwright browser suite in `tests/e2e` is the executable baseline for seeded
accounts and end-to-end role workflows. Run tests against a dedicated test or
local development database:

```bash
php artisan migrate --seed --force
php artisan serve
npm run test:e2e
```

Run specific test suites or modes:

```bash
# Run tests with interactive UI
npm run test:e2e:ui

# Run in headed browser mode
npm run test:e2e:headed

# Run specific spec
npx playwright test tests/e2e/customer.spec.ts
npx playwright test tests/e2e/admin.spec.ts
```

| Category | Playwright & PHPUnit Coverage | Additional Execution |
| --- | --- | --- |
| UAT | Customer portal, payment flows, technician task execution | Business owner validates acceptance criteria |
| Alpha | Admin and marketing lead conversion flows | Internal defect triage |
| System / E2E | Multi-role workflow: Lead -> Customer -> Ticket -> Billing | Run with production-like integrations |
| Regression | Core route and authorization checks across all 5 roles | Run on CI (`.github/workflows/ci.yml`) |
| Smoke | Public home, login validation, and all role dashboards | Automated in `login.spec.ts` |
| Sanity | Authentication, password reset, profile navigation | Automated in PHPUnit and Playwright |
| Exploratory | Navigation continuity, form controls, responsive viewport | Charter-based manual sessions |
| Performance / Load | Backend queries & database indexing | k6/JMeter against isolated environment |
| Stress | Queue workers & Node.js WhatsApp gateway under load | Synthetic load test |
| Usability | Mobile responsive viewport checks (`390x844`) | Automated in `customer.spec.ts` |
| Security / Penetration | Boundary checks, cross-role 403, and active token guards | Automated in PHPUnit and Playwright boundary tests |
| Compatibility | Desktop & mobile browser engines (Chromium, Firefox, WebKit) | Configured in `playwright.config.ts` |
