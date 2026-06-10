# Sales Agent SaaS Monorepo

This repository is being converted from a single-merchant PHP app into a multi-tenant SaaS platform.

## Structure
- `apps/web` - Next.js frontend for super admin and tenant dashboards
- `apps/api` - Laravel 12 API for auth, tenancy, billing, integrations, and AI orchestration
- `packages/shared` - Shared schemas, enums, and types
- `docs` - Architecture and implementation notes

## Current status
- Existing PHP files remain available as the legacy reference implementation.
- The new monorepo scaffold is ready for the Next.js + Laravel buildout.

## Next step
Install dependencies and generate the first apps from these folders.
