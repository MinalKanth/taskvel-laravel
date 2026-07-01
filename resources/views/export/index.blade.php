@extends('layouts.app')

@section('title', 'Export Data')

@section('content')

<div class="export-page">

    {{-- ===== Hero Header ===== --}}
    <div class="export-hero">

        <div class="export-hero-glow"></div>

        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">

            <div>
                <span class="export-hero-badge">
                    <i class="bi bi-cloud-arrow-down-fill"></i>
                    Data Export Center
                </span>

                <h2 class="export-hero-title">Export Your Data</h2>

                <p class="export-hero-subtitle">
                    Download tasks, focus sessions, or a full summary — in PDF, Excel, or CSV.
                </p>
            </div>

            <a href="{{ route('dashboard') }}" class="export-back-btn">
                <i class="bi bi-arrow-left"></i>
                Dashboard
            </a>

        </div>

    </div>

    {{-- ===== Main Export Card ===== --}}
    <div class="row justify-content-center">

        <div class="col-lg-10">

            <div class="export-card">

                <form method="POST" action="{{ route('export.download') }}" id="exportForm">

                    @csrf

                    <input type="hidden" name="type" id="exportType" value="tasks">

                    {{-- ===== Step 1: What to Export ===== --}}
                    <div class="export-section">

                        <div class="export-step">
                            <span class="export-step-num">1</span>
                            <div>
                                <h6 class="export-step-title">What do you want to export?</h6>
                                <p class="export-step-desc">Choose the dataset to download.</p>
                            </div>
                        </div>

                        <div class="type-grid">

                            <button type="button" class="type-card active" data-type="tasks">
                                <div class="type-icon type-icon-purple">
                                    <i class="bi bi-check2-square"></i>
                                </div>
                                <h6>Tasks</h6>
                                <p>All task records with tags, dates &amp; status.</p>
                            </button>

                            <button type="button" class="type-card" data-type="focus">
                                <div class="type-icon type-icon-blue">
                                    <i class="bi bi-stopwatch-fill"></i>
                                </div>
                                <h6>Focus Sessions</h6>
                                <p>Timer history, duration &amp; interruptions.</p>
                            </button>

                            <button type="button" class="type-card" data-type="summary">
                                <div class="type-icon type-icon-green">
                                    <i class="bi bi-bar-chart-line-fill"></i>
                                </div>
                                <h6>Summary Report</h6>
                                <p>High-level productivity metrics overview.</p>
                            </button>

                        </div>

                    </div>

                    <div class="export-divider"></div>

                    {{-- ===== Step 2: Filters ===== --}}
                    <div class="export-section" id="filterSection">

                        <div class="export-step">
                            <span class="export-step-num">2</span>
                            <div>
                                <h6 class="export-step-title">Filter your data</h6>
                                <p class="export-step-desc">Narrow the export by date, status, or priority.</p>
                            </div>
                        </div>

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="export-label">From Date</label>
                                <div class="export-input-wrap">
                                    <i class="bi bi-calendar3"></i>
                                    <input type="date" name="from_date" id="fromDateInput" value="{{ old('from_date') }}" class="export-input">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="export-label">To Date</label>
                                <div class="export-input-wrap">
                                    <i class="bi bi-calendar3"></i>
                                    <input type="date" name="to_date" id="toDateInput" value="{{ old('to_date') }}" class="export-input">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="date-presets">
                                    <button type="button" class="preset-chip" data-range="today">Today</button>
                                    <button type="button" class="preset-chip" data-range="week">This Week</button>
                                    <button type="button" class="preset-chip" data-range="month">This Month</button>
                                    <button type="button" class="preset-chip" data-range="30days">Last 30 Days</button>
                                    <button type="button" class="preset-chip" data-range="all">All Time</button>
                                </div>
                            </div>

                            <div class="col-md-6 task-filter-only">
                                <label class="export-label">Status</label>
                                <div class="export-input-wrap">
                                    <i class="bi bi-flag-fill"></i>
                                    <select name="status" class="export-input export-select">
                                        <option value="">All Status</option>
                                        <option value="pending">Pending</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="completed">Completed</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 task-filter-only">
                                <label class="export-label">Priority</label>
                                <div class="export-input-wrap">
                                    <i class="bi bi-exclamation-diamond-fill"></i>
                                    <select name="priority" class="export-input export-select">
                                        <option value="">All Priorities</option>
                                        <option value="low">Low</option>
                                        <option value="medium">Medium</option>
                                        <option value="high">High</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 task-filter-only">
                                <label class="export-label">Columns to Include</label>
                                <div class="column-grid">
                                    <label class="column-chip"><input type="checkbox" name="columns[]" value="title" checked><span>Title</span></label>
                                    <label class="column-chip"><input type="checkbox" name="columns[]" value="description" checked><span>Description</span></label>
                                    <label class="column-chip"><input type="checkbox" name="columns[]" value="priority" checked><span>Priority</span></label>
                                    <label class="column-chip"><input type="checkbox" name="columns[]" value="status" checked><span>Status</span></label>
                                    <label class="column-chip"><input type="checkbox" name="columns[]" value="due_date" checked><span>Due Date</span></label>
                                    <label class="column-chip"><input type="checkbox" name="columns[]" value="estimated_minutes"><span>Estimated Time</span></label>
                                    <label class="column-chip"><input type="checkbox" name="columns[]" value="actual_minutes"><span>Actual Time</span></label>
                                    <label class="column-chip"><input type="checkbox" name="columns[]" value="tags" checked><span>Tags</span></label>
                                    <label class="column-chip"><input type="checkbox" name="columns[]" value="created_at"><span>Created Date</span></label>
                                </div>
                                <div class="column-actions">
                                    <button type="button" class="column-link" id="selectAllCols">Select all</button>
                                    <span class="column-sep">·</span>
                                    <button type="button" class="column-link" id="selectNoneCols">Clear</button>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="export-divider"></div>

                    {{-- ===== Step 3: Format ===== --}}
                    <div class="export-section">

                        <div class="export-step">
                            <span class="export-step-num">3</span>
                            <div>
                                <h6 class="export-step-title">Choose a format</h6>
                                <p class="export-step-desc">Pick the file type for your download.</p>
                            </div>
                        </div>

                        <div class="format-grid">

                            <label class="format-card">
                                <input type="radio" name="format" value="pdf" checked>
                                <div class="format-icon format-icon-pdf">
                                    <i class="bi bi-file-earmark-pdf-fill"></i>
                                </div>
                                <h6>PDF</h6>
                                <p>Printable report with summaries.</p>
                                <span class="format-check"><i class="bi bi-check-circle-fill"></i></span>
                            </label>

                            <label class="format-card">
                                <input type="radio" name="format" value="excel">
                                <div class="format-icon format-icon-excel">
                                    <i class="bi bi-file-earmark-excel-fill"></i>
                                </div>
                                <h6>Excel</h6>
                                <p>Spreadsheet for deeper analysis.</p>
                                <span class="format-check"><i class="bi bi-check-circle-fill"></i></span>
                            </label>

                            <label class="format-card">
                                <input type="radio" name="format" value="csv">
                                <div class="format-icon format-icon-csv">
                                    <i class="bi bi-filetype-csv"></i>
                                </div>
                                <h6>CSV</h6>
                                <p>Lightweight, universal format.</p>
                                <span class="format-check"><i class="bi bi-check-circle-fill"></i></span>
                            </label>

                        </div>

                    </div>

                    {{-- ===== Submit ===== --}}
                    <div class="export-submit-bar">

                        <div class="export-summary-chip">
                            <i class="bi bi-info-circle"></i>
                            <span id="exportSummaryText">Exporting <strong>Tasks</strong> as <strong>PDF</strong></span>
                        </div>

                        <button type="submit" class="export-submit-btn">
                            <i class="bi bi-download"></i>
                            Export Data
                        </button>

                    </div>

                </form>

            </div>

            {{-- ===== Saved Presets + Export History ===== --}}
            <div class="row g-3 mt-4">

                <div class="col-md-6">
                    <div class="side-panel">
                        <div class="side-panel-header">
                            <h6><i class="bi bi-bookmark-star-fill"></i> Saved Presets</h6>
                            <button type="button" class="side-panel-action" id="savePresetBtn">
                                <i class="bi bi-plus-lg"></i> Save Current
                            </button>
                        </div>
                        <div id="presetList" class="side-panel-list">
                            <div class="side-panel-empty" id="presetEmpty">No saved presets yet.</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="side-panel">
                        <div class="side-panel-header">
                            <h6><i class="bi bi-clock-history"></i> Recent Exports</h6>
                        </div>
                        <div id="historyList" class="side-panel-list">
                            <div class="side-panel-empty" id="historyEmpty">No exports yet this session.</div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ===== Info Cards ===== --}}
            <div class="row g-3 mt-4">

                <div class="col-md-4">
                    <div class="info-card">
                        <div class="info-icon info-icon-red">
                            <i class="bi bi-file-earmark-pdf"></i>
                        </div>
                        <h6>PDF Export</h6>
                        <p>Printable report with charts and summaries — perfect for sharing or archiving.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="info-card">
                        <div class="info-icon info-icon-green">
                            <i class="bi bi-file-earmark-excel"></i>
                        </div>
                        <h6>Excel Export</h6>
                        <p>Full spreadsheet with sortable columns — ideal for deeper analysis.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="info-card">
                        <div class="info-icon info-icon-blue">
                            <i class="bi bi-filetype-csv"></i>
                        </div>
                        <h6>CSV Export</h6>
                        <p>Lightweight, universal format — great for migrating into other tools.</p>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

