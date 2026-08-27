---
title: Project Changelog
description: Chronological log of notable changes, setups, and feature releases.
category: changelog
tags: [changelog, releases, history, job-tracker]
last_updated: 2026-08-28
status: active
---

# Changelog

All notable changes to the **Job Application Tracker** project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/).

---

## [Unreleased]

### Added
- Automated dependency vulnerability scanning (`composer audit`) job in GitHub Actions CI workflow (`.github/workflows/ci.yml`).
- Created Application Security & OWASP Top 10 Defense Guidelines note (`docs/security.md`) detailing mitigation matrix across A01 to A10.
- Integrated security specifications into Obsidian Master Canvas (`docs/project-overview.canvas`).

### Planned
- Database migrations for `companies`, `contacts`, `job_applications`, and `interview_rounds`.
- Eloquent models with relations, casts, and scopes.
- Filament resource pages, table configurations, forms, and relation managers.
- Interactive Kanban Board view for application pipeline stages.
- Dashboard metric widgets and analytics charts.
- Automated feature and unit tests.

---

## [0.1.0] - 2026-08-27

### Added
- **Project Setup**:
  - Initialized Laravel 12 application on PHP 8.2 and SQLite.
  - Configured environment variables and generated application key.
  - Enabled required PHP extensions (`intl`, `zip`, `gd`, `pdo_sqlite`).
  - Generated storage symbolic link (`php artisan storage:link`).
- **Filament Admin Panel**:
  - Installed `filament/filament` and Livewire.
  - Configured `AdminPanelProvider` registered in `bootstrap/providers.php`.
  - Published Filament assets and configured `/admin` routes.
- **CI / CD Pipeline**:
  - Configured GitHub Actions workflow (`.github/workflows/ci.yml`) with automated `Pint` style checking and `PHPUnit` test runner.
- **Documentation & Obsidian Vault**:
  - Established `.antigravity/RULES.md` defining Obsidian `docs/` as the primary Source of Truth, completion protocol, and styling guidelines.
  - Added System Overview (`01-System-Overview.md`).
  - Added Data Dictionary and Mermaid ERD (`02-Data-Dictionary-and-ERD.md`).
  - Added Pipeline & Lifecycle specifications (`03-Pipeline-Lifecycle.md`).
  - Added Dashboard & Widgets specifications (`04-Dashboard-and-Widgets.md`).
  - Added System Architecture & Design (`system-architecture.md`).
  - Added Project Roadmap (`todo.md`).
  - Added Master Canvas (`project-overview.canvas`).
