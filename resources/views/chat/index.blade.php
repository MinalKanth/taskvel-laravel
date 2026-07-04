@extends('layouts.app')

@section('title', 'Messages')

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

    .chat-wrapper {
        max-width: 720px;
        margin: 0 auto;
    }

    .chat-page {
        background: var(--chat-card);
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 1px 2px rgba(20, 20, 43, 0.04), 0 20px 48px -20px rgba(20, 20, 43, 0.12);
        border: 1px solid var(--chat-line);
    }

    /* ── Header ── */
    .chat-list-header {
        background: linear-gradient(180deg, #ffffff 0%, #fcfcff 100%);
        padding: 24px 26px 18px;
        border-bottom: 1px solid var(--chat-line);
        position: relative;
    }

    .chat-list-header::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 26px;
        right: 26px;
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--chat-line) 20%, var(--chat-line) 80%, transparent);
    }

    .chat-header-icon {
        width: 44px;
        height: 44px;
        border-radius: 13px;
        background: linear-gradient(135deg, var(--chat-accent), #818cf8);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 19px;
        box-shadow: 0 8px 20px -6px var(--chat-accent-glow);
        flex-shrink: 0;
    }

    .chat-title {
        font-weight: 800;
        font-size: 20px;
        letter-spacing: -0.3px;
        color: var(--chat-ink);
        margin-bottom: 2px;
    }

    .chat-subtitle {
        font-size: 12.5px;
        color: var(--chat-ink-faint);
        font-weight: 500;
    }

    .btn-new-chat {
        background: var(--chat-ink);
        color: #fff;
        border: none;
        padding: 10px 18px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        transition: all 0.25s cubic-bezier(.34,1.56,.64,1);
        box-shadow: 0 4px 14px -4px rgba(20, 20, 43, 0.3);
        text-decoration: none;
    }

    .btn-new-chat:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px -4px rgba(20, 20, 43, 0.4);
        color: #fff;
        background: var(--chat-ink);
    }

    .btn-new-chat i {
        font-size: 15px;
    }

    /* ── Search bar ── */
    .chat-search-wrap {
        padding: 14px 26px;
        background: var(--chat-bg);
        border-bottom: 1px solid var(--chat-line);
    }

    .chat-search {
        position: relative;
    }

    .chat-search input {
        width: 100%;
        padding: 11px 16px 11px 42px;
        border-radius: 12px;
        border: 1.5px solid var(--chat-line);
        background: #fff;
        font-size: 13.5px;
        color: var(--chat-ink);
        outline: none;
        transition: all 0.25s ease;
    }

    .chat-search input:focus {
        border-color: var(--chat-accent);
        box-shadow: 0 0 0 4px var(--chat-accent-soft);
    }

    .chat-search i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--chat-ink-faint);
        font-size: 14px;
        pointer-events: none;
    }

    /* ── List ── */
    #conversation-list {
        max-height: 620px;
        overflow-y: auto;
        scrollbar-width: thin;
    }

    #conversation-list::-webkit-scrollbar {
        width: 6px;
    }

    #conversation-list::-webkit-scrollbar-thumb {
        background: var(--chat-line);
        border-radius: 10px;
    }

    .chat-list-item {
        padding: 15px 26px;
        border-bottom: 1px solid var(--chat-line);
        transition: all 0.2s ease;
        cursor: pointer;
        background: var(--chat-card);
        display: flex;
        align-items: center;
        gap: 14px;
        position: relative;
    }

    .chat-list-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 3px;
        background: var(--chat-accent);
        opacity: 0;
        transition: opacity 0.2s ease;
    }

    .chat-list-item:hover {
        background: linear-gradient(90deg, var(--chat-accent-soft), transparent 60%);
    }

    .chat-list-item:hover::before {
        opacity: 1;
    }

    .chat-list-item:hover .chat-avatar {
        transform: scale(1.05);
    }

    /* ── Avatar ── */
    .chat-avatar {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: linear-gradient(135deg, #818cf8, var(--chat-accent));
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 16px;
        flex-shrink: 0;
        position: relative;
        transition: transform 0.25s cubic-bezier(.34,1.56,.64,1);
        box-shadow: 0 4px 12px -4px rgba(79, 70, 229, 0.4);
    }

    .chat-avatar::after {
        content: '';
        position: absolute;
        bottom: -1px;
        right: -1px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #22c55e;
        border: 2.5px solid #fff;
    }

    /* ── Content ── */
    .chat-body {
        flex: 1;
        min-width: 0;
    }

    .chat-list-title {
        font-weight: 700;
        font-size: 14.5px;
        color: var(--chat-ink);
        margin-bottom: 3px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .chat-list-sub {
        font-size: 12.5px;
        color: var(--chat-ink-soft);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 320px;
    }

    .chat-meta {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 6px;
        flex-shrink: 0;
    }

    .chat-time {
        font-size: 10.5px;
        color: var(--chat-ink-faint);
        font-weight: 500;
        letter-spacing: 0.2px;
    }

    .chat-badge {
        font-size: 10.5px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 20px;
        background: linear-gradient(135deg, var(--chat-accent), #6366f1);
        color: #fff;
        min-width: 20px;
        text-align: center;
        box-shadow: 0 3px 8px -2px var(--chat-accent-glow);
        animation: badgePop 0.3s cubic-bezier(.34,1.56,.64,1);
    }

    @keyframes badgePop {
        from { transform: scale(0.6); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    /* ── Empty state ── */
    .chat-empty {
        padding: 70px 30px;
        text-align: center;
        color: var(--chat-ink-faint);
    }

    .chat-empty-icon {
        width: 72px;
        height: 72px;
        border-radius: 20px;
        background: var(--chat-accent-soft);
        color: var(--chat-accent);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        margin: 0 auto 18px;
    }

    .chat-empty h6 {
        color: var(--chat-ink);
        font-weight: 700;
        margin-bottom: 6px;
        font-size: 15px;
    }

    .chat-empty p {
        font-size: 13px;
        margin: 0;
    }
</style>

<div class="container-fluid py-4">

    <div class="chat-wrapper">

        <div class="chat-page">

            {{-- HEADER --}}
            <div class="chat-list-header d-flex justify-content-between align-items-center">

                <div class="d-flex align-items-center gap-3">
                    <div class="chat-header-icon">
                        <i class="bi bi-chat-dots-fill"></i>
                    </div>
                    <div>
                        <div class="chat-title">Messages</div>
                        <div class="chat-subtitle">Admin &amp; Client conversations</div>
                    </div>
                </div>

                <a href="{{ route('chat.start') }}" class="btn-new-chat">
                    <i class="bi bi-plus-circle-fill"></i> New Chat
                </a>

            </div>

            {{-- SEARCH --}}
            <div class="chat-search-wrap">
                <div class="chat-search">
                    <i class="bi bi-search"></i>
                    <input type="text" id="chat-search-input" placeholder="Search conversations…" />
                </div>
            </div>

            {{-- LIST --}}
            <div id="conversation-list">

        @forelse($conversations as $conversation)

            @php
                $name = $conversation->user->name ?? 'Client';
                $initials = collect(explode(' ', trim($name)))
                    ->map(fn($w) => strtoupper(substr($w, 0, 1)))
                    ->take(2)
                    ->implode('');

                $unread = $conversation->messages()
                    ->whereNull('read_at')
                    ->where('sender_id', '!=', auth()->id())
                    ->count();

                $lastMessage = $conversation->messages->last();
            @endphp

            <a href="{{ route('chat.show', $conversation->id) }}"
               class="text-decoration-none text-dark">

                <div class="chat-list-item">

                    <div class="chat-avatar">{{ $initials ?: '?' }}</div>

                    <div class="chat-body">
                        <div class="chat-list-title">{{ $name }}</div>
                        <div class="chat-list-sub">
                            {{ optional($lastMessage)->message ?? 'No messages yet' }}
                        </div>
                    </div>

                    <div class="chat-meta">
                        @if($lastMessage)
                            <span class="chat-time">{{ $lastMessage->created_at->diffForHumans(null, true) }}</span>
                        @endif
                        @if($unread > 0)
                            <span class="chat-badge">{{ $unread }}</span>
                        @endif
                    </div>

                </div>

            </a>

        @empty

            <div class="chat-empty">
                <div class="chat-empty-icon">
                    <i class="bi bi-chat-dots"></i>
                </div>
                <h6>No conversations yet</h6>
                <p>Start a new chat to begin messaging with clients.</p>
            </div>

        @endforelse

    </div>

        </div>

    </div>

</div>

@endsection
@push('scripts')
<script>
let conversationCache = {};

function getInitials(name) {
    if (!name) return '?';
    return name.trim().split(' ')
        .map(w => w.charAt(0).toUpperCase())
        .slice(0, 2)
        .join('');
}

function renderConversation(conv) {

    const unreadBadge = conv.unread > 0
        ? `<span class="chat-badge">${conv.unread}</span>`
        : '';

    const timeBadge = conv.last_time
        ? `<span class="chat-time">${conv.last_time}</span>`
        : '';

    return `
        <a href="/chat/${conv.id}"
           class="text-decoration-none text-dark">

            <div class="chat-list-item" id="conv-${conv.id}">

                <div class="chat-avatar">${getInitials(conv.user_name)}</div>

                <div class="chat-body">
                    <div class="chat-list-title">${conv.user_name}</div>
                    <div class="chat-list-sub">${conv.last_message}</div>
                </div>

                <div class="chat-meta">
                    ${timeBadge}
                    ${unreadBadge}
                </div>

            </div>

        </a>
    `;
}

// FETCH ALL CONVERSATIONS
function fetchConversations() {

    fetch('/chat/inbox/data')
        .then(res => res.json())
        .then(data => {

            const container = document.getElementById('conversation-list');

            if (!container) return;

            container.innerHTML = '';

            if (!data.conversations.length) {
                container.innerHTML = `
                    <div class="chat-empty">
                        <div class="chat-empty-icon">
                            <i class="bi bi-chat-dots"></i>
                        </div>
                        <h6>No conversations yet</h6>
                        <p>Start a new chat to begin messaging with clients.</p>
                    </div>
                `;
                return;
            }

            data.conversations.forEach(conv => {
                container.innerHTML += renderConversation(conv);
            });

        });
}

// SIMPLE CLIENT-SIDE SEARCH FILTER
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('chat-search-input');
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            const q = searchInput.value.trim().toLowerCase();
            document.querySelectorAll('#conversation-list .chat-list-item').forEach(item => {
                const title = item.querySelector('.chat-list-title')?.textContent.toLowerCase() || '';
                const sub = item.querySelector('.chat-list-sub')?.textContent.toLowerCase() || '';
                const match = title.includes(q) || sub.includes(q);
                item.closest('a').style.display = match ? '' : 'none';
            });
        });
    }
});

// INIT
fetchConversations();

// POLL EVERY 4 SECONDS
setInterval(fetchConversations, 4000);
</script>
@endpush