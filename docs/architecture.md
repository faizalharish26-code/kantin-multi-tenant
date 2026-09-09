# Architecture Overview

## Modular monolith structure

This application is organized as a modular monolith, where each business domain is isolated in its own module folder under `app/Modules/<Module>`, while shared infrastructure remains in the main Laravel namespaces such as `app/Models`, `app/Providers`, and `routes/`.

### Dependency direction

```text
Customer UI
   │
   ▼
Tenant Module ──> Shared Core
   │                 │
   ├─ Catalog Module ─┤
   ├─ Ordering Module ─┤
   ├─ Payments Module ─┤
   ├─ Kitchen Module ──┤
   └─ Reporting Module ┤

Admin Module ────────> Shared Core
```

Rules:
- feature modules may depend on shared core services and models
- shared core must not depend on feature modules
- route groups are split by context: customer, tenant, admin
- module providers register domain-specific services and routes, but do not bypass the application shell

## Naming conventions

### Route naming
- customer routes use the `customer.` prefix
- tenant routes use the `tenant.` prefix
- admin routes use the `admin.` prefix

Example:
- `customer.home`
- `tenant.dashboard`
- `admin.users`

### Module namespace
- provider classes live under `App\Modules\<Module>\Providers\`
- module folders use PascalCase names, for example `Admin`, `Catalog`, `Ordering`
- domain directories should stay consistent with the provider class naming

### Blade component conventions
- reusable UI is stored in `resources/views/components/`
- simple shared components use names such as `button`, `input`, `status-badge`, `empty-state`
- layout shells live in `resources/views/layouts/` and are named by context: `customer`, `tenant`, `admin`

## Routing context rules

- customer routes are public and anonymous
- tenant routes require authenticated and verified users, and use `{tenant:slug}` with `scopeBindings()` to keep nested route resolution scoped to the parent tenant
- admin routes are protected and require authenticated and verified admin access

## UI shell policy

- customer layout is mobile-first and optimized for public browsing
- tenant layout uses a sidebar and internal workspace structure
- admin layout uses structured data panels and responsive tables
- shared components help ensure consistent spacing, color, radius, and interaction density

## Implementation note

This is a modular monolith design: one Laravel app, multiple feature boundaries, and a clear dependency rule to keep domain concerns separated without incurring the complexity of multi-repository deployment.
