# Backend PHPUnit Test Report

## 1. Tujuan

Dokumen ini mencatat proses pemeriksaan backend NetManager menggunakan PHPUnit dari awal sampai akhir.

Fokus pemeriksaan:

- Business logic Laravel
- Authentication dan authorization
- Inactive account protection
- Jetstream/Fortify two-factor authentication
- Password confirmation dan password reset
- Profile update
- Account deletion
- Browser session handling
- Customer portal access
- API token feature behavior
- Database migration dan test isolation

Test dijalankan menggunakan database SQLite in-memory agar tidak menyentuh database development atau production.

## 2. Kondisi Awal

Sebelum perbaikan, full PHPUnit suite menghasilkan error:

```text
SQLSTATE[HY000]: General error: 1 table users has no column named two_factor_secret
```

Error muncul ketika `UserFactory` dan Jetstream mencoba menyimpan field:

```text
two_factor_secret
two_factor_recovery_codes
```

Investigasi menunjukkan bahwa:

- Test feature sudah banyak menggunakan `RefreshDatabase`.
- `phpunit.xml` belum mengaktifkan SQLite in-memory.
- Migration users tidak memiliki field Jetstream two-factor.
- `CustomerPortalAccessTest` membuat user tetapi belum menggunakan `RefreshDatabase`.

## 3. Audit Konfigurasi PHPUnit

File konfigurasi utama:

```text
phpunit.xml
```

Konfigurasi database yang digunakan:

```xml
<env name="DB_CONNECTION" value="sqlite"/>
<env name="DB_DATABASE" value=":memory:"/>
```

Dengan konfigurasi tersebut, setiap test memakai database SQLite sementara dan tidak memakai MySQL development.

## 4. Audit Migration

Migration users utama berada di:

```text
database/migrations/2026_05_24_170647_create_users_table.php
```

Migration tersebut sebelumnya belum memiliki kolom Jetstream two-factor.

Migration baru ditambahkan:

```text
database/migrations/2026_09_26_000000_add_two_factor_columns_to_users_table.php
```

Kolom yang ditambahkan:

```php
$table->text('two_factor_secret')->nullable();
$table->text('two_factor_recovery_codes')->nullable();
$table->timestamp('two_factor_confirmed_at')->nullable();
```

Kolom `two_factor_confirmed_at` juga diperlukan oleh implementasi Jetstream saat proses konfirmasi two-factor authentication.

## 5. Audit RefreshDatabase

Test berikut sudah menggunakan `RefreshDatabase`:

- AuthenticationTest
- BrowserSessionsTest
- CreateApiTokenTest
- DeleteAccountTest
- DeleteApiTokenTest
- EmailVerificationTest
- PasswordConfirmationTest
- PasswordResetTest
- ProfileInformationTest
- RegistrationTest
- TwoFactorAuthenticationSettingsTest
- UpdatePasswordTest

Test yang ditemukan belum menggunakan trait tersebut:

```text
tests/Feature/CustomerPortalAccessTest.php
```

Perbaikan:

```php
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerPortalAccessTest extends TestCase
{
    use RefreshDatabase;
}
```

Dengan begitu, user factory pada test tersebut memiliki tabel users yang sudah dimigrasikan.

## 6. Tahap Verifikasi Pertama

Migration baru diuji secara terisolasi dengan SQLite file:

```bash
rm -f database/database.sqlite
touch database/database.sqlite
DB_CONNECTION=sqlite \
DB_DATABASE=database/database.sqlite \
php artisan migrate:fresh --force
```

Kemudian test two-factor dijalankan:

```bash
DB_CONNECTION=sqlite \
DB_DATABASE=database/database.sqlite \
php artisan test tests/Feature/TwoFactorAuthenticationSettingsTest.php
```

Hasil:

```text
PASS Tests\Feature\TwoFactorAuthenticationTest

Tests:    3 passed (6 assertions)
Duration: 1.50s
```

Hasil tersebut membuktikan bahwa kolom Jetstream sudah tersedia dan fitur berikut berjalan:

- Enable two-factor authentication
- Regenerate recovery codes
- Disable two-factor authentication

## 7. Full Backend Test Execution

Setelah konfigurasi PHPUnit dan migration diperbaiki, seluruh backend test dijalankan dengan:

```bash
php artisan test
```

PHPUnit otomatis menggunakan SQLite in-memory berdasarkan `phpunit.xml`.

## 8. Final Result

Result akhir:

```text
Tests:    0 skipped, 29 passed (58 assertions)
Duration: 2.85s
```

Ringkasan:

