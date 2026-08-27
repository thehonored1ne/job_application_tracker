---
title: Application Security & OWASP Top 10 Defense Guidelines
description: Security architecture, OWASP Top 10 mitigation matrix, authentication hardening, and upload safeguards.
category: security
tags: [security, owasp, owasp-top-10, authentication, authorization, data-protection, xss, csrf, uploads, job-tracker]
last_updated: 2026-08-28
status: active
---

# Application Security & OWASP Top 10 Defense Guidelines

## 1. OWASP Top 10 Compliance Matrix

| OWASP Category | Threat Description | Application Mitigation Strategy |
| :--- | :--- | :--- |
| **A01: Broken Access Control** | Unauthorized access to user records or administrative panels | `FilamentUser` panel contract, Model Policies, route-level auth middleware |
| **A02: Cryptographic Failures** | Exposure of sensitive data, weak password hashes | Bcrypt (cost 12), encrypted session cookies (`EncryptCookies`), `.env` isolation |
| **A03: Injection (SQL / XSS / Command)** | Untrusted input evaluated as code or SQL | Eloquent parameterized queries, Blade auto-escaping `{{ }}`, Symfony HTML sanitizer |
| **A04: Insecure Design** | Architectural flaws without security controls | Enforced business rules via backed Enums, form validation schemas, rate limiting |
| **A05: Security Misconfiguration** | Leaked stack traces, insecure defaults, exposed `.env` | `APP_DEBUG=false` in production, `.gitignore` `.env`, strict storage permissions |
| **A06: Vulnerable & Outdated Components** | Vulnerabilities in Composer/NPM packages | Automated `composer audit` in CI pipeline (`.github/workflows/ci.yml`) |
| **A07: Identification & Auth Failures** | Brute force login, session hijacking | Filament login rate throttling, session regeneration on login/logout |
| **A08: Software & Data Integrity Failures** | Malicious file uploads, tampered dependencies | MIME/extension whitelisting, randomized file hashes, `composer.lock` hash verification |
| **A09: Security Logging & Monitoring Failures** | Unmonitored intrusions or repeated auth failures | Laravel Monolog logger (`storage/logs/laravel.log`), exception reporting |
| **A10: Server-Side Request Forgery (SSRF)** | Exploitation of external URL fetchers (Job links) | URL scheme validation (`http`/`https` only), prohibition of internal IP ranges (`127.0.0.1`, `10.0.0.0/8`, `192.168.0.0/16`) |

---

## 2. Authentication & Access Control (A01, A07)

### 2.1 Panel Gatekeeper (`FilamentUser` Contract)
The `User` model implements Filament's `FilamentUser` contract:
```php
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    public function canAccessPanel(Panel $panel): bool
    {
        return app()->isLocal() || $this->hasVerifiedEmail();
    }
}
```

### 2.2 Rate Limiting & Brute Force Prevention
- The `/admin/login` endpoint is protected by rate limiting middleware to prevent credential stuffing and brute force attacks.
- Passwords are encrypted using Bcrypt hashing with standard work factors.

### 2.3 Session Hardening
- **Cookie Security**: Session cookies enforce `HttpOnly`, `SameSite=Lax`, and `Secure` attributes.
- **Session Fixation Defense**: Session identifiers are automatically regenerated upon authentication and privilege changes.

---

## 3. Data Protection & Injection Defense (A02, A03)

### 3.1 SQL Injection Prevention
- All database operations utilize Eloquent ORM or parameterized PDO prepared statements.
- Raw SQL string interpolation is prohibited.

### 3.2 Cross-Site Scripting (XSS) Prevention
- Output rendered in Blade templates uses auto-escaping syntax (`{{ $variable }}`).
- Rich text fields are sanitized to remove malicious tags (`<script>`, `<iframe>`, `javascript:` URI schemes).

### 3.3 Mass Assignment Protection
- All Eloquent models explicitly define `$fillable` attribute whitelists.
- Unsanitized `request()->all()` inputs are never passed directly to model persistence methods.

### 3.4 Cross-Site Request Forgery (CSRF)
- State-changing requests (POST, PUT, PATCH, DELETE) are guarded by Laravel's `VerifyCsrfToken` middleware.

---

## 4. File Upload Security (A08)

### 4.1 MIME Type & Extension Whitelist
Upload fields enforce strict validation:
- **Resumes & Documents**: `.pdf`, `.docx` (MIME: `application/pdf`, `application/vnd.openxmlformats-officedocument.wordprocessingml.document`).
- **Company Logos**: `.png`, `.jpg`, `.jpeg`, `.webp`, `.svg` (MIME: `image/png`, `image/jpeg`, `image/webp`, `image/svg+xml`).
- **Forbidden Extensions**: Executable and script extensions (`.php`, `.phtml`, `.exe`, `.sh`, `.bat`, `.js`, `.phar`, `.pl`) are strictly blocked.

### 4.2 File Renaming & Path Traversal Defense
- Uploaded files are stored with random hashes (`hashName()`) rather than original client-provided filenames.
- Files are placed on the `public` disk (`storage/app/public`) and accessed via symbolic links (`public/storage`).

### 4.3 Upload Size Constraints
- **Resumes**: Maximum `5120 KB` (5 MB).
- **Logos**: Maximum `2048 KB` (2 MB).

---

## 5. Secrets, Logging & Monitoring (A05, A06, A09, A10)

### 5.1 Environment Integrity
- `.env` files are kept out of source control.
- `APP_DEBUG` is set to `false` in production environments to avoid disclosing system internals, environment variables, or database schemas.

### 5.2 Dependency Scanning
The GitHub Actions CI pipeline executes vulnerability auditing on every push and pull request:
```bash
composer audit
```

### 5.3 URL Validation & SSRF Defense
When saving or interacting with job posting URLs:
- Validate schemes strictly (`http`, `https`).
- Reject internal private IP addresses and loopbacks (`localhost`, `127.0.0.1`, `10.0.0.0/8`, `172.16.0.0/12`, `192.168.0.0/16`, `169.254.169.254`).
