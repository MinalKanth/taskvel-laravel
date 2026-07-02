<div align="center">

<img src="https://img.shields.io/badge/-⚡-6d5efc?style=for-the-badge" height="70" />

<br/>

# TASKVEL

<p align="center">
  <img src="https://img.shields.io/badge/Made%20with-Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" />
</p>

### The Complete Compliance & Productivity Operating System

<p align="center">
<strong>One platform. Every workflow.</strong><br/>
An enterprise-grade Compliance Management & Client Relationship System for CA firms, HR consultancies, and payroll agencies — paired with a premium personal productivity suite for tasks, focus, and daily execution.
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

**⭐ If Taskvel saves your firm or your day, consider starring the repository.**

<br/>

[Overview](#-overview) •
[Compliance Module](#-compliance--client-management-system) •
[Productivity Suite](#-productivity-suite) •
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

Taskvel is a modern, enterprise-grade platform built on Laravel with two purposes at its core.

At its heart is a **Compliance Management & Client Relationship System** — purpose-built for CA firms, HR consultancies, payroll agencies, and compliance service providers who need to manage GST, EPF, ESIC, payroll, and statutory registrations for hundreds of clients without drowning in spreadsheets, WhatsApp threads, and inbox searches.

Alongside it sits a **premium Productivity Suite** — task management, Pomodoro-driven focus sessions, and productivity analytics for individuals and internal teams who simply want to plan their day and protect their attention.

Both modules share one codebase, one design language, and zero compromises.

<br/>

---

<br/>

## 🏢 Compliance & Client Management System

<div align="center">

### The Core Engine of Taskvel

Built to eliminate manual Excel sheets, WhatsApp-based tracking, and endless email searches — replacing them with one digital, auditable workflow per client, covering every compliance service a firm offers.

</div>

<br/>

### 📜 Supported Compliance Services

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

> 🧩 The service catalog is **fully modular** — new compliance services can be added anytime without touching the database structure.

<br/>

### 🗂️ Core Compliance Modules

<br/>

**1 · Client Management**
Complete client profiles — company details, contacts, GST/PAN/TAN/ESIC/EPF numbers, address, assigned executive, and a full activity timeline per client.

**2 · Compliance Service Management**
Each client can hold multiple active services simultaneously — GST, ESIC, EPF, Payroll — each with its own frequency (monthly, quarterly, yearly, one-time) and assigned staff member.

**3 · Monthly Compliance Tracker** — *the heart of the system*
Every month, pending compliance tasks generate automatically per client per service, tracked through a full status pipeline:

```
 Pending → Documents Awaiting → Documents Received → Under Review
    → Filed → Verified → Completed

    ↘ Rejected → Revised → Late Filed / Missed Deadline
```

The dashboard instantly surfaces total filings, completed, pending, missed, late, and everything due today, this week, this month, and overdue.

**4 · Registration Management**
A dedicated pipeline for new registrations end-to-end:

```
 Application Submitted → Verification Pending → Department Query
    → Approved → Certificate Uploaded
```

Stores application dates, approval dates, certificates, login credentials, and acknowledgement numbers.

**5 · Payroll Module**
Monthly salary sheets, attendance, new joiners, exits, salary revisions, bonuses, and PF/ESIC changes — building a complete, auditable payroll history over time.

**6 · Employee Management**
Full employee records including UAN, ESIC and PF numbers, salary, designation, documents (Aadhar, PAN, bank details, joining letters), and exit tracking.

**7 · Document Management**
A digital vault per client, organized into folders — GST, ESIC, EPF, Payroll, Registrations, Agreements, Invoices, Certificates, and more — with full version history.

**8 · Communication Center**
Every email, WhatsApp message, phone note, and internal remark automatically becomes part of a single chronological client timeline — no more reconstructing conversations across five different apps.

**9 · WhatsApp Integration**
Incoming WhatsApp messages and attachments are automatically matched to the right client, attached to their timeline, and converted into notifications or pending tasks — with the ability to reply directly from the dashboard.

**10 · Email Integration**
A monitored inbox is auto-parsed — attachments downloaded, clients identified, timelines updated, and pending tasks created, all repliable from within Taskvel.

**11 · Notification Center**
Real-time alerts for document uploads, salary sheet receipt, payments, filing deadlines, department queries, registration approvals, and overdue invoices — via push, email, and browser *(SMS planned)*.

**12 · Task Management**
Every filing automatically spins up its own task checklist — collect documents, verify, generate challan, upload return, download receipt, notify client — each with priority, due date, assignee, and completion percentage.

**13 · Payment & Invoice Management**
Full invoicing lifecycle: receipts, advances, partial payments, overdue tracking, credit notes, GST-compliant invoice PDFs, and a revenue dashboard broken down by month and client.

**14 · Reminder Engine**
Automated reminders — daily, weekly, monthly, or custom — sent via email, WhatsApp, or push notification for pending salary sheets, upcoming due dates, and outstanding payments.

**15 · Internal Remarks**
Private or client-visible notes, staff mentions, follow-up flags, escalation notes, and threaded replies — attachable to any client record.

**16 · Audit Timeline**
Every meaningful action — logins, uploads, filings, payments, status changes, deletions — is logged and fully searchable for complete accountability.

**17 · Reports**
Monthly filing reports, pending/missed compliance reports, client-wise and employee-wise breakdowns, revenue reports, outstanding payments, and executive performance — exportable to Excel, CSV, or PDF.

**18 · Dual Dashboards**

<table>
<tr>
<td width="50%" valign="top">

**Executive Dashboard**
Today's work, pending tasks, recent messages, upcoming deadlines, clients awaiting documents

</td>
<td width="50%" valign="top">

**Admin Dashboard**
Total clients, monthly revenue, compliance completion %, outstanding amounts, firm-wide notifications

</td>
</tr>
</table>

**19 · Role & Permission Management**
Granular, Spatie-powered roles: Super Admin, Admin, Compliance Executive, Payroll Executive, Accounts, Data Entry Operator, and Viewer.

**20 · Search & Filters**
Instant search across clients, GST/PAN numbers, employees, registration numbers, invoices, executives, statuses, and custom date ranges.

**21 · Compliance Calendar**
A visual, unified calendar of every GST, ESIC, EPF, payroll, and registration deadline — alongside client meetings and public holidays.

**22 · AI Assistance** *(Future-Ready)*
A planned intelligence layer for detecting missing documents, flagging late filings and high-risk clients, suggesting replies, auto-generating reminders, OCR on uploaded PDFs, and automatic salary sheet extraction.

**23 · Mobile-Friendly Client Portal**
Clients get their own secure login to upload documents, track filing status, download challans and certificates, view invoices, make payments, and chat directly with their compliance team.

<br/>

---

<br/>

## ⚡ Productivity Suite

<div align="center">

*Personal task management, deep focus, and productivity analytics — for anyone who wants to plan their day and protect their attention.*

</div>

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

Work is automatically organized using urgency, due dates, and manual ranking — so the most important task is always the most visible one.

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

## 🌙 Interface & Experience

Both modules share one cohesive, premium design language:

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
│   ├── Models/             → Eloquent models (Clients, Filings, Tasks...)
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

| Compliance Tracker | Client Timeline | Productivity Dashboard | Focus Mode |
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
</tr>
</table>

<div align="center">

**Platform-wide:** Role & Permission Management • Multi-Workspace Support • Mobile App • REST API

</div>

<br/>

---

<br/>

## 🔒 Security

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

### 🚀 Build Better. Stay Compliant. Ship Faster.

**Made with ❤️ using Laravel.**

</div>
