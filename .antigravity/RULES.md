---
title: Project Rules & Development Guidelines
description: Core guidelines, architecture standards, documentation rules, and completion protocol.
category: rules
tags: [rules, guidelines, standards, best-practices, definition-of-done]
last_updated: 2026-08-28
status: active
---

# Project Rules & Development Guidelines

## 1. Documentation & Source of Truth (Obsidian Vault)
- **Primary Source of Truth**: The `docs/` directory (Obsidian vault) is the authoritative source of truth for all requirements, database schemas, domain models, business logic, and UI specifications.
- **Always Check `docs/` First**: Before implementing new features or making architectural changes, consult the relevant markdown files in `docs/`.
- **Keep Documentation Synchronized**: Whenever requirements change, new features are introduced, or specifications evolve, update the corresponding documents in `docs/` immediately.
- **Missing Specifications**: If any requirement or design detail is missing or ambiguous, consult with the user, agree on the decision, and document the resolution in `docs/`.

---

## 2. Documentation Style & Formatting Guidelines
- **Avoid Decorative Clutter & Emojis**: Do not overuse emojis, icons, or decorative symbols in documentation, code comments, commit messages, or responses. Maintain a clean, professional engineering tone.
- **Modular & Focused Files**: Prefer short, single-purpose markdown documents over massive monolithic files. Group related topics into dedicated documents and link them using standard markdown or wiki-links.
- **YAML Frontmatter Standard**: Every documentation note in `docs/` must begin with standard YAML frontmatter containing:
  ```yaml
  ---
  title: Document Title
  description: Concise description of the document purpose.
  category: overview | architecture | data-model | lifecycle | dashboard | planning | changelog
  tags: [relevant, tags]
  last_updated: YYYY-MM-DD
  status: active | draft | archived
  ---
  ```
- **Proper Markdown Formatting**:
  - Use clear heading hierarchies (`#`, `##`, `###`).
  - Use GitHub-flavored Markdown tables for structured data and Mermaid diagrams for workflows/ERDs.
  - Use fenced code blocks with explicit language tags (`php`, `yaml`, `bash`, `json`).

---

## 3. Technology Stack & Framework Standards
- **Framework**: Laravel 12.x on PHP 8.2+.
- **Admin & UI Framework**: Filament v3/v5 (Panels, Resources, Pages, Widgets, Forms, Tables, Infolists, Actions).
- **Database**: SQLite (local development and automated tests).
- **Environment**: Laravel Herd on Windows (PowerShell CLI).
- **CI / CD**: GitHub Actions (`.github/workflows/ci.yml`).

---

## 4. Database & Migration Best Practices
- **SQLite Compatibility**: Avoid raw DB-specific types (e.g. MySQL `enum()`). Use `string()` with native PHP Backed Enums and Eloquent `$casts`.
- **Schema Alignment**: Verify all column names, nullability, and default values against `docs/02-Data-Dictionary-and-ERD.md` before generating migrations.
- **Explicit Foreign Key Constraints**: Always define explicit `constrained()->cascadeOnDelete()` or `nullOnDelete()` on foreign key relations.
- **Migration Immutability**: Never alter past migrations that have already run; create new migration files for schema alterations.

---

## 5. Eloquent Models & Domain Standards
- **Strict Typing**: Use PHP 8.2+ type declarations (return types, argument types, property types).
- **Explicit Attributes**: Always define explicit `$fillable` (or `$guarded`), proper `$casts`, and clear relationship methods with return types.
- **Factories**: Always create Model Factories in `database/factories/` alongside models for fast test setup and seeding.
- **Query Scopes**: Encapsulate reusable filtering logic (e.g., active applications, upcoming interviews) in Eloquent query scopes.

---

## 6. Filament UI & Component Guidelines
- **Enum Contracts**: Implement Filament's `HasLabel`, `HasColor`, and `HasIcon` contracts on PHP Enums (`ApplicationStatus`, `RoundType`, etc.) to keep badge colors and labels 100% consistent across Tables, Forms, Infolists, and Widgets.
- **Prevent N+1 Queries**: Always eager-load relationships on Filament tables (e.g. `modifyQueryUsing(fn ($query) => $query->with(['company', 'contact']))`).
- **Form Ergonomics**: Group forms using logical `Section` or `Tabs` components with responsive 2-column grids rather than long vertical lists.
- **Relation Managers**: Use Filament relation managers for child relationships (e.g. `InterviewRoundsRelationManager` inside `JobApplicationResource`, `ContactsRelationManager` inside `CompanyResource`).
- **Interactive Pipelines**: Support both tabular and Kanban views for seamless application lifecycle management.

---

## 7. Code Quality, Testing & Verification
- **Code Style (Pint)**: Always maintain Laravel Pint standards. Run `vendor/bin/pint` to format code before finishing tasks.
- **Automated Tests**:
  - Every new model, enum, scope, or Filament resource must have corresponding tests in `tests/Unit` or `tests/Feature`.
  - Tests run against in-memory SQLite (`phpunit.xml`).
- **Pre-Flight Verification**: Always verify that the suite passes cleanly before declaring a task complete:
  ```powershell
  vendor/bin/pint --test
  php artisan test
  ```

---

## 8. Git & Commit Hygiene
- **Conventional Commits**: Use clean prefix conventions (`feat:`, `fix:`, `docs:`, `test:`, `refactor:`, `style:`).
- **Clean Working Tree**: Ensure the working tree is clean and without temporary files or broken states.

---

## 9. Agent Task Completion Protocol (Definition of Done)
**MANDATORY**: Before declaring any coding task, feature, or refactor complete, the agent MUST execute the following documentation and verification steps:

1. **Update `docs/todo.md`**:
   - Check off all completed task items (`- [x]`).
   - If new subtasks or follow-up items were uncovered during implementation, append them to the relevant section.
2. **Update `docs/changelog.md`**:
   - Add a concise summary of all changes made under the `## [Unreleased]` section (categorized under `Added`, `Changed`, `Fixed`, or `Removed`).
3. **Synchronize Specification Docs**:
   - If database schemas or models changed, update `docs/02-Data-Dictionary-and-ERD.md`.
   - If application lifecycle or statuses changed, update `docs/03-Pipeline-Lifecycle.md`.
   - If architecture or data flow changed, update `docs/system-architecture.md`.
   - Update the `last_updated` date in the YAML frontmatter of any modified docs.
4. **Run Pre-Flight Verification**:
   - Execute `vendor/bin/pint --test` and `php artisan test` to guarantee zero style and test regressions.