{{-- ===== Loading Overlay ===== --}}
<div class="export-loading-overlay" id="exportLoadingOverlay">
    <div class="export-loading-box">
        <div class="export-loading-ring"></div>
        <h6>Preparing your export…</h6>
        <p>This usually takes a few seconds.</p>
    </div>
</div>

<style>
    /* ===== Hero ===== */
    .export-hero {
        position: relative;
        overflow: hidden;
        border-radius: 22px;
        padding: 36px 40px;
        margin-bottom: 28px;
        background: linear-gradient(135deg, #4c3fd8, #6d5efc 45%, #a06dfc);
        box-shadow: 0 20px 50px rgba(109, 94, 252, 0.28);
    }
    .export-hero-glow {
        position: absolute;
        top: -60px;
        right: -60px;
        width: 260px;
        height: 260px;
        background: radial-gradient(circle, rgba(255,255,255,0.18), transparent 70%);
        pointer-events: none;
    }
    .export-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 14px;
        border-radius: 20px;
        background: rgba(255,255,255,0.16);
        color: #fff;
        font-size: .78rem;
        font-weight: 600;
        letter-spacing: .02em;
        margin-bottom: 14px;
    }
    .export-hero-title {
        color: #fff;
        font-weight: 800;
        font-size: 2rem;
        letter-spacing: -.02em;
        margin-bottom: 6px;
    }
    .export-hero-subtitle {
        color: rgba(255,255,255,0.78);
        font-size: .95rem;
        margin-bottom: 0;
    }
    .export-back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border-radius: 12px;
        background: rgba(255,255,255,0.14);
        color: #fff;
        text-decoration: none;
        font-weight: 600;
        font-size: .88rem;
        transition: all .2s ease;
        backdrop-filter: blur(6px);
    }
    .export-back-btn:hover { background: rgba(255,255,255,0.24); color: #fff; transform: translateY(-1px); }

    /* ===== Main Card ===== */
    .export-card {
        background: #fff;
        border-radius: 22px;
        border: 1px solid rgba(17, 12, 46, 0.06);
        box-shadow: 0 12px 40px rgba(17, 12, 46, 0.06);
        padding: 36px;
    }
    .export-section { padding: 6px 0 24px; }
    .export-divider { height: 1px; background: rgba(17, 12, 46, 0.06); margin: 4px 0 24px; }

    .export-step { display: flex; gap: 14px; margin-bottom: 22px; align-items: flex-start; }
    .export-step-num {
        width: 30px; height: 30px; flex-shrink: 0;
        border-radius: 9px;
        background: linear-gradient(135deg, #6d5efc, #a06dfc);
        color: #fff; font-weight: 700; font-size: .85rem;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 6px 16px rgba(109, 94, 252, 0.35);
    }
    .export-step-title { font-weight: 700; margin-bottom: 2px; color: #1c1c28; }
    .export-step-desc { font-size: .82rem; color: #8a8a9a; margin-bottom: 0; }

    /* ===== Type Cards ===== */
    .type-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
    .type-card {
        border: 2px solid rgba(17, 12, 46, 0.07);
        background: #fbfbfe;
        border-radius: 16px;
        padding: 20px;
        text-align: left;
        cursor: pointer;
        transition: all .2s ease;
    }
    .type-card:hover { border-color: rgba(109, 94, 252, 0.35); transform: translateY(-2px); }
    .type-card.active {
        border-color: #6d5efc;
        background: linear-gradient(160deg, rgba(109, 94, 252, 0.08), rgba(160, 109, 252, 0.03));
        box-shadow: 0 8px 24px rgba(109, 94, 252, 0.15);
    }
    .type-icon {
        width: 42px; height: 42px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 1.1rem; margin-bottom: 12px;
    }
    .type-icon-purple { background: linear-gradient(135deg, #6d5efc, #a06dfc); }
    .type-icon-blue { background: linear-gradient(135deg, #3b9dfc, #6dc6fc); }
    .type-icon-green { background: linear-gradient(135deg, #2ecc71, #6de6a0); }
    .type-card h6 { font-weight: 700; margin-bottom: 4px; color: #1c1c28; }
    .type-card p { font-size: .8rem; color: #8a8a9a; margin-bottom: 0; }

    /* ===== Inputs ===== */
    .export-label { font-size: .82rem; font-weight: 600; color: #4b4b5a; margin-bottom: 6px; display: block; }
    .export-input-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }
    .export-input-wrap i {
        position: absolute; left: 14px; color: #a0a0b0; font-size: .9rem; pointer-events: none;
    }
    .export-input {
        width: 100%;
        padding: 11px 14px 11px 40px;
        border-radius: 12px;
        border: 1.5px solid rgba(17, 12, 46, 0.08);
        background: #f8f8fc;
        font-size: .88rem;
        color: #1c1c28;
        transition: all .2s ease;
    }
    .export-input:focus {
        outline: none;
        border-color: #6d5efc;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(109, 94, 252, 0.1);
    }
    .export-select { appearance: none; }

    /* ===== Date Presets ===== */
    .date-presets { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 6px; }
    .preset-chip {
        padding: 7px 14px;
        border-radius: 20px;
        border: 1.5px solid rgba(17, 12, 46, 0.08);
        background: #fbfbfe;
        color: #5b5b6b;
        font-size: .78rem;
        font-weight: 600;
        transition: all .15s ease;
    }
    .preset-chip:hover { border-color: #6d5efc; color: #6d5efc; }
    .preset-chip.active {
        background: linear-gradient(135deg, #6d5efc, #a06dfc);
        border-color: transparent;
        color: #fff;
    }

    /* ===== Column Selector ===== */
    .column-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 10px; margin-top: 8px; }
    .column-chip {
        display: flex; align-items: center; gap: 8px;
        padding: 9px 12px;
        border-radius: 10px;
        border: 1.5px solid rgba(17, 12, 46, 0.07);
        background: #fbfbfe;
        font-size: .82rem;
        color: #4b4b5a;
        cursor: pointer;
        transition: all .15s ease;
    }
    .column-chip:has(input:checked) {
        border-color: #6d5efc;
        background: rgba(109, 94, 252, 0.06);
        color: #1c1c28;
    }
    .column-chip input { accent-color: #6d5efc; }
    .column-actions { margin-top: 10px; font-size: .8rem; }
    .column-link { background: none; border: none; color: #6d5efc; font-weight: 600; padding: 0; }
    .column-link:hover { text-decoration: underline; }
    .column-sep { color: #c0c0cc; margin: 0 6px; }

    /* ===== Format Cards ===== */
    .format-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
    .format-card {
        position: relative;
        border: 2px solid rgba(17, 12, 46, 0.07);
        background: #fbfbfe;
        border-radius: 16px;
        padding: 22px 18px;
        text-align: center;
        cursor: pointer;
        transition: all .2s ease;
        display: block;
    }
    .format-card input { position: absolute; opacity: 0; pointer-events: none; }
    .format-card:hover { border-color: rgba(109, 94, 252, 0.3); transform: translateY(-2px); }
    .format-card:has(input:checked) {
        border-color: #6d5efc;
        background: linear-gradient(160deg, rgba(109, 94, 252, 0.08), rgba(160, 109, 252, 0.03));
        box-shadow: 0 8px 24px rgba(109, 94, 252, 0.15);
    }
    .format-icon {
        width: 48px; height: 48px; margin: 0 auto 12px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.3rem; color: #fff;
    }
    .format-icon-pdf { background: linear-gradient(135deg, #ff5d6c, #ff8a95); }
    .format-icon-excel { background: linear-gradient(135deg, #2ecc71, #6de6a0); }
    .format-icon-csv { background: linear-gradient(135deg, #6d5efc, #a06dfc); }
    .format-card h6 { font-weight: 700; margin-bottom: 4px; color: #1c1c28; }
    .format-card p { font-size: .78rem; color: #8a8a9a; margin-bottom: 0; }
    .format-check {
        position: absolute; top: 12px; right: 12px;
        color: #6d5efc; font-size: 1.1rem;
        opacity: 0; transform: scale(.6);
        transition: all .2s ease;
    }
    .format-card:has(input:checked) .format-check { opacity: 1; transform: scale(1); }

    /* ===== Submit Bar ===== */
    .export-submit-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
        padding-top: 24px;
        border-top: 1px solid rgba(17, 12, 46, 0.06);
    }
    .export-summary-chip {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 20px;
        background: rgba(109, 94, 252, 0.08);
        color: #6d5efc;
        font-size: .82rem;
    }
    .export-submit-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 13px 28px;
        border: none;
        border-radius: 13px;
        background: linear-gradient(135deg, #6d5efc, #a06dfc);
        color: #fff;
        font-weight: 700;
        font-size: .92rem;
        box-shadow: 0 10px 26px rgba(109, 94, 252, 0.35);
        transition: all .2s ease;
    }
    .export-submit-btn:hover { transform: translateY(-2px); box-shadow: 0 14px 32px rgba(109, 94, 252, 0.45); color: #fff; }

    /* ===== Side Panels (Presets + History) ===== */
    .side-panel {
        background: #fff;
        border-radius: 18px;
        border: 1px solid rgba(17, 12, 46, 0.06);
        box-shadow: 0 8px 24px rgba(17, 12, 46, 0.04);
        padding: 20px;
        height: 100%;
    }
    .side-panel-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
    .side-panel-header h6 { font-weight: 700; color: #1c1c28; margin: 0; display: flex; align-items: center; gap: 8px; font-size: .92rem; }
    .side-panel-action {
        display: inline-flex; align-items: center; gap: 4px;
        background: rgba(109, 94, 252, 0.08);
        color: #6d5efc;
        border: none;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: .76rem;
        font-weight: 600;
    }
    .side-panel-action:hover { background: rgba(109, 94, 252, 0.16); }
    .side-panel-list { display: flex; flex-direction: column; gap: 8px; max-height: 220px; overflow-y: auto; }
    .side-panel-empty { text-align: center; color: #a0a0b0; font-size: .82rem; padding: 24px 0; }

    .side-item {
        display: flex; align-items: center; justify-content: space-between;
        padding: 10px 12px;
        border-radius: 12px;
        background: #fbfbfe;
        border: 1px solid rgba(17, 12, 46, 0.05);
    }
    .side-item-info { display: flex; flex-direction: column; }
    .side-item-title { font-size: .84rem; font-weight: 600; color: #1c1c28; }
    .side-item-meta { font-size: .72rem; color: #a0a0b0; }
    .side-item-actions { display: flex; gap: 6px; }
    .side-item-btn {
        width: 28px; height: 28px;
        display: inline-flex; align-items: center; justify-content: center;
        border: none; border-radius: 8px;
        background: rgba(109, 94, 252, 0.08);
        color: #6d5efc;
        font-size: .8rem;
        transition: all .15s ease;
    }
    .side-item-btn:hover { background: rgba(109, 94, 252, 0.18); }
    .side-item-btn.danger { background: rgba(255, 77, 109, 0.08); color: #ff4d6d; }
    .side-item-btn.danger:hover { background: rgba(255, 77, 109, 0.16); }

    /* ===== Info Cards ===== */
    .info-card {
        background: #fff;
        border-radius: 18px;
        border: 1px solid rgba(17, 12, 46, 0.06);
        box-shadow: 0 8px 24px rgba(17, 12, 46, 0.04);
        padding: 26px;
        text-align: center;
        height: 100%;
        transition: transform .2s ease, box-shadow .2s ease;
    }
    .info-card:hover { transform: translateY(-3px); box-shadow: 0 14px 32px rgba(17, 12, 46, 0.08); }
    .info-icon {
        width: 54px; height: 54px; margin: 0 auto 14px;
        border-radius: 15px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem;
    }
    .info-icon-red { background: rgba(255, 77, 109, 0.1); color: #ff4d6d; }
    .info-icon-green { background: rgba(46, 204, 113, 0.1); color: #2ecc71; }
    .info-icon-blue { background: rgba(109, 94, 252, 0.1); color: #6d5efc; }
    .info-card h6 { font-weight: 700; margin-bottom: 8px; color: #1c1c28; }
    .info-card p { font-size: .82rem; color: #8a8a9a; margin-bottom: 0; line-height: 1.5; }

    /* ===== Loading Overlay ===== */
    .export-loading-overlay {
        position: fixed; inset: 0; z-index: 2000;
        background: rgba(17, 12, 46, 0.45);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center; justify-content: center;
    }
    .export-loading-overlay.show { display: flex; }
    .export-loading-box {
        background: #fff;
        border-radius: 20px;
        padding: 36px 44px;
        text-align: center;
        box-shadow: 0 24px 60px rgba(0,0,0,0.25);
    }
    .export-loading-ring {
        width: 46px; height: 46px;
        margin: 0 auto 16px;
        border: 4px solid rgba(109, 94, 252, 0.15);
        border-top-color: #6d5efc;
        border-radius: 50%;
        animation: spin .8s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }
    .export-loading-box h6 { font-weight: 700; color: #1c1c28; margin-bottom: 4px; }
    .export-loading-box p { font-size: .82rem; color: #8a8a9a; margin: 0; }

    /* ===== Dark mode ===== */
    [data-bs-theme="dark"] .export-card,
    [data-bs-theme="dark"] .info-card,
    [data-bs-theme="dark"] .side-panel { background: #1c1c28; border-color: rgba(255,255,255,0.06); }
    [data-bs-theme="dark"] .type-card,
    [data-bs-theme="dark"] .format-card,
    [data-bs-theme="dark"] .side-item,
    [data-bs-theme="dark"] .column-chip,
    [data-bs-theme="dark"] .preset-chip { background: #22222f; border-color: rgba(255,255,255,0.07); }
    [data-bs-theme="dark"] .export-input { background: #22222f; border-color: rgba(255,255,255,0.08); color: #e4e4ec; }
    [data-bs-theme="dark"] .export-step-title,
    [data-bs-theme="dark"] .type-card h6,
    [data-bs-theme="dark"] .format-card h6,
    [data-bs-theme="dark"] .info-card h6,
    [data-bs-theme="dark"] .side-panel-header h6,
    [data-bs-theme="dark"] .side-item-title { color: #f0f0f5; }
    [data-bs-theme="dark"] .export-loading-box { background: #1c1c28; }

    /* ===== Responsive ===== */
    @media (max-width: 767.98px) {
        .type-grid, .format-grid { grid-template-columns: 1fr; }
        .export-hero { padding: 28px 22px; }
        .export-card { padding: 22px; }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const typeCards = document.querySelectorAll('.type-card');
    const exportTypeInput = document.getElementById('exportType');
    const taskFilters = document.querySelectorAll('.task-filter-only');
    const summaryText = document.getElementById('exportSummaryText');
    const formatInputs = document.querySelectorAll('input[name="format"]');

    const typeLabels = { tasks: 'Tasks', focus: 'Focus Sessions', summary: 'Summary Report' };
    const formatLabels = { pdf: 'PDF', excel: 'Excel', csv: 'CSV' };

    function updateSummary() {
        const type = exportTypeInput.value;
        const format = document.querySelector('input[name="format"]:checked')?.value || 'pdf';
        summaryText.innerHTML = `Exporting <strong>${typeLabels[type]}</strong> as <strong>${formatLabels[format]}</strong>`;
    }

    typeCards.forEach(card => {
        card.addEventListener('click', function () {
            typeCards.forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            exportTypeInput.value = this.dataset.type;

            // Task-only filters (status/priority/columns) only make sense for tasks export
            taskFilters.forEach(f => {
                f.style.display = this.dataset.type === 'tasks' ? '' : 'none';
            });

            updateSummary();
        });
    });

    formatInputs.forEach(input => {
        input.addEventListener('change', updateSummary);
    });

    // ===== Date Presets =====
    const presetChips = document.querySelectorAll('.preset-chip');
    const fromDateInput = document.getElementById('fromDateInput');
    const toDateInput = document.getElementById('toDateInput');

    presetChips.forEach(chip => {
        chip.addEventListener('click', function () {
            presetChips.forEach(c => c.classList.remove('active'));
            this.classList.add('active');

            const today = new Date();
            const fmt = d => d.toISOString().split('T')[0];
            let from = new Date(today), to = new Date(today);

            switch (this.dataset.range) {
                case 'today':
                    break;
                case 'week':
                    from.setDate(today.getDate() - today.getDay());
                    break;
                case 'month':
                    from = new Date(today.getFullYear(), today.getMonth(), 1);
                    break;
                case '30days':
                    from.setDate(today.getDate() - 30);
                    break;
                case 'all':
                    fromDateInput.value = '';
                    toDateInput.value = '';
                    return;
            }

            fromDateInput.value = fmt(from);
            toDateInput.value = fmt(to);
        });
    });

    // ===== Column Select All / Clear =====
    const columnCheckboxes = document.querySelectorAll('input[name="columns[]"]');

    document.getElementById('selectAllCols')?.addEventListener('click', () => {
        columnCheckboxes.forEach(cb => cb.checked = true);
    });

    document.getElementById('selectNoneCols')?.addEventListener('click', () => {
        columnCheckboxes.forEach(cb => cb.checked = false);
    });

    // ===== Saved Presets (localStorage) =====
    const PRESET_KEY = 'taskvel_export_presets';
    const presetList = document.getElementById('presetList');
    const presetEmpty = document.getElementById('presetEmpty');

    function getPresets() {
        return JSON.parse(localStorage.getItem(PRESET_KEY) || '[]');
    }

    function renderPresets() {
        const presets = getPresets();
        presetList.querySelectorAll('.side-item').forEach(el => el.remove());
        presetEmpty.style.display = presets.length ? 'none' : 'block';

        presets.forEach((preset, idx) => {
            const item = document.createElement('div');
            item.className = 'side-item';
            item.innerHTML = `
                <div class="side-item-info">
                    <span class="side-item-title">${preset.name}</span>
                    <span class="side-item-meta">${typeLabels[preset.type]} · ${formatLabels[preset.format]}</span>
                </div>
                <div class="side-item-actions">
                    <button type="button" class="side-item-btn apply-preset" data-idx="${idx}" title="Apply">
                        <i class="bi bi-arrow-return-left"></i>
                    </button>
                    <button type="button" class="side-item-btn danger delete-preset" data-idx="${idx}" title="Delete">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            `;
            presetList.appendChild(item);
        });

        presetList.querySelectorAll('.apply-preset').forEach(btn => {
            btn.addEventListener('click', function () {
                const preset = getPresets()[this.dataset.idx];
                exportTypeInput.value = preset.type;
                typeCards.forEach(c => c.classList.toggle('active', c.dataset.type === preset.type));
                const formatInput = document.querySelector(`input[name="format"][value="${preset.format}"]`);
                if (formatInput) formatInput.checked = true;
                taskFilters.forEach(f => f.style.display = preset.type === 'tasks' ? '' : 'none');
                updateSummary();
            });
        });

        presetList.querySelectorAll('.delete-preset').forEach(btn => {
            btn.addEventListener('click', function () {
                const presets = getPresets();
                presets.splice(this.dataset.idx, 1);
                localStorage.setItem(PRESET_KEY, JSON.stringify(presets));
                renderPresets();
            });
        });
    }

    document.getElementById('savePresetBtn')?.addEventListener('click', () => {
        const type = exportTypeInput.value;
        const format = document.querySelector('input[name="format"]:checked')?.value || 'pdf';
        const name = prompt('Name this preset:', `${typeLabels[type]} · ${formatLabels[format]}`);
        if (!name) return;

        const presets = getPresets();
        presets.unshift({ name, type, format });
        localStorage.setItem(PRESET_KEY, JSON.stringify(presets.slice(0, 8)));
        renderPresets();
    });

    // ===== Export History (localStorage) =====
    const HISTORY_KEY = 'taskvel_export_history';
    const historyList = document.getElementById('historyList');
    const historyEmpty = document.getElementById('historyEmpty');

    function renderHistory() {
        const history = JSON.parse(localStorage.getItem(HISTORY_KEY) || '[]');
        historyList.querySelectorAll('.side-item').forEach(el => el.remove());
        historyEmpty.style.display = history.length ? 'none' : 'block';

        history.forEach(entry => {
            const item = document.createElement('div');
            item.className = 'side-item';
            item.innerHTML = `
                <div class="side-item-info">
                    <span class="side-item-title">${typeLabels[entry.type]} · ${formatLabels[entry.format]}</span>
                    <span class="side-item-meta">${entry.time}</span>
                </div>
                <div class="side-item-actions">
                    <span class="side-item-btn"><i class="bi bi-check-lg"></i></span>
                </div>
            `;
            historyList.appendChild(item);
        });
    }

    // ===== Submit: show loading + log history =====
    document.getElementById('exportForm')?.addEventListener('submit', function () {
        const type = exportTypeInput.value;
        const format = document.querySelector('input[name="format"]:checked')?.value || 'pdf';

        const history = JSON.parse(localStorage.getItem(HISTORY_KEY) || '[]');
        history.unshift({ type, format, time: new Date().toLocaleString() });
        localStorage.setItem(HISTORY_KEY, JSON.stringify(history.slice(0, 6)));

        document.getElementById('exportLoadingOverlay').classList.add('show');
    });

    updateSummary();
    renderPresets();
    renderHistory();

});
</script>

@endsection