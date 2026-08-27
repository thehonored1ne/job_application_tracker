---
title: Dashboard & Metrics Specification
description: KPI definitions, calculation formulas, upcoming interviews widget, and visual charts.
category: dashboard
tags: [dashboard, metrics, widgets, kpis, charts, analytics, job-tracker]
last_updated: 2026-08-28
status: active
---

# Dashboard & Metrics Specification

## 1. Overview
The Filament Dashboard provides instant visibility into search velocity, upcoming commitments, and conversion metrics.

---

## 2. Key Metrics & Stats Widget (`StatsOverviewWidget`)

| Metric | Calculation | Visual Indicator |
| :--- | :--- | :--- |
| **Total Applications** | `COUNT(job_applications WHERE status != 'wishlist')` | Total count with historical trend icon |
| **Active Interviews** | `COUNT(job_applications WHERE status IN ('screening', 'technical_interview', 'behavioral_interview', 'final_round'))` | Warning / Active indicator |
| **Offers Received** | `COUNT(job_applications WHERE status = 'offer_received')` | Success green badge |
| **Interview Rate** | `(Applications in Interview / Total Applied) * 100` | Percentage badge |
| **Offer Conversion Rate**| `(Offers / Total Applications) * 100` | Percentage badge |

---

## 3. Upcoming Interviews Widget (`UpcomingInterviewsWidget`)
- **Query**: `InterviewRound WHERE status = 'scheduled' AND scheduled_at >= NOW() ORDER BY scheduled_at ASC LIMIT 5`
- **Columns / Card Elements**:
  - Scheduled Date & Time (formatted cleanly with relative human time, e.g. "Tomorrow at 2:00 PM")
  - Job Title & Company Name
  - Round Type Badge (e.g. `Technical`, `Screening`)
  - Direct 1-Click Meeting Link button (Zoom, Google Meet, Teams)
  - Interviewer Name & Title

---

## 4. Visual Charts

### 4.1 Applications Timeline Chart (`ApplicationsChart`)
- **Type**: Line / Bar Chart (Monthly or Weekly)
- **X-Axis**: Months / Weeks (e.g. Aug, Sep, Oct)
- **Y-Axis**: Number of applications submitted

### 4.2 Pipeline Stage Distribution Chart (`StageDistributionChart`)
- **Type**: Doughnut / Polar Area Chart
- **Segments**:
  - `Wishlist`
  - `Applied`
  - `Interviews (Screening + Tech + Behavioral + Final)`
  - `Offers`
  - `Rejected / Withdrawn`
