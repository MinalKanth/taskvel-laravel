@extends('layouts.app')

@section('title', 'Export Data')

@section('content')

<div class="container">

    <div class="row justify-content-center">

        <div class="col-lg-10">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h2 class="fw-bold mb-1">
                        Export Tasks
                    </h2>

                    <p class="text-muted mb-0">
                        Download your tasks in PDF, Excel, or CSV format.
                    </p>

                </div>

                <a href="{{ route('dashboard') }}"
                   class="btn btn-outline-secondary">

                    <i class="bi bi-arrow-left me-2"></i>

                    Dashboard

                </a>

            </div>

            <div class="card border-0 shadow-sm">

                <div class="card-body p-4">

                    <form method="POST"
                          action="{{ route('export.download') }}">

                        @csrf

                        <input type="hidden" name="type" value="tasks">
                        
                        <div class="row g-3">

                            <div class="col-md-6">

                                <label class="form-label fw-semibold">

                                    From Date

                                </label>

                                <input
                                    type="date"
                                    name="from_date"
                                    value="{{ old('from_date') }}"
                                    class="form-control">

                            </div>

                            <div class="col-md-6">

                                <label class="form-label fw-semibold">

                                    To Date

                                </label>

                                <input
                                    type="date"
                                    name="to_date"
                                    value="{{ old('to_date') }}"
                                    class="form-control">

                            </div>

                            <div class="col-md-6">

                                <label class="form-label fw-semibold">

                                    Status

                                </label>

                                <select
                                    name="status"
                                    class="form-select">

                                    <option value="">
                                        All Status
                                    </option>

                                    <option value="pending">
                                        Pending
                                    </option>

                                    <option value="in_progress">
                                        In Progress
                                    </option>

                                    <option value="completed">
                                        Completed
                                    </option>

                                </select>

                            </div>

                            <div class="col-md-6">

                                <label class="form-label fw-semibold">

                                    Priority

                                </label>

                                <select
                                    name="priority"
                                    class="form-select">

                                    <option value="">
                                        All Priorities
                                    </option>

                                    <option value="low">
                                        Low
                                    </option>

                                    <option value="medium">
                                        Medium
                                    </option>

                                    <option value="high">
                                        High
                                    </option>

                                </select>

                            </div>

                            <div class="col-md-12">

                                <label class="form-label fw-semibold">

                                    Export Format

                                </label>

                                <div class="d-flex flex-wrap gap-3 mt-2">

                                    <div class="form-check">

                                        <input
                                            class="form-check-input"
                                            type="radio"
                                            name="format"
                                            value="pdf"
                                            checked>

                                        <label class="form-check-label">

                                            PDF

                                        </label>

                                    </div>

                                    <div class="form-check">

                                        <input
                                            class="form-check-input"
                                            type="radio"
                                            name="format"
                                            value="excel">

                                        <label class="form-check-label">

                                            Excel

                                        </label>

                                    </div>

                                    <div class="form-check">

                                        <input
                                            class="form-check-input"
                                            type="radio"
                                            name="format"
                                            value="csv">

                                        <label class="form-check-label">

                                            CSV

                                        </label>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <hr class="my-4">

                        <div class="text-end">

                            <button
                                type="submit"
                                class="btn btn-primary btn-lg">

                                <i class="bi bi-download me-2"></i>

                                Export Data

                            </button>

                        </div>

                    </form>

                </div>

            </div>

            <div class="row mt-4">

                <div class="col-md-4">

                    <div class="card border-0 shadow-sm text-center">

                        <div class="card-body">

                            <i class="bi bi-file-earmark-pdf display-4 text-danger"></i>

                            <h5 class="mt-3">

                                PDF Export

                            </h5>

                            <p class="text-muted mb-0">

                                Printable report with charts and summaries.

                            </p>

                        </div>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="card border-0 shadow-sm text-center">

                        <div class="card-body">

                            <i class="bi bi-file-earmark-excel display-4 text-success"></i>

                            <h5 class="mt-3">

                                Excel Export

                            </h5>

                            <p class="text-muted mb-0">

                                Spreadsheet for further analysis.

                            </p>

                        </div>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="card border-0 shadow-sm text-center">

                        <div class="card-body">

                            <i class="bi bi-filetype-csv display-4 text-primary"></i>

                            <h5 class="mt-3">

                                CSV Export

                            </h5>

                            <p class="text-muted mb-0">

                                Lightweight format for data migration.

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
