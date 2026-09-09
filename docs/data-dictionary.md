# Data Dictionary and ERD Audit

## Audit scope

This document records the Stage 1 baseline audit on 2026-09-04. The target baseline contains 30 domain tables across eight areas. The repository currently defines 15 physical tables, including Laravel infrastructure tables, so entries marked `planned` still require migrations.

Scope labels:

- `platform-scoped`: owned by the application/platform; no `tenant_id` is required.
- `tenant-owned`: belongs to one tenant; every tenant-owned row must carry `tenant_id` and tenant boundaries must be enforced by keys and authorization.

## Baseline table register

| Domain | Table | Scope | Status | Parent dependencies |
| --- | --- | --- | --- | --- |
| Identity/access | `tenants` | platform-scoped | implemented | none |
| Identity/access | `users` | platform-scoped | implemented | none |
| Identity/access | `roles` | platform-scoped | planned | none |
| Identity/access | `permissions` | platform-scoped | planned | none |
| Identity/access | `role_user` | platform-scoped | planned | `roles`, `users` |
| Identity/access | `permission_role` | platform-scoped | planned | `permissions`, `roles` |
| Table/session | `dining_tables` | tenant-owned | planned | `tenants` |
| Table/session | `table_sessions` | tenant-owned | planned | `tenants`, `dining_tables` |
| Table/session | `table_session_guests` | tenant-owned | planned | `table_sessions` |
| Table/session | `qr_codes` | tenant-owned | planned | `tenants`, `dining_tables` |
| Catalog | `menus` | tenant-owned | implemented | `tenants` |
| Catalog | `menu_categories` | tenant-owned | planned | `tenants` |
| Catalog | `menu_items` | tenant-owned | planned | `menus`, `menu_categories` |
| Catalog | `menu_item_options` | tenant-owned | planned | `menu_items` |
| Catalog | `menu_item_option_values` | tenant-owned | planned | `menu_item_options` |
| Order | `orders` | tenant-owned | planned | `tenants`, `table_sessions`, `users` |
| Order | `order_items` | tenant-owned | implemented | `tenants`, `menus`, `orders` (planned) |
| Order | `order_item_options` | tenant-owned | planned | `order_items`, `menu_item_option_values` |
| Order | `order_status_histories` | tenant-owned | planned | `orders`, `users` |
| Order | `order_events` | tenant-owned | planned | `orders` |
| Payment | `payments` | tenant-owned | planned | `tenants`, `orders` |
| Payment | `payment_methods` | platform-scoped | planned | none |
| Payment | `payment_transactions` | tenant-owned | planned | `payments`, `payment_methods` |
| Ledger | `ledgers` | tenant-owned | planned | `tenants` |
| Ledger | `ledger_entries` | tenant-owned | planned | `ledgers`, `payments` |
| Ledger | `ledger_balances` | tenant-owned | planned | `ledgers` |
| Outbox | `outbox_messages` | platform-scoped | planned | none |
| Outbox | `idempotency_keys` | tenant-owned | planned | `tenants`, `users` |
| Audit | `audit_logs` | tenant-owned | planned | `tenants`, `users` |
| Audit | `login_attempts` | platform-scoped | planned | `users` |

The following implemented infrastructure tables are outside the 30-domain-table baseline and should remain platform-scoped: `password_reset_tokens`, `sessions`, `cache`, `cache_locks`, `jobs`, `job_batches`, `failed_jobs`, and `passkeys`. The `sessions.user_id` column is indexed but is not currently a foreign key.

The migrations `2025_08_14_170933_add_two_factor_columns_to_users_table.php` and `2026_09_04_000001_add_role_and_status_to_users_table.php` alter `users`; they do not create tables.

## Composite unique keys and foreign keys

Composite keys are needed when a child must reference a parent inside the same tenant boundary. Planned composite targets should use the same column order on both sides.

| Parent table | Composite unique target | Child reference | Status |
| --- | --- | --- | --- |
| `tenants` | (`id`, `canteen_id`) | tenant-owned tables that also carry `canteen_id` | planned; current `tenants` has no `canteen_id` |
| `menus` | (`tenant_id`, `id`) | `order_items` (`tenant_id`, `menu_id`) | implemented |
| `dining_tables` | (`tenant_id`, `id`) | `table_sessions`, `qr_codes` | planned |
| `table_sessions` | (`tenant_id`, `id`) | `orders` | planned |
| `orders` | (`tenant_id`, `id`) | `payments`, order history/events | planned |
| `payments` | (`tenant_id`, `id`) | `payment_transactions`, `ledger_entries` | planned |
| `ledgers` | (`tenant_id`, `id`) | `ledger_entries`, `ledger_balances` | planned |

Current concrete foreign keys:

- `passkeys.user_id` references `users.id` with cascade delete.
- `menus.tenant_id` references `tenants.id` with restrict delete.
- `order_items.tenant_id` references `tenants.id` with restrict delete.
- `order_items` (`tenant_id`, `menu_id`) references `menus` (`tenant_id`, `id`) with restrict delete.

## Parent-to-child migration order

Independent Laravel infrastructure migrations may run first. The business dependency order is:

1. `users` and `tenants` (independent roots)
2. identity/access pivots (`roles`, `permissions`, `role_user`, `permission_role`)
3. `passkeys`
4. table/session parents (`dining_tables`, `table_sessions`, `table_session_guests`, `qr_codes`)
5. catalog parents (`menus`, `menu_categories`, `menu_items`, `menu_item_options`, `menu_item_option_values`)
6. `orders`, then `order_items`, order options, histories, and events
7. payment parents (`payment_methods`, `payments`), then `payment_transactions`
8. ledger parents (`ledgers`), then entries and balances
9. outbox and idempotency tables
10. audit tables

Rollback must reverse this order: children first, then parents. Column alterations for `users` must run after `users` exists.

## Findings before Stage 2

- `2026_08_16_000103_create_catalog_tables.php` is timestamped before `2026_09_04_000002_create_tenants_table.php`, although `menus` and `order_items` reference `tenants`.
- The catalog migration currently lacks the migration class wrapper, imports, and `down()` method, so it must be corrected before a clean migration run.
- The repository currently has 15 physical tables, not the requested 30-table implementation. The 30-table register above is the dependency baseline; planned rows need schema decisions before migrations are numbered.
