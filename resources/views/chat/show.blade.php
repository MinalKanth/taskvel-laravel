@extends('layouts.app')

@section('title', 'Chat')

@section('content')

<style>
    :root {
        --chat-accent: #4f46e5;
        --chat-accent-soft: rgba(79, 70, 229, 0.08);
        --chat-accent-glow: rgba(79, 70, 229, 0.25);
        --chat-ink: #14142b;
        --chat-ink-soft: #6b7089;
        --chat-ink-faint: #9a9db3;
        --chat-line: #ecedf5;
        --chat-bg: #fbfbfd;
        --chat-card: #ffffff;
    }

    .chat-shell-wrap {
        max-width: 1100px;
        margin: 0 auto;
    }

    .chat-shell {
        height: calc(100vh - 160px);
        min-height: 560px;
        background: var(--chat-card);
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 1px 2px rgba(20, 20, 43, 0.04), 0 20px 48px -20px rgba(20, 20, 43, 0.12);
        border: 1px solid var(--chat-line);
        display: flex;
    }

    /* ───────────── SIDEBAR ───────────── */
    .chat-sidebar {
        width: 300px;
        min-width: 300px;
        background: var(--chat-bg);
        border-right: 1px solid var(--chat-line);
        display: flex;
        flex-direction: column;
    }

    .chat-sidebar-header {
        padding: 20px 18px 14px;
        border-bottom: 1px solid var(--chat-line);
        background: linear-gradient(180deg, #ffffff 0%, #fcfcff 100%);
    }

    .chat-sidebar-title {
        font-weight: 800;
        font-size: 16px;
        letter-spacing: -0.2px;
        color: var(--chat-ink);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .chat-sidebar-icon {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--chat-accent), #818cf8);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
        box-shadow: 0 6px 14px -4px var(--chat-accent-glow);
    }

    .chat-sidebar-search {
        padding: 12px 14px;
        border-bottom: 1px solid var(--chat-line);
    }

    .chat-sidebar-search input {
        width: 100%;
        padding: 9px 12px 9px 34px;
        border-radius: 10px;
        border: 1.5px solid var(--chat-line);
        background: #fff;
        font-size: 12.5px;
        color: var(--chat-ink);
        outline: none;
        transition: all .2s ease;
    }

    .chat-sidebar-search input:focus {
        border-color: var(--chat-accent);
        box-shadow: 0 0 0 4px var(--chat-accent-soft);
    }

    .chat-sidebar-search-wrap { position: relative; }

    .chat-sidebar-search-wrap i {
        position: absolute; left: 11px; top: 50%; transform: translateY(-50%);
        color: var(--chat-ink-faint); font-size: 12px; pointer-events: none;
    }

    .chat-sidebar-list {
        flex: 1;
        overflow-y: auto;
    }

    .chat-item {
        padding: 12px 16px;
        border-bottom: 1px solid var(--chat-line);
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all .2s ease;
        position: relative;
    }

    .chat-item::before {
        content: '';
        position: absolute; left: 0; top: 0; bottom: 0; width: 3px;
        background: var(--chat-accent);
        opacity: 0;
        transition: opacity .2s ease;
    }

    .chat-item:hover {
        background: linear-gradient(90deg, var(--chat-accent-soft), transparent 60%);
    }

    .chat-item.active {
        background: linear-gradient(90deg, var(--chat-accent-soft), transparent 70%);
    }

    .chat-item.active::before,
    .chat-item:hover::before {
        opacity: 1;
    }

    .chat-item-avatar {
        width: 38px;
        height: 38px;
        border-radius: 11px;
        background: linear-gradient(135deg, #818cf8, var(--chat-accent));
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 13px;
        flex-shrink: 0;
        box-shadow: 0 4px 10px -3px var(--chat-accent-glow);
    }

    .chat-item-body {
        flex: 1;
        min-width: 0;
    }

    .chat-item-name {
        font-weight: 700;
        font-size: 13.5px;
        color: var(--chat-ink);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .chat-item-sub {
        font-size: 12px;
        color: var(--chat-ink-soft);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 190px;
    }

    /* ───────────── CHAT AREA ───────────── */
    .chat-box {
        flex: 1;
        display: flex;
        flex-direction: column;
        background: var(--chat-bg);
        min-width: 0;
    }

    .chat-header {
        background: linear-gradient(180deg, #ffffff 0%, #fcfcff 100%);
        padding: 16px 22px;
        border-bottom: 1px solid var(--chat-line);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chat-header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .chat-header-avatar {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: linear-gradient(135deg, #818cf8, var(--chat-accent));
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 15px;
        position: relative;
        flex-shrink: 0;
        box-shadow: 0 4px 12px -4px var(--chat-accent-glow);
    }

    .chat-header-avatar::after {
        content: '';
        position: absolute;
        bottom: -1px; right: -1px;
        width: 11px; height: 11px;
        border-radius: 50%;
        background: #22c55e;
        border: 2px solid #fff;
    }

    .chat-header-name {
        font-weight: 800;
        font-size: 15px;
        color: var(--chat-ink);
        letter-spacing: -0.2px;
    }

    .chat-header-sub {
        font-size: 12px;
        color: var(--chat-ink-faint);
        font-weight: 500;
    }

    .chat-online-pill {
        font-size: 11px;
        font-weight: 700;
        padding: 5px 12px;
        border-radius: 20px;
        background: rgba(34, 197, 94, 0.1);
        color: #16a34a;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .chat-online-pill span {
        width: 6px; height: 6px; border-radius: 50%;
        background: #22c55e;
        box-shadow: 0 0 0 3px rgba(34,197,94,0.18);
    }

    /* ───────────── MESSAGES ───────────── */
    .messages {
        flex: 1;
        overflow-y: auto;
        padding: 22px 26px;
        scrollbar-width: thin;
    }

    .messages::-webkit-scrollbar { width: 6px; }
    .messages::-webkit-scrollbar-thumb {
        background: var(--chat-line);
        border-radius: 10px;
    }

    .msg-row {
        display: flex;
        margin-bottom: 14px;
    }

    .msg-row.me { justify-content: flex-end; }
    .msg-row.other { justify-content: flex-start; }

    .msg {
        max-width: 62%;
        padding: 11px 15px;
        border-radius: 16px;
        font-size: 13.5px;
        line-height: 1.5;
        box-shadow: 0 2px 8px -4px rgba(20,20,43,0.08);
    }

    .msg.me {
        background: linear-gradient(135deg, var(--chat-accent), #6366f1);
        color: #fff;
        border-bottom-right-radius: 5px;
    }

    .msg.other {
        background: #ffffff;
        border: 1px solid var(--chat-line);
        color: var(--chat-ink);
        border-bottom-left-radius: 5px;
    }

    .msg-sender {
        font-size: 11px;
        font-weight: 700;
        margin-bottom: 4px;
        opacity: 0.75;
    }

    .msg-time {
        text-align: right;
        margin-top: 6px;
        font-size: 10px;
        opacity: 0.65;
    }

    /* ───────────── INPUT ───────────── */
    .chat-input {
        background: #fff;
        padding: 16px 22px;
        border-top: 1px solid var(--chat-line);
    }

    .chat-input-group {
        display: flex;
        align-items: center;
        gap: 10px;
        background: var(--chat-bg);
        border: 1.5px solid var(--chat-line);
        border-radius: 100px;
        padding: 6px 6px 6px 18px;
        transition: all .2s ease;
    }

    .chat-input-group:focus-within {
        border-color: var(--chat-accent);
        box-shadow: 0 0 0 4px var(--chat-accent-soft);
        background: #fff;
    }

    .chat-input-group input {
        flex: 1;
        border: none;
        background: transparent;
        outline: none;
        font-size: 13.5px;
        color: var(--chat-ink);
        padding: 8px 0;
    }

    .chat-send-btn {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--chat-accent), #818cf8);
        color: #fff;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all .2s cubic-bezier(.34,1.56,.64,1);
        box-shadow: 0 6px 14px -4px var(--chat-accent-glow);
    }

    .chat-send-btn:hover {
        transform: scale(1.08) translateX(1px);
    }

    .chat-empty-side {
        padding: 50px 20px;
        text-align: center;
        color: var(--chat-ink-faint);
        font-size: 13px;
    }

    @media (max-width: 768px) {
        .chat-sidebar { display: none; }
        .chat-shell { height: calc(100vh - 120px); }
    }
</style>

<div class="container-fluid py-4">

    <div class="chat-shell-wrap">

        <div class="chat-shell">

            {{-- ───────────────────────── LEFT SIDEBAR ───────────────────────── --}}
            <div class="chat-sidebar">

                <div class="chat-sidebar-header">
                    <div class="chat-sidebar-title">
                        <div class="chat-sidebar-icon"><i class="bi bi-chat-dots-fill"></i></div>
                        Messages
                    </div>
                </div>

                <div class="chat-sidebar-search">
                    <div class="chat-sidebar-search-wrap">
                        <i class="bi bi-search"></i>
                        <input type="text" id="sidebar-search" placeholder="Search conversations…" />
                    </div>
                </div>

                <div class="chat-sidebar-list" id="sidebar-list">

                    @if(!empty($conversations) && count($conversations))

                        @foreach($conversations as $conv)

                            @php
                                $convName = $conv->user->name ?? 'Client';
                                $convInitials = collect(explode(' ', trim($convName)))
                                    ->map(fn($w) => strtoupper(substr($w, 0, 1)))
                                    ->take(2)
                                    ->implode('');
                                $isActive = isset($conversation) && $conversation?->id == $conv->id;
                            @endphp

                            <a href="{{ $conv?->id ? route('chat.show', $conv->id) : '#' }}"
                               class="text-decoration-none">

                                <div class="chat-item {{ $isActive ? 'active' : '' }}">

                                    <div class="chat-item-avatar">{{ $convInitials ?: '?' }}</div>

                                    <div class="chat-item-body">
                                        <div class="chat-item-name">{{ $convName }}</div>
                                        <div class="chat-item-sub">
                                            {{ \Illuminate\Support\Str::limit(optional($conv->messages->last())->message ?? 'No messages yet', 34) }}
                                        </div>
                                    </div>

                                </div>

                            </a>

                        @endforeach

                    @else

                        <div class="chat-empty-side">
                            No conversations found
                        </div>

                    @endif

                </div>

            </div>

            {{-- ───────────────────────── CHAT AREA ───────────────────────── --}}
            <div class="chat-box">

                @php
                    $headName = $conversation->user->name ?? 'Chat';
                    $headInitials = collect(explode(' ', trim($headName)))
                        ->map(fn($w) => strtoupper(substr($w, 0, 1)))
                        ->take(2)
                        ->implode('');
                @endphp

                {{-- HEADER --}}
                <div class="chat-header">

                    <div class="chat-header-left">
                        <div class="chat-header-avatar">{{ $headInitials ?: '?' }}</div>
                        <div>
                            <div class="chat-header-name">{{ $headName }}</div>
                            <div class="chat-header-sub">Client Communication</div>
                        </div>
                    </div>

                    <div class="chat-online-pill">
                        <span></span> Online
                    </div>

                </div>

                {{-- MESSAGES --}}
                <div class="messages" id="chat-box">

                    @foreach($conversation->messages as $msg)

                        @php $isMe = $msg->sender_id == auth()->id(); @endphp

                        <div class="msg-row {{ $isMe ? 'me' : 'other' }}">
                            <div class="msg {{ $isMe ? 'me' : 'other' }}">

                                @unless($isMe)
                                    <div class="msg-sender">{{ $msg->sender->name }}</div>
                                @endunless

                                {{ $msg->message }}

                                <div class="msg-time">
                                    {{ $msg->created_at->format('h:i A') }}
                                </div>

                            </div>
                        </div>

                    @endforeach

                </div>

                {{-- INPUT --}}
                <div class="chat-input">

                    <form id="chat-form">
                        @csrf

                        <div class="chat-input-group">

                            <input type="text"
                                   id="message"
                                   placeholder="Type a message...">

                            <button type="submit" class="chat-send-btn">
                                <i class="bi bi-send-fill" style="font-size:14px;"></i>
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>
const conversationId = {{ $conversation->id }};
const userId = {{ auth()->id() }};
let lastMessageId = 0;

// scroll helper
function scrollChat() {
    const box = document.getElementById('chat-box');
    box.scrollTop = box.scrollHeight;
}

// render single message
function appendMessage(msg) {

    const box = document.getElementById('chat-box');
    const isMe = msg.sender_id == userId;

    const senderLine = !isMe
        ? `<div class="msg-sender">${msg.sender_name}</div>`
        : '';

    const html = `
        <div class="msg-row ${isMe ? 'me' : 'other'}" id="msg-${msg.id}">
            <div class="msg ${isMe ? 'me' : 'other'}">
                ${senderLine}
                ${msg.message}
                <div class="msg-time">${msg.time}</div>
            </div>
        </div>
    `;

    box.insertAdjacentHTML('beforeend', html);
}

// fetch new messages only
function fetchMessages() {

    fetch(`/chat/${conversationId}/messages?last_id=${lastMessageId}`)
        .then(res => res.json())
        .then(data => {

            if (!data.messages || data.messages.length === 0) return;

            data.messages.forEach(msg => {

                if (document.getElementById(`msg-${msg.id}`)) return;

                appendMessage(msg);
                lastMessageId = msg.id;
            });

            scrollChat();
        });
}

// initial load
function initChat() {
    fetch(`/chat/${conversationId}/messages`)
        .then(res => res.json())
        .then(data => {

            const box = document.getElementById('chat-box');
            box.innerHTML = '';

            data.messages.forEach(msg => {
                appendMessage(msg);
                lastMessageId = msg.id;
            });

            scrollChat();
        });
}

// SEND MESSAGE
document.getElementById('chat-form').addEventListener('submit', function(e){
    e.preventDefault();

    const input = document.getElementById('message');
    const message = input.value.trim();

    if (!message) return;

    fetch(`/chat/${conversationId}/send`, {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ message })
    })
    .then(() => {
        input.value = '';
        fetchMessages();
    });
});

// SIDEBAR SEARCH FILTER
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('sidebar-search');
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            const q = searchInput.value.trim().toLowerCase();
            document.querySelectorAll('#sidebar-list .chat-item').forEach(item => {
                const name = item.querySelector('.chat-item-name')?.textContent.toLowerCase() || '';
                const sub = item.querySelector('.chat-item-sub')?.textContent.toLowerCase() || '';
                const match = name.includes(q) || sub.includes(q);
                item.closest('a').style.display = match ? '' : 'none';
            });
        });
    }
});

// start system
initChat();

// poll every 3 seconds
setInterval(fetchMessages, 3000);
</script>
@endpush