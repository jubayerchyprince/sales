# Architecture

## Goal
Move from the legacy PHP merchant app to a multi-tenant SaaS platform.

## Core layers
- Web UI: Next.js
- API: Laravel 12
- Storage: PostgreSQL, Redis, Qdrant
- Realtime: WebSocket
- Jobs: RabbitMQ

## Design rules
- Every business table is tenant-scoped
- Every webhook is idempotent
- Every AI response is logged with provider, cost, and confidence
