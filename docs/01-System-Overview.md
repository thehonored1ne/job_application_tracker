---
title: System Overview
description: High-level vision, core pillars, technology stack, and documentation map.
category: overview
tags: [overview, vision, tech-stack, job-tracker]
last_updated: 2026-08-28
status: active
---

# Job Application Tracker - System Overview

## 1. Vision & Purpose
**Job Application Tracker** is a personal, streamlined application lifecycle management tool built with **Laravel 12** and **Filament**. It helps software developers and job seekers efficiently track, organize, and analyze their job search journey from the initial discovery of a role to the final signed offer.

---

## 2. Core Pillars
1. **Pipeline Transparency**: Real-time visual tracking of applications across every stage of the hiring funnel via both **Table** and **Kanban** views.
2. **Company & Recruiter Directory**: Manage companies, recruiter contact details, and hiring manager relationships directly linked to applications.
3. **Interview Logs & Prep**: Comprehensive history of interview rounds, meeting links, questions asked, takeaways, and performance ratings.
4. **Actionable Insights & Metrics**: Dashboard widgets tracking response rates, interview conversion rates, active offers, and upcoming schedules.

---

## 3. Technology Stack
| Layer | Technology |
| :--- | :--- |
| **Backend Framework** | Laravel 12.x (PHP 8.2+) |
| **Admin & UI Engine** | Filament (Panels, Forms, Tables, Widgets, Infolists) |
| **Database** | SQLite (`database/database.sqlite`) |
| **Local Dev Environment**| Laravel Herd (Windows) |
| **CI / CD** | GitHub Actions (`.github/workflows/ci.yml`) |
| **Code Style** | Laravel Pint |
| **Testing** | PHPUnit (in-memory SQLite) |
| **Documentation** | Obsidian Markdown Vault (`docs/`) |

---

## 4. Documentation Map
- [[system-architecture]] - High-level architecture, design patterns, and layer structure.
- [[02-Data-Dictionary-and-ERD]] - Detailed database schemas, model definitions, and entity relationships.
- [[03-Pipeline-Lifecycle]] - Application stages, transition states, and interview workflows.
- [[04-Dashboard-and-Widgets]] - Analytics metrics, KPIs, and dashboard widget specs.
- [[security]] - Application security, upload safeguards, and vulnerability management.
- [[todo]] - Actionable roadmap and implementation task checklist.
- [[changelog]] - Chronological record of releases and modifications.
