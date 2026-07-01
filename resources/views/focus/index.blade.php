@extends('layouts.app')

@section('title', 'Focus Mode')

@section('content')

<div class="container-fluid">

    <!-- Header -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Focus Mode
            </h2>

            <p class="text-muted">
                Eliminate distractions and work on one task at a time.
            </p>

        </div>

        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i>
            Dashboard
        </a>

    </div>

    <div class="row g-4">

        <!-- Timer -->

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-body text-center py-5">

                    <h5 class="mb-4">

                        {{ optional($task)->title ?? 'No Task Selected' }}

                    </h5>

                    <div class="timer-wrapper mx-auto">

                        <svg width="320" height="320">

                            <circle
                                cx="160"
                                cy="160"
                                r="135"
                                stroke="#e9ecef"
                                stroke-width="12"
                                fill="none"/>

                            <circle
                                id="progressRing"
                                cx="160"
                                cy="160"
                                r="135"
                                stroke="#0d6efd"
                                stroke-width="12"
                                stroke-linecap="round"
                                fill="none"
                                
                                stroke-dasharray="848"
                                stroke-dashoffset="0"
                                transform="rotate(-90 160 160)"/>

                        </svg>

                        <div class="position-absolute top-50 start-50 translate-middle">

                            <h1 id="timerDisplay"
                                class="display-2 fw-bold">

                                25:00

                            </h1>

                            <p class="text-muted">

                                Pomodoro Session

                            </p>

                        </div>

                    </div>

                    <div class="mt-5">

                        <button
                            id="startBtn"
                            class="btn btn-success btn-lg px-4">

                            <i class="bi bi-play-fill me-2"></i>

                            Start

                        </button>

                        <button
                            id="pauseBtn"
                            class="btn btn-warning btn-lg px-4 ms-2">

                            <i class="bi bi-pause-fill me-2"></i>

                            Pause

                        </button>

                        <button
                            id="resetBtn"
                            class="btn btn-danger btn-lg px-4 ms-2">

                            <i class="bi bi-stop-fill me-2"></i>

                            Reset

                        </button>

                    </div>

                </div>

            </div>

        </div>

        <!-- Sidebar -->

        <div class="col-lg-4">

            <!-- Today's Stats -->

            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        Today's Statistics

                    </h5>

                </div>

                <div class="card-body">

                    <div class="mb-3">

                        <h3 class="fw-bold text-primary">

                            {{ $todayMinutes ?? 0 }}

                        </h3>

                        <small class="text-muted">

                            Minutes Focused

                        </small>

                    </div>

                    <div class="mb-3">

                        <h3 class="fw-bold text-success">

                            {{ $todaySessions ?? 0 }}

                        </h3>

                        <small class="text-muted">

                            Completed Sessions

                        </small>

                    </div>

                </div>

            </div>

            <!-- Ambient Sounds -->

            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        Ambient Sound

                    </h5>

                </div>

                <div class="card-body">

                    <select id="ambient"
                            class="form-select">

                        <option value="">None</option>
                        <option value="rain">🌧 Rain</option>
                        <option value="forest">🌳 Forest</option>
                        <option value="coffee">☕ Coffee Shop</option>
                        <option value="waves">🌊 Ocean</option>
                        <option value="white">🎧 White Noise</option>

                    </select>

                </div>

            </div>

            <!-- Recent Sessions -->

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        Recent Sessions

                    </h5>

                </div>

                <div class="card-body">

                    @forelse($sessions as $session)

                        <div class="d-flex justify-content-between border-bottom py-2">

                            <div>

                                {{ $session->task?->title ?? 'General Focus' }}

                            </div>

                            <small class="text-muted">

                                {{ $session->duration }} min

                            </small>

                        </div>

                    @empty

                        <div class="text-center text-muted py-4">

                            No sessions yet.

                        </div>

                    @endforelse

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

@push('styles')

<style>

.timer-wrapper{

    position:relative;
    width:320px;
    height:320px;

}

#progressRing{

    transition:stroke-dashoffset .5s linear;

}

</style>

@endpush

@push('scripts')

<script>

// let duration = 1500;
// let remaining = duration;
// let timer = null;

// const display = document.getElementById('timerDisplay');
// const ring = document.getElementById('progressRing');
// const circumference = 848;   

// function updateDisplay() {

//     const min = Math.floor(remaining / 60);
//     const sec = remaining % 60;

//     display.innerHTML =
//         String(min).padStart(2, '0') +
//         ":" +
//         String(sec).padStart(2, '0');

//     const offset = circumference - (remaining / duration) * circumference;
//     ring.style.strokeDashoffset = offset;
// }

// function startTimer() {

//     if (timer !== null) {
//         return;
//     }

//     timer = setInterval(function () {

//         if (remaining > 0) {

//             remaining--;
//             updateDisplay();

//         } else {

//             clearInterval(timer);
//             timer = null;

//             Swal.fire({
//                 icon: 'success',
//                 title: 'Focus Session Complete',
//                 text: 'Great work!'
//             });

//         }

//     }, 1000);
// }

// function pauseTimer() {

//     clearInterval(timer);
//     timer = null;
// }

// function resetTimer() {

//     clearInterval(timer);
//     timer = null;

//     remaining = duration;
//     updateDisplay();
// }

// document.getElementById('startBtn').addEventListener('click', startTimer);
// document.getElementById('pauseBtn').addEventListener('click', pauseTimer);
// document.getElementById('resetBtn').addEventListener('click', resetTimer);

// updateDisplay();

</script>

@endpush