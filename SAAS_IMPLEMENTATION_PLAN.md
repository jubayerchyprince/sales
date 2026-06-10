# AI Sales Agent SaaS Platform - Concrete Implementation Plan

This plan turns the current PHP merchant app into a multi-tenant SaaS platform with a Next.js frontend and a Laravel 12 API. If the team prefers NestJS, the domain modules stay the same; only the backend implementation changes.

## 1) Target Architecture

### Frontend
- Next.js App Router
- Tailwind CSS
- Role-aware dashboards for super admin and tenant users
- Realtime inbox UI with WebSocket updates

### Backend
- Laravel 12 API
- PostgreSQL for relational data
- Redis for cache, sessions, queues, rate limits
- RabbitMQ for background jobs
- Qdrant for knowledge-base and product retrieval
- S3 or MinIO for uploads
- WebSocket server for live events

### Core services
- Auth and RBAC service
- Tenant service
- Product catalog service
- Conversation and inbox service
- AI orchestration service
- Order and shipping service
- Billing and subscription service
- Notification service
- Integration service for Meta, couriers, payments, and Google Sheets
- Analytics service

## 2) Repository Structure

```text
/apps
  /web                Next.js frontend
  /api                Laravel API
/packages
  /shared            Shared types, enums, and validation schemas
/infrastructure
  /docker
  /k8s
  /terraform
/docs
  architecture.md
  api.md
  database.md
  onboarding.md
```

## 3) Phase 1 - Platform Foundation

### Goal
Create a secure multi-tenant base that can host all product features without rewriting data access later.

### Deliverables
- Authentication with email/password and optional 2FA
- Tenant creation and tenant switching
- RBAC with roles and permissions
- Tenant-scoped middleware and policies
- Audit log table and login history
- IP restriction and API rate limiting
- Basic super admin shell and tenant shell

### Database tables
- tenants
- users
- roles
- permissions
- role_permissions
- user_roles
- tenant_memberships
- audit_logs
- login_history
- api_tokens
- sessions

### Acceptance criteria
- A user can belong to one or more tenants
- Every protected request resolves a tenant context
- No tenant can read or write another tenant's data

## 4) Phase 2 - SaaS Billing and Plans

### Goal
Add plans, subscriptions, invoicing, and usage metering.

### Deliverables
- Unlimited plans with monthly and yearly billing
- Trial periods
- Coupons and promotional discounts
- Auto renewal
- Invoice generation and PDF export
- Payment tracking
- VAT settings
- Revenue reports
- AI usage cost tracking and quota enforcement

### Database tables
- plans
- plan_features
- subscriptions
- subscription_cycles
- coupons
- invoices
- invoice_items
- payments
- usage_logs
- vat_settings

### Acceptance criteria
- A tenant can upgrade, downgrade, renew, or cancel a plan
- Usage overages can be blocked or billed according to policy
- Every invoice is tied to a tenant and subscription cycle

## 5) Phase 3 - Client Product and CRM Core

### Goal
Provide the merchant-facing workspace needed for day-to-day operations.

### Deliverables
- Product CRUD with images, videos, variants, stock, delivery charge, SKU, offer price
- Knowledge base upload for PDF, DOCX, TXT, CSV
- Business profile settings: policies, hours, brand tone
- FAQ builder
- Conversation inbox with human reply mode
- Internal notes and assignment
- Lead pipeline stages

### Database tables
- products
- product_media
- product_variants
- knowledge_sources
- knowledge_documents
- faqs
- conversations
- conversation_messages
- conversation_notes
- conversation_assignments
- leads
- lead_events

### Acceptance criteria
- Product media can be attached and indexed
- Conversations show both AI and human messages
- Leads can move through configured stages

## 6) Phase 4 - AI Orchestration

### Goal
Generate safe, tenant-specific AI responses with confidence scoring and escalation.

### Deliverables
- Provider adapters for OpenAI, Gemini, Claude, DeepSeek, and custom LLMs
- Prompt builder using tenant business context, product context, FAQs, and knowledge retrieval
- Confidence score per response
- Escalation rules for complaints, refunds, legal issues, and custom triggers
- Language detection for Bangla, English, Banglish, Hindi, Chittagonian, and Sylheti
- Structured order extraction
- Follow-up and abandoned-cart reply templates

### Database tables
- ai_providers
- ai_models
- ai_settings
- ai_prompts
- ai_usage_events
- escalation_rules
- language_profiles
- reply_templates

### Acceptance criteria
- Low-confidence replies are routed to humans automatically
- Every AI response stores provider, model, tokens, and estimated cost
- Tenant-specific prompts stay isolated

## 7) Phase 5 - Omnichannel Integrations

### Goal
Connect the platform to Meta channels, website live chat, courier services, and sheets automation.

### Deliverables
- Facebook Messenger webhook ingestion
- Instagram messaging webhook ingestion
- WhatsApp Cloud API ingestion
- Website live chat widget and WebSocket bridge
- Google Sheets push after order confirmation
- Courier integrations for Pathao, Steadfast, RedX, Paperfly, and custom adapters
- Token refresh automation for Meta and third-party APIs

