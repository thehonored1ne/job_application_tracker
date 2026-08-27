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
- Enhanced `KanbanBoard` with full-width layout (`Width::Full`), quick Stage Group filter tabs (`All 10 Stages`, `Active Pipeline`, `Interviews Only`, `Offers & Decisions`), and smooth one-click horizontal pan navigation buttons (`‹` / `›`).
- Injected scoped, responsive CSS styles and dark mode support into `kanban-board.blade.php`.
- Unified root Alpine.js component state in `kanban-board.blade.php` resolving `$refs` container scoping.
- Comprehensive test suite covering Enums, Eloquent Models, Scopes, Seeders, Filament Resources, Relation Managers, Kanban Board, and Dashboard Widgets (27 tests, 134 assertions).
- Automated CI pipeline verification in `.github/workflows/ci.yml` incorporating linting (`Pint`), vulnerability scanning (`composer audit`), and test execution (`PHPUnit`).
- Created `StatsOverviewWidget` displaying key KPIs (Total Applications, Active Interviews, Offers Received, Interview Rate %, Offer Conversion Rate %) with sparkline trends.
- Created `UpcomingInterviewsWidget` table displaying scheduled upcoming interview rounds, interviewers, countdowns, and 1-click meeting join links.
- Created `ApplicationsChart` line chart displaying past 6 months application velocity trends.
- Created `StageDistributionChart` doughnut chart displaying pipeline stage breakdowns across Wishlist, Applied, Interviews, Offers, and Closed.
- Registered all custom dashboard widgets and customized theme color scheme in `AdminPanelProvider`.
- Added comprehensive `DashboardWidgetsTest` feature tests validating dashboard rendering, metric calculation accuracy, countdown display, and chart dataset output.
- Created `CompanyResource` with logo uploads, counts badges, and child relation managers (`ContactsRelationManager`, `JobApplicationsRelationManager`).
- Created `ContactResource` with direct communication actions (mailto email links, tel phone links, LinkedIn URLs) and company filters.
- Created `JobApplicationResource` with sectioned form schema (Role & Company, Compensation, Pipeline & Timeline, Notes & Research), eager loading, status filters, and row-level stage movement actions.
- Implemented `InterviewRoundsRelationManager` inside `JobApplicationResource` supporting round types, interviewer info, star ratings, meeting links, prep notes, questions asked, and takeaways.
- Built interactive `KanbanBoard` page with live search, company/priority filters, HTML5 drag-and-drop status transitions, and real-time Livewire state updates.
- Added comprehensive `FilamentResourcesTest` feature tests validating panel access, resource page rendering, table records, and Kanban drag-and-drop status changes.
- Created Backed Enums with Filament `HasLabel`, `HasColor`, and `HasIcon` contracts: `ApplicationStatus`, `EmploymentType`, `LocationType`, `SalaryPeriod`, `RoundType`, `RoundStatus`.
- Created Eloquent models with typed relationships, casts, and query scopes: `Company`, `Contact`, `JobApplication`, and `InterviewRound`.
- Implemented application pipeline query scopes: `activeInterviews()`, `pending()`, `nonWishlist()`, `offers()`, `highPriority()`, `recent()`, `upcoming()`, and `completed()`.
- Created Model Factories for all domain models (`CompanyFactory`, `ContactFactory`, `JobApplicationFactory`, `InterviewRoundFactory`).
- Created comprehensive `DatabaseSeeder` with realistic companies (Stripe, Shopify, GitHub, Vercel, Cloudflare), contacts, job applications across all pipeline stages, and interview rounds.
- Added comprehensive unit and feature test suites (`EnumsTest`, `ModelsAndScopesTest`, `SeederTest`).
- Database migration `create_companies_table` with company fields (`name`, `website`, `logo_path`, `industry`, `location`, `notes`).
- Database migration `create_contacts_table` with foreign key referencing `companies` (`nullOnDelete`).
- Database migration `create_job_applications_table` with foreign keys referencing `companies` (`cascadeOnDelete`) and `contacts` (`nullOnDelete`), complete with financial, status, and timeline fields.
- Database migration `create_interview_rounds_table` with foreign key referencing `job_applications` (`cascadeOnDelete`), interview scheduling, interviewer details, notes, takeaways, and status tracking.
- Automated dependency vulnerability scanning (`composer audit`) job in GitHub Actions CI workflow (`.github/workflows/ci.yml`).
- Created Application Security & OWASP Top 10 Defense Guidelines note (`docs/security.md`) detailing mitigation matrix across A01 to A10.
- Integrated security specifications into Obsidian Master Canvas (`docs/project-overview.canvas`).

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
