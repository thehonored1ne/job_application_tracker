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
- [ ] Create migration for `companies` table.
- [ ] Create migration for `contacts` table with foreign key to `companies`.
- [ ] Create migration for `job_applications` table with foreign keys to `companies` and `contacts`.
- [ ] Create migration for `interview_rounds` table with foreign key to `job_applications`.
- [ ] Run and verify migrations against SQLite database (`php artisan migrate`).

---

## Phase 2: Eloquent Models & Business Logic
- [ ] Create `Company` model (`hasMany` JobApplications, `hasMany` Contacts).
- [ ] Create `Contact` model (`belongsTo` Company, `hasMany` JobApplications).
- [ ] Create `JobApplication` model (`belongsTo` Company, `belongsTo` Contact, `hasMany` InterviewRounds).
- [ ] Create `InterviewRound` model (`belongsTo` JobApplication).
- [ ] Create Enums for `ApplicationStatus`, `EmploymentType`, `LocationType`, `SalaryPeriod`, `RoundType`, `RoundStatus`.
- [ ] Add query scopes for active interviews, pending applications, and stage filtering.
- [ ] Create model factories and seeders for mock development data.

---

## Phase 3: Filament Resources & Management UI
- [ ] Generate `CompanyResource` with logo uploads, contacts relation manager, and applications relation manager.
- [ ] Generate `ContactResource` with quick actions (email link, phone, LinkedIn).
- [ ] Generate `JobApplicationResource` with comprehensive form schema (tabs/sections for Job Details, Compensation, Timeline, Notes).
- [ ] Implement `InterviewRoundsRelationManager` inside `JobApplicationResource`.
- [ ] Add quick status transition actions and color-coded status badges in application tables.
- [ ] Build visual Kanban Board page/view for drag-and-drop status changes.

---

## Phase 4: Dashboard & Analytics Widgets
- [ ] Create `StatsOverviewWidget` (Total Applied, Active Interviews, Offers, Conversion Rates).
- [ ] Create `UpcomingInterviewsWidget` (next 7 days with direct meeting links).
- [ ] Create `ApplicationsChart` (monthly/weekly application trends).
- [ ] Create `StageDistributionChart` (funnel/status breakdown).
- [ ] Register all widgets in `AdminPanelProvider`.

---

## Phase 5: Verification & Quality Assurance
- [ ] Write Unit tests for Enums, Models, and Scopes.
- [ ] Write Feature tests for Filament Resources and CRUD operations.
- [ ] Run `vendor/bin/pint` to ensure clean code style.
- [ ] Validate automated CI workflow in `.github/workflows/ci.yml`.
