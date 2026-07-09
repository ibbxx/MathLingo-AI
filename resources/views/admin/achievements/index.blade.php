<x-admin-layout title="Pencapaian">
<style>
.admin-page { padding: 28px 28px 0; }
.admin-page-header { margin-bottom: 24px; }
.admin-page-title { font-size: 22px; font-weight: 800; color: var(--color-text); margin: 0 0 4px; letter-spacing: -0.4px; }
.admin-page-sub { font-size: 13.5px; color: var(--color-muted); margin: 0; }
.placeholder-panel {
    background: var(--color-surface); border: 1px solid var(--color-border);
    border-radius: var(--radius-card); box-shadow: var(--shadow-card);
    padding: 64px 32px; text-align: center; margin-bottom: 28px;
}
.placeholder-panel-icon {
    width: 72px; height: 72px; border-radius: 20px;
    background: var(--color-primary-10); display: flex; align-items: center; justify-content: center;
    margin: 0 auto 20px; color: var(--color-primary);
}
.placeholder-panel-title { font-size: 18px; font-weight: 700; color: var(--color-text); margin: 0 0 8px; }
.placeholder-panel-desc { font-size: 14px; color: var(--color-muted); margin: 0 0 24px; max-width: 420px; margin-left: auto; margin-right: auto; line-height: 1.6; }
.placeholder-panel-badge {
    display: inline-flex; align-items: center; gap: 6px;
    background: var(--color-primary-10); color: var(--color-primary);
    font-size: 12px; font-weight: 600; padding: 6px 14px; border-radius: 8px;
}
</style>
<div class="admin-page">
    <div class="admin-page-header">
        <h1 class="admin-page-title">Pencapaian</h1>
        <p class="admin-page-sub">Kelola lencana dan pencapaian yang dapat diraih pengguna.</p>
    </div>
    <div class="placeholder-panel">
        <div class="placeholder-panel-icon">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="18" height="18" rx="3"/>
                <path d="M9 12h6M12 9v6"/>
            </svg>
        </div>
        <h2 class="placeholder-panel-title">Modul Sedang Dikembangkan</h2>
        <p class="placeholder-panel-desc">
            Modul <strong>Pencapaian</strong> akan dikembangkan pada Phase berikutnya.
            Navigasi dan struktur halaman ini sudah siap &mdash; tinggal mengisi konten modul.
        </p>
        <span class="placeholder-panel-badge">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
            </svg>
            Akan hadir di Phase selanjutnya
        </span>
    </div>
</div>
</x-admin-layout>