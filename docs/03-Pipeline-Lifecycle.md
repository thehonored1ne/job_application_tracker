---
title: Application Pipeline & Lifecycle
description: State machine transitions, stage definitions, badges, and interview tracking flow.
category: lifecycle
tags: [pipeline, lifecycle, status, interviews, workflow, job-tracker]
last_updated: 2026-08-28
status: active
---

# Application Pipeline & Lifecycle

## 1. Pipeline Stages
The application tracks a candidate's journey through structured, sequential stages:

```mermaid
stateDiagram-v2
    [*] --> Wishlist: Discovered role
    Wishlist --> Applied: Submitted application
    Applied --> Screening: Recruiter reached out
    Screening --> Technical_Interview: Passed screening
    Technical_Interview --> Behavioral_Interview: Passed technical
    Behavioral_Interview --> Final_Round: Passed team interview
    Final_Round --> Offer_Received: Received formal offer

    Offer_Received --> Accepted: Signed offer
    Offer_Received --> Rejected: Offer rejected / declined

    Applied --> Rejected: Cold rejection
    Screening --> Rejected: Rejected after screening
    Technical_Interview --> Rejected: Rejected after tech
    Behavioral_Interview --> Rejected: Rejected after behavioral
    Final_Round --> Rejected: Rejected after final

    Wishlist --> Withdrawn: No longer interested
    Applied --> Withdrawn: Withdrawn application
    Screening --> Withdrawn: Withdrawn
    Technical_Interview --> Withdrawn: Withdrawn
    Behavioral_Interview --> Withdrawn: Withdrawn
    Final_Round --> Withdrawn: Withdrawn
    Offer_Received --> Withdrawn: Withdrawn
```

---

## 2. Stage Breakdown & Definitions

| Stage Key | Display Label | Badge Color | Description |
| :--- | :--- | :--- | :--- |
| `wishlist` | **Wishlist / Saved** | `gray` | Saved job opportunity to apply for later |
| `applied` | **Applied** | `info` (Blue) | Application officially submitted; awaiting reply |
| `screening` | **Screening** | `warning` (Amber) | Recruiter phone screen or initial HR assessment |
| `technical_interview` | **Technical Interview** | `purple` | Live coding, system design, or technical take-home |
| `behavioral_interview`| **Behavioral / Manager** | `cyan` | Culture fit, team fit, or engineering manager interview |
| `final_round` | **Final Round** | `orange` | Executive / Director / VP final interview |
| `offer_received` | **Offer Received** | `success` (Emerald) | Formal compensation offer received |
| `accepted` | **Accepted** | `success` (Green) | Offer accepted and contract signed |
| `rejected` | **Rejected** | `danger` (Red) | Application not selected by company |
| `withdrawn` | **Withdrawn** | `gray` | Candidate voluntarily withdrew application |

---

## 3. Interview Rounds Tracking
Within each application in an active interview stage (`screening`, `technical_interview`, `behavioral_interview`, `final_round`), one or more **Interview Rounds** can be created:
- **Round Types**:
  - `screening`: Initial phone / HR screening
  - `technical`: Coding, algorithm, or pair-programming
  - `system_design`: High-level architecture and system design
  - `behavioral`: Star method, leadership, communication
  - `take_home`: Project assignment / evaluation
  - `final`: Executive / Offer discussion
- **Round Statuses**:
  - `scheduled`: Upcoming interview with date & meeting URL
  - `completed`: Interview took place; notes recorded
  - `passed`: Successful round; moving to next round
  - `failed`: Did not pass round
  - `cancelled`: Rescheduled or cancelled
