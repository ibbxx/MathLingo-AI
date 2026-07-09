<x-app-layout>

@section('page-title', 'Notifikasi')

<style>
.notif-page { max-width: 720px; margin: 0 auto; }
.notif-page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; }
.notif-page-title { font-size:20px; font-weight:800; color:var(--color-text); margin:0; }
.notif-mark-all-btn { border:none; background:none; font-size:13px; font-weight:600; color:var(--color-primary); cursor:pointer; font-family:inherit; }

.notif-card-list { display:flex; flex-direction:column; gap:10px; }
.notif-card {
    display:flex; gap:14px; padding:16px 18px; background:var(--color-surface);
    border:1px solid var(--color-border); border-radius:14px; text-decoration:none;
    transition: border-color .15s, box-shadow .15s;
}
.notif-card:hover { border-color:var(--color-primary); box-shadow:0 4px 14px rgba(37,99,235,0.08); }
.notif-card.unread { background:var(--color-primary-10); border-color:var(--color-primary-20); }
.notif-icon {
    width:40px; height:40px; border-radius:10px; flex-shrink:0;
    display:flex; align-items:center; justify-content:center; font-size:18px;
}
.notif-body { flex:1; min-width:0; }
.notif-title { font-size:14px; font-weight:700; color:var(--color-text); margin-bottom:2px; }
.notif-message { font-size:13px; color:var(--color-muted); line-height:1.5; }
.notif-time { font-size:11.5px; color:var(--color-muted); margin-top:6px; }

.notif-empty { text-align:center; padding:60px 20px; color:var(--color-muted); }
.notif-empty svg { margin-bottom:12px; opacity:.5; }

.notif-pagination { margin-top:20px; }
</style>

<div class="notif-page">
    <div class="notif-page-header">
        <h1 class="notif-page-title">Notifikasi</h1>
        @if($notifications->where('read_at', null)->isNotEmpty())
        <button class="notif-mark-all-btn" id="page-mark-all">Tandai semua dibaca</button>
        @endif
    </div>

    @if($notifications->isEmpty())
    <div class="notif-empty">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
            <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
        </svg>
        <p>Belum ada notifikasi.</p>
    </div>
    @else
    <div class="notif-card-list">
        @foreach($notifications as $notification)
        @php
            $data = $notification->data;
            $isUnread = is_null($notification->read_at);
        @endphp
        <a href="{{ $data['url'] ?? '#' }}"
           class="notif-card {{ $isUnread ? 'unread' : '' }}"
           data-id="{{ $notification->id }}"
           onclick="fetch('{{ route('notifications.read', $notification->id) }}', {method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}})">
            <div class="notif-icon" style="background:{{ $data['color'] ?? '#2563EB' }}20;color:{{ $data['color'] ?? '#2563EB' }};">
                @switch($data['icon'] ?? 'bell')
                    @case('book')
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                        @break
                    @case('achievement')
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
                        @break
                    @case('megaphone')
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 11l18-5v12L3 13v-2z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/></svg>
                        @break
                    @default
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                @endswitch
            </div>
            <div class="notif-body">
                <div class="notif-title">{{ $data['title'] ?? 'Notifikasi' }}</div>
                <div class="notif-message">{{ $data['message'] ?? '' }}</div>
                <div class="notif-time">{{ $notification->created_at->diffForHumans() }}</div>
            </div>
        </a>
        @endforeach
    </div>

    <div class="notif-pagination">
        {{ $notifications->links() }}
    </div>
    @endif
</div>

<script>
document.getElementById('page-mark-all')?.addEventListener('click', function () {
    fetch("{{ route('notifications.read-all') }}", {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
    }).then(() => window.location.reload());
});
</script>

</x-app-layout>
