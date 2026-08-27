---
title: Project Todo & Roadmap
description: Actionable task list and implementation checklist grouped by development phases.
category: planning
tags: [todo, roadmap, tasks, planning, job-tracker]
last_updated: 2026-08-28
status: active
---

# Project Roadmap & Task List

## Phase 1: Database & Migrations
- [x] Create migration for `companies` table.
- [x] Create migration for `contacts` table with foreign key to `companies`.
- [x] Create migration for `job_applications` table with foreign keys to `companies` and `contacts`.
- [x] Create migration for `interview_rounds` table with foreign key to `job_applications`.
- [x] Run and verify migrations against SQLite database (`php artisan migrate`).

---

## Phase 2: Eloquent Models & Business Logic
- [x] Create `Company` model (`hasMany` JobApplications, `hasMany` Contacts).
- [x] Create `Contact` model (`belongsTo` Company, `hasMany` JobApplications).
- [x] Create `JobApplication` model (`belongsTo` Company, `belongsTo` Contact, `hasMany` InterviewRounds).
- [x] Create `InterviewRound` model (`belongsTo` JobApplication).
- [x] Create Enums for `ApplicationStatus`, `EmploymentType`, `LocationType`, `SalaryPeriod`, `RoundType`, `RoundStatus`.
- [x] Add query scopes for active interviews, pending applications, and stage filtering.
- [x] Create model factories and seeders for mock development data.

---

## Phase 3: Filament Resources & Management UI
- [x] Generate `CompanyResource` with logo uploads, contacts relation manager, and applications relation manager.
- [x] Generate `ContactResource` with quick actions (email link, phone, LinkedIn).
- [x] Generate `JobApplicationResource` with comprehensive form schema (tabs/sections for Job Details, Compensation, Timeline, Notes).
- [x] Implement `InterviewRoundsRelationManager` inside `JobApplicationResource`.
- [x] Add quick status transition actions and color-coded status badges in application tables.
- [x] Build visual Kanban Board page/view for drag-and-drop status changes.

---

## Phase 4: Dashboard & Analytics Widgets
- [x] Create `StatsOverviewWidget` (Total Applied, Active Interviews, Offers, Conversion Rates).
- [x] Create `UpcomingInterviewsWidget` (next 7 days with direct meeting links).
- [x] Create `ApplicationsChart` (monthly/weekly application trends).
- [x] Create `StageDistributionChart` (funnel/status breakdown).
- [x] Register all widgets in `AdminPanelProvider`.

---

## Phase 5: Verification & Quality Assurance
- [x] Write Unit tests for Enums, Models, and Scopes.
- [x] Write Feature tests for Filament Resources and CRUD operations.
- [x] Run `vendor/bin/pint` to ensure clean code style.
- [x] Validate automated CI workflow in `.github/workflows/ci.yml`.
