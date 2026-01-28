You are a senior product designer and Laravel engineer.

Design the Admin Dashboard navigation and feature placement for the Uméra Investors Dashboard.

ADMIN SIDEBAR STRUCTURE (MANDATORY)

Use a left sidebar (NOT a top navbar) with the following hierarchy:

Dashboard

Overview (stats, health, quick actions)

Investors

All Investors

Import Investors (Bulk Upload) ← place import here

Investor Profiles

Investments

Offerings

Allocations

Transactions

Documents

Legal Documents

Investment Documents

Announcements

All Announcements

Create Announcement

System

Audit Logs

Failed Imports

BULK IMPORT PAGE LOCATION

Route:

/admin/investors/import


Placement Rules:

Must be accessible ONLY to Admin

Must be visually grouped under Investors

Must show a warning banner:

“Bulk import affects legal, financial, and investor records.”






ADMIN IMPORT PAGE UI SECTIONS

Layout must include:

Page Header

Title: “Bulk Investor Import”

Subtitle: “Upload historical investor and portfolio records”

Upload Section

Drag-and-drop Excel/CSV upload

File requirements shown clearly

Preview Section

First 10 rows table

Column mapping preview

Processing Section

Progress bar

Estimated time

Background job status

Results Section

Investors created

Investments created

Transactions created

Failed rows (download CSV)

Audit Trail Footer

Admin name

Import timestamp

File name

Build this with professional spacing, hierarchy, and restraint — no beginner UI patterns.




PROMPT 2 — INVESTOR DASHBOARD: HOW IMPORTED DATA APPEARS

👉 Paste this AFTER Prompt 1

🧠 PROMPT: INVESTOR DASHBOARD DATA PRESENTATION

You are designing the Investor Dashboard experience for data that was imported by Admin.

Investors must never know or care that data came from an import.

INVESTOR SIDEBAR STRUCTURE

Use a left sidebar with:

Dashboard

My Investments

Transactions

Documents

Announcements

Profile

HOW IMPORTED DATA APPEARS
Dashboard (Investor Home)

Show:

Total Amount Invested

Active Investments

ROI Rate (if available)

Last Payment Date

My Investments

For each investment:

Land name

Block name

Unit

Investment year & month

MOA status:

“MOA Signed” (green)

“MOA Pending” (yellow)

Transactions

Display:

Payment year (Year 1, Year 2, Year 3)

Amount paid

Payment date

Status (Paid / Pending)

Must support:

Historical payments imported from Excel

Future admin-added payments

Documents

Display:

MOA documents

Land documentation

Investment-related files

Access rules:

Investor sees ONLY documents linked to their investment

Profile

Display:

Personal info (read-only where appropriate)

Next of kin details

Affiliate info (if applicable)

UX RULES

No “edit” buttons for financial or legal data

No technical import language

Clean financial-style UI

Consistent formatting for currency and dates

Design this as a private equity / asset management portal, not a SaaS app.




PROMPT 3 — PERMISSION & SECURITY BOUNDARIES

👉 Paste this last

🧠 PROMPT: PERMISSIONS & DATA BOUNDARIES

Define strict authorization rules for the system:

Admin:

Can import, edit, delete investor data

Can see failed imports and audit logs

Investor:

Can only view their own data

Cannot edit MOA, payments, or ROI

Cannot see import history or errors

Enforce this using:

Laravel Policies

Route middleware

Secure file access

Output:

Policy definitions

Middleware usage

Example authorization checks:

Admin can view all investors

Investor can view only their own data