### Database tables
- integrations
- integration_tokens
- webhook_events
- webhook_deliveries
- courier_accounts
- courier_shipments
- sync_jobs
- sheet_connections

### Acceptance criteria
- One inbound message creates a normalized conversation event
- Webhook processing is idempotent
- Courier shipment status can sync back into the order record

## 8) Phase 6 - Orders, Labels, and Fulfillment

### Goal
Automate order creation from chat and sync fulfillment.

### Deliverables
- Order draft collection from chat
- Order confirmation flow
- Invoice creation on confirmation
- Shipping label generator with PDF, barcode, and QR code
- Shipment tracking and status updates
- Dashboard alerts for high-value orders

### Database tables
- orders
- order_items
- order_events
- order_drafts
- shipping_labels
- shipments
- shipment_events

### Acceptance criteria
- AI can extract customer name, phone, address, product, quantity
- Confirmed orders generate downstream records automatically
- Labels can be printed or downloaded

## 9) Phase 7 - Analytics, Notifications, and Support

### Goal
Give the super admin and tenants visibility and operational tooling.

### Deliverables
- Admin and tenant dashboards
- Conversion, revenue, and top-product charts
- Agent performance charts
- Human notification center
- Browser, email, dashboard, and WhatsApp notifications
- Ticketing, announcements, and knowledge base for support

### Database tables
- notifications
- notification_preferences
- dashboards
- metric_snapshots
- tickets
- ticket_messages
- announcements
- announcement_reads

### Acceptance criteria
- Metrics are tenant-scoped and time-filterable
- Notifications can be delivered through more than one channel
- Support tickets can be linked to tenants and conversations

## 10) Recommended API Surface

### Auth
- POST /auth/register
- POST /auth/login
- POST /auth/logout
- POST /auth/2fa/verify
- POST /auth/forgot-password
- POST /auth/reset-password

### Tenants and users
- GET /admin/tenants
- POST /admin/tenants
- PATCH /admin/tenants/{id}
- POST /admin/tenants/{id}/suspend
- POST /admin/tenants/{id}/activate
- POST /admin/tenants/{id}/impersonate

### Products
- GET /tenant/products
- POST /tenant/products
- PATCH /tenant/products/{id}
- DELETE /tenant/products/{id}

### Conversations
- GET /tenant/conversations
- GET /tenant/conversations/{id}
- POST /tenant/conversations/{id}/messages
- POST /tenant/conversations/{id}/takeover
- POST /tenant/conversations/{id}/release

### Orders
- GET /tenant/orders
- POST /tenant/orders
- POST /tenant/orders/{id}/confirm
- POST /tenant/orders/{id}/generate-label

### Billing
- GET /admin/plans
- POST /admin/plans
- GET /tenant/subscription
- POST /tenant/subscription/checkout
- POST /payments/webhook

### Integrations
- POST /webhooks/meta
- POST /webhooks/courier
- POST /webhooks/payments
- POST /tenant/integrations/{provider}/connect
- POST /tenant/integrations/{provider}/refresh

## 11) Frontend Pages

### Super admin
- /admin/dashboard
- /admin/tenants
- /admin/plans
- /admin/invoices
- /admin/ai-providers
- /admin/integrations
- /admin/landing-page
- /admin/support

### Tenant
- /app/dashboard
- /app/products
- /app/inbox
- /app/leads
- /app/orders
- /app/ai-brain
- /app/knowledge-base
- /app/integrations
- /app/billing
- /app/settings

## 12) Migration Path From Current PHP App

### Step 1
Freeze the current PHP app as a reference implementation for product behavior.

### Step 2
Extract the domain model from existing tables and map them to the new tenant-aware schema.

### Step 3
Rebuild auth, dashboard, products, orders, and inbox in the new stack.

### Step 4
Move webhook and AI logic into backend services with queues and provider adapters.

### Step 5
Cut over tenant by tenant, not all at once.

## 13) First Build Sprint

### Sprint goal
Produce a working foundation that supports login, tenant creation, product CRUD, and a basic conversation inbox.

### Tasks
- Initialize the monorepo
- Create PostgreSQL schema and migrations
- Implement auth and tenant middleware
- Build super admin tenant list and tenant creation screens
- Build client dashboard shell
- Build product CRUD and media upload
- Build conversation inbox with seeded messages
- Add Redis queue and audit log pipeline

### Exit criteria
- A super admin can create a tenant
- A tenant owner can log in and manage products
- A tenant can view its own conversations only
- Audit logs capture the important actions

## 14) Suggested Implementation Order
1. Database and auth
2. Tenancy and RBAC
3. Product catalog
4. Conversation inbox
5. AI orchestration
6. Orders and fulfillment
7. Billing and subscription
8. Analytics and support
9. White label and reseller tools

## 15) Non-negotiable Engineering Rules
- Every query must be tenant-scoped unless it is a super admin query
- Every webhook must be validated and idempotent
- Every AI response must be logged with provider and cost metadata
- Every sensitive action must be audited
- Every external integration must be isolated behind a service adapter
- Every queued task must be retry-safe

## 16) Immediate Next Step
Create the monorepo skeleton and the first Laravel migration set for tenants, users, roles, permissions, subscriptions, products, conversations, and orders.