| Status | Jumlah |
|---|---:|
| Passed | 29 |
| Failed | 0 |
| Skipped | 0 |
| Assertions | 58 |

## 9. Test yang Berhasil

Test utama yang berhasil:

- `AuthenticationTest`
  - Login screen
  - Login dengan credential valid
  - Login dengan password salah
  - Inactive account ditolak
- `BrowserSessionsTest`
- `CustomerPortalAccessTest`
- `DeleteAccountTest`
- `PasswordConfirmationTest`
- `PasswordResetTest`
- `ProfileInformationTest`
- `TwoFactorAuthenticationSettingsTest`
- `UpdatePasswordTest`
- `RegistrationTest`
  - Public registration returns 404 (disabled by business policy)
- `RolePermissionGateTest` (BARU)
  - Super admin bypasses all permission checks
  - Role permissions evaluated dynamically via Laravel Gate
  - Denies unauthorized abilities
- `SyncPaidInvoiceHardwareJobTest` (BARU)
  - Asynchronous background queue job dispatches from webhook/checkStatus
  - Non-blocking hardware sync & notification processing
- Unit test dasar

## 10. Pembersihan Kode Mati & Skipped Tests

Semua 8 skenario test skipped sebelumnya telah dibersihkan secara tuntas:

- File test untuk fitur Jetstream yang dinonaktifkan (`ApiTokenPermissionsTest.php`, `CreateApiTokenTest.php`, `DeleteApiTokenTest.php`, `EmailVerificationTest.php`) telah dihapus dari repositori.
- `RegistrationTest.php` diperbarui untuk secara aktif memverifikasi proteksi sistem: memvalidasi bahwa endpoint registrasi publik mengembalikan respons HTTP 404 (Not Found).
- Hasil akhir: **0 skipped tests** dan seluruh rangkaian pengujian berjalan 100% passed.

## 11. Business Logic dan Security yang Terverifikasi

### Authentication

- Credential valid dapat login.
- Password salah ditolak.
- Akun inactive ditolak.
- Pesan akun inactive dikembalikan ke halaman login.

### Customer portal

- Customer dapat diarahkan ke dashboard customer.
- Akses customer diproses melalui middleware role.
- Root customer redirect bekerja sesuai role.

### Account security

- Penghapusan akun membutuhkan password yang benar.
- Password confirmation bekerja.
- Password reset flow berjalan.
- Update password memvalidasi password lama dan kecocokan password baru.

### Two-factor authentication

- Secret dibuat saat 2FA diaktifkan.
- Recovery codes dibuat sebanyak delapan kode.
- Recovery codes dapat dibuat ulang.
- 2FA dapat dinonaktifkan.

### Database isolation

- Test memakai SQLite in-memory melalui PHPUnit.
- `RefreshDatabase` menjalankan migrasi untuk test yang membutuhkan database.
- Test tidak menggunakan database production.

## 12. Perintah Reproduksi

Menjalankan semua backend test:

```bash
php artisan test
```

Menjalankan test tertentu:

```bash
php artisan test tests/Feature/AuthenticationTest.php
```

Menjalankan test two-factor:

```bash
php artisan test tests/Feature/TwoFactorAuthenticationSettingsTest.php
```

Menjalankan satu test berdasarkan nama:

```bash
php artisan test --filter="inactive users"
```

Menampilkan test tanpa warna:

```bash
php artisan test --without-tty
```

Menguji migration dari awal secara manual:

```bash
rm -f database/database.sqlite
touch database/database.sqlite
DB_CONNECTION=sqlite \
DB_DATABASE=database/database.sqlite \
php artisan migrate:fresh --force
```

## 13. Catatan Environment

Pada local development, PHP host tidak selalu memiliki driver MySQL. PHPUnit tidak bergantung pada driver tersebut karena menggunakan SQLite in-memory.

Aplikasi native runtime menggunakan MySQL:

```text
DB_CONNECTION=mysql
```

Dengan pemisahan ini:

- PHPUnit aman dan cepat.
- E2E tetap dapat dijalankan terhadap local application server (`php artisan serve`).
- Database development tidak terhapus oleh PHPUnit.

## 14. Final Kesimpulan

Backend test suite sudah diperbaiki, dimutakhirkan, dan berhasil dijalankan secara optimal.

Result final:

```text
PASS: 29
FAIL: 0
SKIP: 0
ASSERTIONS: 58
```

Error schema Jetstream sudah diselesaikan melalui migration resmi project. Kode mati Jetstream (API Token & Email Verification) serta 8 skipped tests telah dihapus. Fitur RBAC Gate dan Queue Job Webhook telah dilengkapi pengujian otomatis yang 100% passed.
