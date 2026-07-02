<div align="center">

<img src="https://img.shields.io/badge/-⚡-6d5efc?style=for-the-badge" height="60" />

# TASKVEL

### The Complete Productivity & Compliance Operating System

<p align="center">
<strong>One platform. Every workflow.</strong><br/>
From personal task management and focus tracking to full-scale statutory compliance operations for CA firms, HR consultancies, and payroll agencies — Taskvel replaces spreadsheets, WhatsApp chaos, and scattered emails with a single, intelligent command center.
</p>

<br/>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" />
  <img src="https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white" />
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" />
  <img src="https://img.shields.io/badge/Bootstrap-5-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" />
  <img src="https://img.shields.io/badge/JavaScript-ES6-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black" />
  <img src="https://img.shields.io/badge/License-MIT-6d5efc?style=for-the-badge" />
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Status-Active%20Development-a06dfc?style=flat-square" />
  <img src="https://img.shields.io/badge/Modules-2-6d5efc?style=flat-square" />
  <img src="https://img.shields.io/badge/PRs-Welcome-2ecc71?style=flat-square" />
</p>

<br/>

**⭐ If Taskvel saves you time, consider starring the repository — it genuinely helps.**

<br/>

[Overview](#-overview) •
[Modules](#-two-powerful-modules-one-platform) •
[Features](#-feature-deep-dive) •
[Stack](#️-technology-stack) •
[Architecture](#-architecture) •
[Installation](#-installation) •
[Roadmap](#-roadmap) •
[Contributing](#-contributing)

</div>

<br/>

---

<br/>

## 🚀 Overview

Taskvel began as a personal productivity suite — a beautifully designed home for tasks, focus sessions, and daily discipline. It has since evolved into something bigger: **a dual-module platform** that serves both individuals chasing personal productivity *and* compliance-driven businesses managing dozens (or thousands) of clients across GST, EPF, ESIC, payroll, and statutory registrations.

Instead of stitching together Excel trackers, WhatsApp threads, and inbox searches, Taskvel centralizes everything — tasks, focus time, client relationships, filings, documents, payments, and communication — into one clean, fast, dependable system built on Laravel.

> **Built for two audiences. One codebase. Zero compromises.**

<br/>

## 🧩 Two Powerful Modules, One Platform

<table>
<tr>
<td width="50%" valign="top">

### ⚡ Productivity Suite
*For individuals & teams*

Personal task management, Pomodoro-driven focus sessions, productivity analytics, and team collaboration — designed to help anyone plan their day and protect their attention.

**Best for:** Freelancers, professionals, startups, internal teams

</td>
<td width="50%" valign="top">

### 🏢 Compliance & Client Management
*For CA firms, HR & payroll agencies*

An enterprise-grade command center for GST, EPF, ESIC, payroll, registrations, and every recurring statutory filing — with a full client timeline, document vault, and automated reminders.

**Best for:** CA firms, compliance consultancies, payroll processors

</td>
</tr>
</table>

<br/>

---

<br/>

## ✨ Feature Deep Dive

<br/>

### 📋 Smart Task Management

<table>
<tr><td>

- Unlimited tasks across projects & workspaces
- Categories, labels & custom tags
- Priority levels with smart sorting
- Due dates with deadline alerts
- Rich notes & subtasks
- Task completion progress tracking
- File attachments
- Favorites, history & archive system

</td></tr>
</table>

<br/>

### 🎯 Intelligent Prioritization

Work is automatically organized using urgency, due dates, and manual ranking — so the most important task is always the most visible one. Never lose track of what actually matters.

<br/>

### ⏱ Pomodoro Focus System

<table>
<tr><td>

- 25/5 and 50/10 focus sessions
- Fully custom timer durations
- Automatic break scheduling
- Session-level statistics
- Daily & weekly focus reports
- Long-term productivity tracking

</td></tr>
</table>

<br/>

### 📊 Analytics Dashboard

A real-time pulse on personal or team output — daily and monthly productivity, completion rate, pending workload, focus hours, and performance trends, all visualized clearly.

<br/>

### 👥 Team Collaboration

Shared projects, task assignment, activity timelines, internal comments, and a live team dashboard — purpose-built for agencies and growing teams.

<br/>

### 📅 Calendar & Planning

Weekly and monthly planner views, a unified calendar, and a running timeline of upcoming deadlines so nothing slips through the cracks.

<br/>

### 🔔 Smart Notifications

Due-soon alerts, overdue task flags, browser and email notifications, plus daily and weekly digest summaries — delivered exactly when they matter.

<br/>

---

<br/>

## 🏢 Compliance & Client Management Module

<div align="center">

**The core engine for firms managing statutory compliance at scale.**

</div>

<br/>

This module is built to eliminate manual Excel sheets, WhatsApp-based tracking, and endless email searches — replacing them with one digital workflow per client, covering every service a compliance firm offers.

### Supported Compliance Services

<table>
<tr>
<td width="33%" valign="top">

**Registrations**
- ESIC Registration
- EPF Registration
- GST Registration
- Professional Tax Registration
- Labour License
- Shop & Establishment
- Trade License
- MSME / UDYAM
- Company Incorporation
- LLP Registration
- Partnership Registration
- IEC Registration
- FSSAI Registration
- Digital Signature Certificate

</td>
<td width="33%" valign="top">

**Recurring Filings**
- ESIC Monthly Filing
- EPF Monthly Filing
- GST Returns (GSTR-1, GSTR-3B, Annual)
- Professional Tax Filing
- TDS Return Filing
- Income Tax Return Filing

</td>
<td width="33%" valign="top">

**Operations**
- Payroll Management
- Salary Processing
- TAN/PAN Services
- Custom Compliance Services

</td>
</tr>
</table>

> The service catalog is **fully modular** — new compliance services can be added anytime without touching the database structure.

<br/>

### 🗂️ Core Compliance Modules

<br/>

**1. Client Management**
Complete client profiles — company details, contacts, GST/PAN/TAN/ESIC/EPF numbers, address, assigned executive, and a full activity timeline per client.

**2. Compliance Service Management**
Each client can hold multiple active services simultaneously (e.g. GST + ESIC + EPF + Payroll), each with its own frequency — monthly, quarterly, yearly, or one-time — and its own assigned staff member.

**3. Monthly Compliance Tracker** — *the heart of the system*
Every month, pending compliance tasks are generated automatically per client per service, tracked through a detailed status pipeline:

```
Pending → Documents Awaiting → Documents Received → Under Review
   → Filed → Verified → Completed
   
   (or) → Rejected → Revised → Late Filed / Missed Deadline
```

The dashboard instantly surfaces total filings, completed, pending, missed, late, and everything due today, this week, this month, and overdue.

**4. Registration Management**
A dedicated pipeline for tracking new registrations end-to-end:

```
Application Submitted → Verification Pending → Department Query
   → Approved → Certificate Uploaded
```

Stores application dates, approval dates, certificates, login credentials, and acknowledgement numbers.

**5. Payroll Module**
Monthly salary sheets, attendance, new joiners, exits, salary revisions, bonuses, and PF/ESIC changes — building a complete, auditable payroll history over time.

**6. Employee Management**
Full employee records including UAN, ESIC and PF numbers, salary, designation, documents (Aadhar, PAN, bank details, joining letters), and exit tracking.

**7. Document Management**
A digital vault per client, organized into folders (GST, ESIC, EPF, Payroll, Registrations, Agreements, Invoices, Certificates, and more) — with full version history.

**8. Communication Center**
Every email, WhatsApp message, phone note, and internal remark automatically becomes part of a single chronological client timeline — no more digging through five different apps to reconstruct a conversation.

**9 & 10. WhatsApp + Email Integration**
Incoming WhatsApp messages and monitored inbox emails are automatically parsed, matched to the right client, attached to their timeline, and converted into notifications or pending tasks — with the ability to reply directly from the dashboard.

**11. Notification Center**
Real-time alerts for document uploads, salary sheet receipt, payments, filing deadlines, department queries, registration approvals, and overdue invoices — via push, email, and browser (SMS planned).

**12. Task Management**
Every filing automatically spins up its own task checklist — collect documents, verify, generate challan, upload return, download receipt, notify client — each with priority, due date, assignee, and completion percentage.

**13. Payment & Invoice Management**
Full invoicing lifecycle: receipts, advances, partial payments, overdue tracking, credit notes, GST-compliant invoice PDFs, and a revenue dashboard broken down by month and client.

**14. Reminder Engine**
Automated reminders (daily, weekly, monthly, or custom) sent via email, WhatsApp, or push notification for pending salary sheets, upcoming due dates, and outstanding payments.

**15. Internal Remarks**
Private or client-visible notes, staff mentions, follow-up flags, escalation notes, and threaded replies — all attachable to any client record.

**16. Audit Timeline**
Every meaningful action — logins, uploads, filings, payments, status changes, deletions — is logged and fully searchable for complete accountability.

**17. Reports**
Monthly filing reports, pending/missed compliance reports, client-wise and employee-wise breakdowns, revenue reports, outstanding payments, and executive performance — all exportable to Excel, CSV, or PDF.

**18. Dual Dashboards**
- **Executive Dashboard:** today's work, pending tasks, recent messages, upcoming deadlines, clients awaiting documents
- **Admin Dashboard:** total clients, monthly revenue, compliance completion %, outstanding amounts, and firm-wide notifications

**19. Role & Permission Management**
Granular, Spatie-powered roles: Super Admin, Admin, Compliance Executive, Payroll Executive, Accounts, Data Entry Operator, and Viewer.

**20. Search & Filters**
Instant search across clients, GST/PAN numbers, employees, registration numbers, invoices, executives, statuses, and custom date ranges.

**21. Compliance Calendar**
A visual, unified calendar of every GST, ESIC, EPF, payroll, and registration deadline — alongside client meetings and public holidays.

**22. AI Assistance** *(Future-Ready)*
Planned intelligence layer for detecting missing documents, flagging late filings and high-risk clients, suggesting replies, auto-generating reminders, OCR on uploaded PDFs, and automatic salary sheet extraction.

**23. Mobile-Friendly Client Portal**
Clients get their own secure login to upload documents, track filing status, download challans and certificates, view invoices, make payments, and chat directly with their compliance team.

<br/>

---

<br/>

## 🌙 Interface & Experience

Both modules share a single, cohesive design language:

<table>
<tr><td width="50%">

✅ Fully responsive across desktop, tablet & mobile
✅ Dark mode & light mode
✅ Premium, glassmorphic dashboard UI
✅ Smooth, purposeful animations

</td><td width="50%">

✅ Modern, consistent component library
✅ Optimized for touch and keyboard alike
✅ Accessible color contrast
✅ Fast, no-clutter navigation

</td></tr>
</table>

<br/>

---

<br/>

## ⚙️ Technology Stack

<div align="center">

| Layer | Technology |
|:---|:---|
| **Backend Framework** | Laravel 12 |
| **Language** | PHP 8.3 |
| **Database** | MySQL |
| **Templating** | Blade |
| **Styling** | Bootstrap 5 + Custom Design System |
| **Interactivity** | JavaScript (ES6) |
| **Authentication** | Laravel Auth |
| **Authorization** | Spatie Laravel-Permission |
| **File Storage** | Local / Cloud (S3-ready) |
| **Background Jobs** | Laravel Queue |
| **Email** | Laravel Mail |
| **Messaging** | WhatsApp Business API *(planned integration)* |

</div>

<br/>

---

<br/>

## 🏗 Architecture

```
                    ┌─────────────┐
                    │    User     │
                    └──────┬──────┘
                           │
                    ┌──────▼──────┐
                    │   Routing   │
                    └──────┬──────┘
                           │
                    ┌──────▼──────┐
                    │ Controllers │
                    └──────┬──────┘
                           │
                    ┌──────▼──────┐
                    │  Services   │
                    └──────┬──────┘
                           │
                    ┌──────▼──────┐
                    │Repositories │
                    └──────┬──────┘
                           │
                    ┌──────▼──────┐
                    │   Models    │
                    └──────┬──────┘
                           │
                    ┌──────▼──────┐
                    │  Database   │
                    └─────────────┘
```

<br/>

## 📂 Project Structure

```
taskvel/
├── app/
│   ├── Http/              → Controllers, Middleware, Requests
│   ├── Models/             → Eloquent models (Tasks, Clients, Filings...)
│   ├── Services/           → Business logic layer
│   ├── Policies/           → Authorization rules
│   └── Providers/          → Service providers
│
├── bootstrap/
├── config/
├── database/
│   ├── migrations/         → Schema for both modules
│   ├── factories/
│   └── seeders/
│
├── public/
├── resources/
│   ├── views/               → Blade templates
│   ├── css/                 → App & module-specific styles
│   └── js/                  → Frontend interactivity
│
├── routes/
├── storage/
├── tests/
└── vendor/
```

<br/>

---

<br/>

## 📸 Screenshots

<div align="center">

| Dashboard | Tasks | Compliance Tracker | Client Timeline |
|:---:|:---:|:---:|:---:|
| *Coming Soon* | *Coming Soon* | *Coming Soon* | *Coming Soon* |

</div>

<br/>

---

<br/>

## 🚀 Installation

```bash
# 1. Clone the repository
git clone https://github.com/YOUR_USERNAME/taskvel.git
cd taskvel

# 2. Install PHP dependencies
composer install

# 3. Configure environment
cp .env.example .env
php artisan key:generate

# 4. Set up the database
php artisan migrate

# 5. Install & build frontend assets
npm install
npm run build

# 6. Serve the application
php artisan serve
```

Then open:

```
http://127.0.0.1:8000
```

<br/>

---

<br/>

## 📌 Roadmap

<table>
<tr>
<td width="50%" valign="top">

### Productivity Suite
- [x] Task Management
- [x] Focus / Pomodoro System
- [x] Analytics Dashboard
- [ ] Kanban Board
- [ ] Habit Tracker
- [ ] Goal Management
- [ ] Google Calendar Integration
- [ ] Outlook Sync

</td>
<td width="50%" valign="top">

### Compliance Module
- [x] Client & Service Management
- [x] Monthly Compliance Tracker
- [ ] WhatsApp Business API Integration
- [ ] Email Auto-Ingestion Engine
- [ ] AI Document Extraction (OCR)
- [ ] Client Mobile Portal
- [ ] REST API for third-party integrations
- [ ] Webhooks & Slack Integration

</td>
</tr>
</table>

<div align="center">

**Platform-wide:** Role & Permission Management • Multi-Workspace Support • Mobile App • REST API

</div>

<br/>

---

<br/>

## 🔒 Security

Taskvel is built on Laravel's security foundation, hardened for production use:

<table>
<tr><td width="50%">

✅ CSRF Protection
✅ XSS Protection
✅ SQL Injection Prevention
✅ Password Hashing (bcrypt/argon2)

</td><td width="50%">

✅ Request Validation
✅ Authorization Policies (Spatie)
✅ Rate Limiting
✅ Secure, Encrypted Sessions

</td></tr>
</table>

<br/>

## ⚡ Performance

<table>
<tr><td width="50%">

✅ Optimized, indexed database queries
✅ Eager & lazy loading where appropriate
✅ Background queue processing

</td><td width="50%">

✅ Application-level caching
✅ Minified, bundled frontend assets
✅ Efficient, normalized schema design

</td></tr>
</table>

<br/>

---

<br/>

## 🤝 Contributing

Contributions of every size are welcome — from typo fixes to entire new modules.

```bash
# 1. Fork the repository

# 2. Create a feature branch
git checkout -b feature/new-feature

# 3. Commit your changes
git commit -m "Add amazing feature"

# 4. Push the branch
git push origin feature/new-feature

# 5. Open a Pull Request
```

<br/>

## 📝 License

Distributed under the **MIT License**. See the `LICENSE` file for full details.

<br/>

---

<br/>

<div align="center">

## 👨‍💻 Author

**Mrinal Kanth Padhi**
*Senior Full Stack Laravel Developer*

<p>
  <img src="https://img.shields.io/badge/Laravel-FF2D20?style=flat-square&logo=laravel&logoColor=white" />
  <img src="https://img.shields.io/badge/PHP-777BB4?style=flat-square&logo=php&logoColor=white" />
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=flat-square&logo=mysql&logoColor=white" />
  <img src="https://img.shields.io/badge/REST%20APIs-6d5efc?style=flat-square" />
  <img src="https://img.shields.io/badge/WordPress-21759B?style=flat-square&logo=wordpress&logoColor=white" />
  <img src="https://img.shields.io/badge/React-61DAFB?style=flat-square&logo=react&logoColor=black" />
  <img src="https://img.shields.io/badge/Bootstrap-7952B3?style=flat-square&logo=bootstrap&logoColor=white" />
</p>

<br/>

## 🌟 Support This Project

If Taskvel is useful to you or your firm:

**⭐ Star the repository** · **🍴 Fork it** · **🐛 Report bugs** · **💡 Suggest features** · **🤝 Contribute improvements**

<br/>

---

<br/>

### 🚀 Build Better. Stay Focused. Ship Faster.

**Made with ❤️ using Laravel.**

</div>
