# AI Sales Agent SaaS Platform - Complete Development Prompt

You are building a production-grade, multi-tenant SaaS platform for AI-powered sales automation. The platform serves online businesses that sell through Facebook Messenger, Instagram Direct, WhatsApp Business, and website live chat.

Your goal is to design and implement a scalable system that automates customer support, product discovery, lead handling, order collection, follow-ups, upsells, and conversion while preserving human takeover when needed.

## Product Vision
Build a SaaS platform that works as a 24/7 virtual sales team for each merchant. The platform must be multi-tenant, secure, modular, observable, and ready for thousands of businesses.

Each tenant must be able to:
- Connect messaging channels
- Train the AI on business knowledge
- Manage products and catalog media
- Handle conversations with AI or humans
- Collect and confirm orders
- Integrate courier and spreadsheet automation
- Monitor analytics, billing, and AI usage

## Core Objectives
The AI Sales Agent must:
- Answer customer questions accurately and briefly
- Recommend products based on context, budget, and intent
- Send product images, videos, and catalog items
- Collect customer order details
- Follow up with leads automatically
- Upsell and cross-sell relevant items
- Detect language automatically
- Support Bangla, English, Banglish, Hindi, Chittagonian, and Sylheti
- Transfer conversations to a human when confidence is low or escalation is triggered

## Required Architecture
Use a scalable SaaS architecture with clear separation of concerns.

### Recommended Stack
- Frontend: Next.js
- Backend API: Laravel 12 or NestJS
- Database: PostgreSQL
- Cache: Redis
- Queue: RabbitMQ
- Vector Database: Qdrant
- File Storage: AWS S3 or MinIO
- Realtime: WebSocket
- AI Providers: OpenAI, Gemini, Claude, DeepSeek, custom LLMs
- Deployment: Docker, Kubernetes, AWS

### SaaS Requirements
- Multi-tenant tenant isolation
- Role-based access control
- Tenant-scoped data access for every entity
- Central super-admin panel
- Client/merchant panel
- Subscription and billing engine
- Usage metering and AI cost tracking
- Event logging and audit trails
- Modular integrations for Meta, couriers, payments, and spreadsheets

## Roles and Permissions
Implement at least these roles:
- Super Admin
- Tenant Owner
- Tenant Admin
- Sales Agent
- Support Agent
- Read-only Analyst

Permissions must control:
- Dashboard visibility
- Client/tenant management
- Product editing
- AI configuration
- Billing access
- Conversation access
- Human takeover approval
- Audit log access
- Integration settings

## Super Admin Panel
Build a central control plane for platform operators.

### Dashboard Metrics
Show:
- Total Clients
- Active Clients
- Inactive Clients
- Total Conversations
- Total AI Messages
- Total Orders Generated
- Monthly Revenue
- Subscription Revenue
- AI Usage Cost
- Profit Analysis
- Growth Analytics

### Client Management
Support:
- Add Client
- Suspend Client
- Activate Client
- Delete Client
- Assign Package
- Monitor Usage
- Login as Client
- View Subscription Status

### Subscription and Package Management
Support unlimited plans such as:
- Starter: 2,000 messages/month
- Professional: 10,000 messages/month
- Enterprise: Unlimited

Features:
- Monthly billing
- Yearly billing
- Trial period
- Coupon codes
- Promotional discounts
- Auto renewal

### Billing and Invoicing
Implement:
- Auto invoice generation
- PDF invoice download
- Due reminders
- Payment tracking
- VAT settings
- Revenue reports

### Payment Gateway Integration
Bangladesh:
- SSLCommerz
- bKash
- Nagad
- Rocket

International:
- Stripe
- PayPal

### AI Provider Management
Support:
- OpenAI
- Gemini
- Claude
- DeepSeek
- Custom LLM

Features:
- API key management
- Model selection
- Cost tracking
- Token tracking
- Usage analytics
- Provider fallback strategy

### Meta Integration Management
Support:
- Facebook App Settings
- Messenger API
- Instagram Messaging API
- WhatsApp Cloud API
- Webhook management
- Token refresh automation

### Landing Page Builder
Allow the super admin to manage:
- Hero section
- Pricing section
- Testimonials
- FAQ
- Features section
- Demo section
- Blog section
- Contact form

