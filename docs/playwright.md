# Playwright E2E Testing

The Playwright suite covers public navigation, authentication,
inactive-account rejection, customer billing/complaints, and full internal
staff workflows across Super Admin, Admin, Marketing, and Technician roles.

## Prerequisites

Use a dedicated local or CI database. Do not point E2E tests at production.
Start the local application server first when testing locally:

```bash
php artisan migrate --seed --force
php artisan serve
```

Install dependencies and browsers:

```bash
npm ci
npx playwright install chromium firefox webkit
```

Set credentials for the seeded test accounts. These are test-only credentials,
not production secrets:

```bash
export E2E_BASE_URL=http://127.0.0.1:8000
export E2E_CUSTOMER_EMAIL=budi@netmanager.local
export E2E_INACTIVE_EMAIL=customer@gmail.com
export E2E_TEST_PASSWORD=password
```

Playwright can also start `php artisan serve` automatically if the server is not already running.

## Commands

Run all browsers and tests:

```bash
npm run test:e2e
```

Run the interactive UI:

```bash
npm run test:e2e:ui
```

Run headed browsers:

```bash
npm run test:e2e:headed
```

Run one spec or one test:

```bash
npx playwright test tests/e2e/customer.spec.ts
npx playwright test -g "inactive account"
```

Typecheck the config and tests:

```bash
npm run typecheck:e2e
```

Open the HTML report after a run:

```bash
npm run test:e2e:report
```

Failures retain screenshots, traces on retry, and videos only when a test
fails. Authentication state is generated locally under `playwright/.auth/` and
is ignored by Git.
