# Uméra Investors Dashboard
## Project Overview

## 1. Introduction
The Uméra Investors Dashboard is a secure, role-based web application designed to streamline investor relations and internal investment operations. It provides transparency for investors while enabling administrators to efficiently manage offerings, allocations, documents, announcements, and financial records.

The MVP focuses on clarity, security, and operational reliability, laying a strong foundation for future expansion such as distributions, advanced analytics, and capital call workflows.

---

## 2. Objectives
The primary objectives of the Uméra Investors Dashboard MVP are:

- Provide investors with a clear, self-service view of their investments
- Centralize investor and offering management for administrators
- Enforce strict role-based access and data isolation
- Secure sensitive documents and financial data
- Deliver a stable, deployable MVP within two weeks

---

## 3. Target Users

### Administrators
Internal Uméra staff responsible for:
- Managing investors and offerings
- Assigning allocations and recording contributions
- Uploading and controlling access to documents
- Publishing announcements and reports
- Exporting operational data

### Investors
External users who:
- View their portfolio and allocations
- Access authorized documents
- Review announcements and updates
- Track contributions and basic transaction history

---

## 4. MVP Scope

### Included in MVP
- Authentication and role-based authorization
- Admin dashboard with core CRUD operations
- Investor dashboard with portfolio overview
- Secure document management and downloads
- Announcements and notifications
- Contribution tracking (basic transactions)
- CSV reporting exports
- Audit logging for critical actions

### Explicitly Out of Scope for MVP
- Capital calls automation
- Distribution calculations and payments
- Advanced performance metrics (IRR, MOIC)
- Banking integrations
- Investor messaging or ticketing systems

---

## 5. Key Design Principles

### Security First
- Private document storage with authorized access only
- Policy-based authorization at controller and query levels
- Strong authentication and session handling

### Simplicity and Clarity
- Blade-rendered pages with progressive TypeScript enhancement
- Clear separation between admin and investor interfaces
- Predictable navigation and consistent UI patterns

### Scalability
- Modular architecture using services and policies
- Database schema designed for future extensions
- Clean separation of concerns to support growth

---

## 6. Success Criteria
The MVP is considered successful if:

- An admin can onboard an investor end-to-end without developer intervention
- An investor can log in and clearly understand their portfolio
- No investor can access another investor’s data under any circumstance
- Documents are securely stored and delivered
- The system is deployable and stable in a production environment

---

## 7. Future Roadmap (Post-MVP)
- Distributions and capital call workflows
- Advanced reporting and analytics dashboards
- Multi-currency support
- Two-factor authentication enforcement
- External integrations (accounting, CRM, banking)
- Fine-grained permissions and approval workflows

---

## 8. Summary
The Uméra Investors Dashboard MVP establishes a secure, reliable core platform for investor transparency and operational efficiency. It prioritizes correctness, access control, and usability, ensuring the system can evolve confidently as business needs grow.