### White Label System
Support:
- Custom branding
- Custom logo
- Custom domain
- Reseller accounts

### Support System
Implement:
- Ticket management
- Live chat
- Knowledge base
- Announcement system

## Client Panel
Build a merchant-facing workspace.

### Dashboard
Show:
- Today’s messages
- Total conversations
- Total leads
- Total orders
- Conversion rate
- Revenue generated
- AI cost saved
- Active customers

### Product Management
Allow unlimited products with fields:
- Product name
- SKU
- Price
- Offer price
- Description
- Features
- Variants
- Stock quantity
- Product images
- Product videos
- Delivery charge

### Product Media Library
When customers ask for:
- “Product image please”
- “Show me the video”
- “Send catalog”

the AI must automatically send the relevant media.

### AI Brain Training
Allow merchants to configure:
- Company name
- Business description
- Delivery policy
- Return policy
- Refund policy
- Working hours

### FAQ Builder
Support custom FAQs with intent matching.

### Knowledge Base
Allow import from:
- PDF
- DOCX
- TXT
- CSV
- Website URL
- Google Sheets
- Product catalog

### Conversation Inbox
Build a messenger-style inbox with:
- Live chat
- AI replies
- Human replies
- Internal notes
- Agent assignment
- Conversation history

### Human Takeover System
The AI must detect escalation triggers such as:
- Complaint
- Refund request
- Exchange request
- Angry customer
- Legal issue
- Manager request
- Custom trigger words

When triggered:
- Stop AI replies
- Notify human agent
- Mark conversation as high priority
- Preserve full message history

### Human Notification Center
Support real-time alerts for:
- Complaint
- Refund
- Escalation
- VIP customer
- High-value order

Notification channels:
- Dashboard alerts
- Browser notifications
- Email notifications
- WhatsApp notifications

### Lead Management
Use pipeline stages:
- New Lead
- Interested
- Negotiation
- Order Pending
- Confirmed Order
- Delivered
- Lost Lead

### Smart Sales Features
Implement:
- Product recommendations based on conversation context
- Budget-aware suggestions
- Upselling
- Cross-selling
- Frequent-buyer suggestions
- Abandoned-cart recovery

### Order Management
The AI must collect:
- Customer name
- Mobile number
- Address
- Product
- Quantity

Order flow:
1. AI collects data
2. Customer confirms
3. Order is saved
4. Invoice is created
5. Shipping label is generated
6. Google Sheet entry is created
7. Dashboard notification is sent

### Google Sheet Automation
On order confirmation, auto-push:
- Order ID
- Customer name
- Phone
- Address
- Product
- Quantity
- Price
- Date

### Shipping Label Generator
Generate:
- PDF label
- Print label
- Barcode
- QR code

Include:
- Tracking ID
- Customer info
- Product info
- Amount

### Courier Integration
Support:
- Pathao Courier
- Steadfast
- RedX
- Paperfly
- Custom courier adapters

Features:
- Auto parcel creation
- Tracking sync
- Delivery status updates

### AI Confidence System
Every AI response must receive a confidence score:
- High confidence: 80-100%
- Medium confidence: 50-80%
- Low confidence: below 50%

Rules:
- High confidence: reply automatically
- Medium confidence: reply and flag for review
- Low confidence: trigger human takeover

### Multilingual Support
Support automatic language detection for:
- Bangla
- English
- Banglish
- Hindi
- Chittagonian
- Sylheti

### Voice AI
Support voice message processing:
- Speech to text
- AI analysis
- Multilingual reply generation

### Image Recognition
Support customer image input for:
- Product identification
- Catalog matching
- Alternative recommendations
- Stock checking

### Smart Follow-up
If a customer does not respond after 24 hours, send a follow-up message.
Example:
- “আপনি কি এখনও এই পণ্যটি নিতে আগ্রহী?”

### Abandoned Cart Recovery
Send reminders after:
- 1 hour
- 24 hours
- 3 days

### Customer Segmentation
Classify customers into:
- New Customer
- Returning Customer
- VIP Customer
- High Spender
- Inactive Customer

### Broadcast Messaging
Allow campaigns through:
- Messenger
- WhatsApp
- Instagram

### Analytics and Reporting
Provide charts for:
- Conversion rate
- Sales generated
- Top products
- Most asked questions
- Agent performance
- AI performance

## Security Requirements
Implement:
- Role-based access control
- Two-factor authentication
- Login history
- IP restriction
- Audit logs
- API rate limiting
- Secure file uploads
- Tenant data isolation

## Data Model Guidance
Design a tenant-first schema with entities such as:
- tenants
- users
- roles
- permissions
- subscriptions
- plans
- invoices
- payments
- usage_logs
- ai_providers
- ai_settings
- meta_integrations
- products
- product_media
- knowledge_sources
- conversations
- conversation_messages
- human_takeovers
- leads
- orders
- shipments
- couriers
- notifications
- tickets
- announcements
- broadcasts
- audit_logs
- landing_page_sections
- domains
- reseller_accounts

Every tenant-scoped table must include a tenant identifier and be indexed properly.

## Backend Services
Create distinct services or modules for:
- Authentication and authorization
- Tenant management
- Billing and invoicing
- AI orchestration
- Conversation management
- Product catalog management
- Order creation and workflow
- Notification delivery
- Webhook handling
- Integration syncing
- Analytics aggregation
- Background jobs and scheduled tasks

## AI Orchestration Rules
The AI runtime must:
- Load tenant-specific business context
- Load product catalog context
- Load FAQs and knowledge base context
- Respect language preference and detected language
- Use confidence scoring
- Detect intent and escalation patterns
- Support structured order extraction
- Fall back to human takeover when needed
- Log prompt, response, confidence, token usage, and cost

## Conversation Engine Rules
The conversation system must:
- Store every inbound and outbound message
- Separate customer, AI, and human messages
- Support message attachments
- Support internal notes
- Support assignment to agents
- Support high-priority flags
- Support message search and filters

## Realtime Requirements
Use WebSockets for:
- New message alerts
- Human takeover alerts
- Live typing indicators
- Agent assignment changes
- Order and lead updates
- System notifications

## Queue and Background Jobs
Use queues for:
- AI reply generation
- Follow-up scheduling
- Abandoned cart reminders
- Invoice generation
- Label generation
- Spreadsheet sync
- Courier sync
- Notification delivery
- Analytics aggregation
- Token refresh

## API Design
Create versioned APIs with:
- Authentication endpoints
- Tenant management endpoints
- Product endpoints
- Conversation endpoints
- Order endpoints
- Lead endpoints
- Billing endpoints
- Integration endpoints
- Analytics endpoints
- Notification endpoints
- Webhook endpoints

## Webhook Handling
Build secure webhook endpoints for:
- Meta message events
- Status updates
- Order events
- Courier tracking updates
- Payment gateway callbacks
- AI usage callbacks if applicable

## Deliverables
Implement the platform in phases:
1. Authentication, tenancy, and role system
2. Product, conversation, and AI reply engine
3. Orders, invoices, courier, and spreadsheet automation
4. Billing, subscriptions, and payments
5. Analytics, notifications, and support system
6. White-label, landing page builder, and reseller system

## Acceptance Criteria
The implementation is complete only if:
- Multiple tenants can operate independently
- Each tenant sees only its own data
- AI can reply in multiple languages
- Human takeover works reliably
- Orders can be created automatically from chat
- Billing and subscriptions work end to end
- Integrations are configurable per tenant
- Metrics and logs are available to admins
- The system can scale horizontally
- The platform is secure and production-ready

## Coding Guidance
- Build a clean modular architecture
- Prefer reusable services over duplicated logic
- Use prepared statements or ORM safeguards for database access
- Validate all inbound data
- Centralize authentication and authorization
- Keep AI prompts tenant-specific
- Write code that is observable, testable, and maintainable
- Avoid hard-coded tenant IDs
- Avoid direct provider coupling inside controllers
- Keep webhook handlers idempotent
- Store secrets securely

## Output Expectation
Generate a production-ready SaaS platform with a modern UI, robust backend, multi-tenant data isolation, AI-powered sales automation, and scalable infrastructure.

If full implementation cannot be completed in one pass, produce the platform in well-structured phases without breaking tenant isolation, security, or the core AI sales workflow.