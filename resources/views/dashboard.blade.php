@extends('layouts.app')

@section('title', 'Dashboard - Sistem Manajemen Aset')

@push('styles')
<style>

    .dash-head {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .dash-head h1 {
        font-size: 23px;
        font-weight: 700;
        margin: 0 0 4px;
        letter-spacing: -.2px;
        color: var(--text);
    }

    .dash-head p {
        margin: 0;
        color: var(--text-secondary);
        font-size: 13.5px;
    }

    .date-chip {
        display: flex;
        align-items: center;
        gap: 7px;
        background: #ffffff;
        border: 1px solid var(--border-blue);
        border-radius: 10px;
        padding: 8px 13px;
        font-size: 12.5px;
        color: var(--text-secondary);
        font-weight: 500;
        box-shadow: var(--shadow-hover);
    }

    .metric-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 16px;
    }

    /* Card Stat: Border biru & shadow permanen */
    .metric-card {
        background: #ffffff;
        border: 1px solid var(--border-blue);
        border-radius: 16px;
        padding: 16px 18px 15px;
        box-shadow: var(--shadow-hover);
    }

    .metric-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .metric-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: var(--primary-light);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
    }

    .metric-trend {
        font-size: 11px;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 20px;
        background: var(--primary-light);
        color: var(--primary);
    }

    .metric-trend.warn {
        background: #fef3c7;
        color: #d97706;
    }

    .metric-num {
        font-family: "Sora", sans-serif;
        font-size: 25px;
        font-weight: 700;
        letter-spacing: -.3px;
        color: var(--text);
    }

    .metric-label {
        font-size: 12.5px;
        color: var(--text-secondary);
        margin-top: 2px;
        font-weight: 500;
    }

    /* Panel Grafik & Tabel: Border biru & shadow permanen */
    .panel {
        background: #ffffff;
        border: 1px solid var(--border-blue);
        border-radius: 16px;
        padding: 18px 20px 20px;
        box-shadow: var(--shadow-hover);
    }

    .panel-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .panel-head h3 {
        font-size: 14.5px;
        font-weight: 600;
        margin: 0;
        color: var(--text);
    }

    .panel-head p {
        font-size: 11.5px;
        color: var(--text-secondary);
        margin: 2px 0 0;
    }

    .row-2 {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 14px;
        margin-bottom: 14px;
    }

    .row-3 {
        display: grid;
        grid-template-columns: 1fr 1.4fr;
        gap: 14px;
    }

    .bars {
        display: flex;
        align-items: flex-end;
        gap: 14px;
        height: 170px;
        padding-top: 24px;
    }

    .bar-col {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        height: 100%;
        justify-content: flex-end;
    }

    .bar-shell {
        width: 100%;
        max-width: 34px;
        height: 120px;
        display: flex;
        align-items: flex-end;
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 7px;
        overflow: hidden;
    }

    .bar-fill {
        width: 100%;
        border-radius: 7px 7px 0 0;
        background: linear-gradient(180deg, #3b82f6, #2563eb);
        transition: height 1s cubic-bezier(.2, .7, .2, 1);
    }

    .bar-val {
        font-size: 11px;
        font-weight: 700;
        font-family: "IBM Plex Mono", monospace;
        color: var(--text);
    }

    .bar-name {
        font-size: 11px;
        color: var(--text-secondary);
        text-align: center;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 60px;
    }

    .donut-wrap {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 16px;
    }

    .donut {
        position: relative;
        width: 140px;
        height: 140px;
    }

    .donut svg {
        transform: rotate(-90deg);
    }

    .donut-center {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .donut-center .big {
        font-family: "Sora", sans-serif;
        font-size: 22px;
        font-weight: 700;
        color: var(--text);
    }

    .donut-center .small {
        font-size: 10.5px;
        color: var(--text-secondary);
    }

    .legend {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .legend-row {
        display: flex;
        align-items: center;
        gap: 9px;
        font-size: 12px;
    }

    .legend-dot {
        width: 9px;
        height: 9px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .legend-row .lname {
        color: var(--text-secondary);
        flex: 1;
    }

    .legend-row .lval {
        font-weight: 700;
        font-family: "IBM Plex Mono", monospace;
        font-size: 11.5px;
        color: var(--text);
    }

    .stock-item {
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 10px 12px;
        border-radius: 0 10px 10px 0;
        margin-bottom: 8px;
    }

    .stock-item:last-child {
        margin-bottom: 0;
    }

    .stock-item.urgent {
        background: #fef2f2;
        border-left: 3px solid var(--danger);
    }

    .stock-item.warn {
        background: #f8fafc;
        border-left: 3px dashed var(--text-light);
    }

    .stock-icon {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        background: #ffffff;
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 13px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .stock-info {
        flex: 1;
        min-width: 0;
    }

    .stock-info .sname {
        font-size: 12.5px;
        font-weight: 600;
        color: var(--text);
    }

    .stock-info .smeta {
        font-size: 11px;
        color: var(--text-secondary);
    }

    .stock-qty {
        font-family: "IBM Plex Mono", monospace;
        font-size: 12px;
        font-weight: 700;
        text-align: right;
        color: var(--text);
    }

    .stock-qty .min {
        display: block;
        font-size: 10px;
        color: var(--text-light);
        font-weight: 500;
    }

    table.activity {
        width: 100%;
        border-collapse: collapse;
    }

    table.activity th {
        text-align: left;
        font-size: 10.5px;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: var(--text-secondary);
        font-weight: 600;
        padding: 0 8px 9px;
        border-bottom: 1px solid var(--border);
    }

    table.activity td {
        padding: 11px 8px;
        font-size: 12.5px;
        border-bottom: 1px solid var(--border);
        color: var(--text);
    }

    table.activity tr:last-child td {
        border-bottom: none;
    }

    .act-time {
        color: var(--text-light);
        font-family: "IBM Plex Mono", monospace;
        font-size: 11px;
        white-space: nowrap;
    }

    .act-who {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 11.5px;
        color: var(--text-secondary);
        font-weight: 500;
    }

    .who-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--primary);
    }

    .who-dot.sys {
        background: var(--text-light);
    }

    .act-tag {
        display: inline-flex;
        font-size: 10px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 20px;
        margin-left: 7px;
    }

    .act-tag.add {
        background: var(--primary-light);
        color: var(--primary);
    }

    .act-tag.edit {
        background: #f1f5f9;
        color: var(--text-secondary);
    }

    .act-tag.del {
        background: #fef2f2;
        color: var(--danger);
        border: 1px solid #fecaca;
    }

    @media (max-width: 1080px) {
        .row-2, .row-3 { grid-template-columns: 1fr; }
        .metric-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 520px) {
        .metric-grid { grid-template-columns: 1fr; }
    }

</style>
@endpush

@section('content')

<div class="dash-head">
    <div>
        <h1>Selamat datang kembali, {{ auth()->user()->name ?? 'Administrator' }}</h1>
        <p>Berikut ringkasan kondisi aset dan aktivitas terbaru hari ini.</p>
    </div>
    <div class="date-chip">
        <i class="fa-regular fa-calendar"></i>
        {{ now()->translatedFormat('l, d F Y') }}
    </div>
</div>

<div class="metric-grid">

    <div class="metric-card">
        <div class="metric-top">
            <div class="metric-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
            <div class="metric-trend"><i class="fa-solid fa-arrow-trend-up"></i> Live</div>
        </div>
        <div class="metric-num">{{ number_format($totalAset ?? 0) }}</div>
        <div class="metric-label">Total aset terdaftar</div>
    </div>

    <div class="metric-card">
        <div class="metric-top">
            <div class="metric-icon"><i class="fa-solid fa-tags"></i></div>
            <div class="metric-trend">Aktif</div>
        </div>
        <div class="metric-num">{{ number_format($totalKategori ?? 0) }}</div>
        <div class="metric-label">Kategori aktif</div>
    </div>

    <div class="metric-card">
        <div class="metric-top">
            <div class="metric-icon"><i class="fa-solid fa-building"></i></div>
            <div class="metric-trend">Terdata</div>
        </div>
        <div class="metric-num">{{ number_format($totalRuangan ?? 0) }}</div>
        <div class="metric-label">Ruangan terdaftar</div>
    </div>

    <div class="metric-card">
        <div class="metric-top">
            <div class="metric-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
            <div class="metric-trend warn"><i class="fa-solid fa-circle-exclamation"></i> Perlu aksi</div>
        </div>
        <div class="metric-num">{{ number_format($stokMenipis ?? 0) }}</div>
        <div class="metric-label">Item stok menipis</div>
    </div>

</div>

<div class="row-2">

    <div class="panel">
        <div class="panel-head">
            <div>
                <h3>Aset per kategori</h3>
                <p>Distribusi jumlah unit aset pada tiap kategori</p>
            </div>
        </div>
        <div class="bars">
            @forelse($kategoriStats ?? [] as $cat)
                @php
                    $maxCount = isset($kategoriStats) && count($kategoriStats) > 0 ? $kategoriStats->max('total') : 1;
                    $percent = $maxCount > 0 ? max(round(($cat->total / $maxCount) * 100), 15) : 15;
                @endphp
                <div class="bar-col">
                    <span class="bar-val">{{ $cat->total }}</span>
                    <div class="bar-shell">
                        <div class="bar-fill" style="height:{{ $percent }}%"></div>
                    </div>
                    <span class="bar-name" title="{{ $cat->nama_kategori }}">{{ $cat->nama_kategori }}</span>
                </div>
            @empty
                <div style="width:100%; text-align:center; color: var(--text-light); font-size:12px; margin: auto 0;">
                    Belum ada data kategori.
                </div>
            @endforelse
        </div>
    </div>

    <div class="panel">
        <div class="panel-head">
            <div>
                <h3>Kondisi aset</h3>
                <p>Status keseluruhan aset</p>
            </div>
        </div>
        @php
            $persenBaik = $kondisiAset['baik'] ?? 0;
            $persenPerlu = $kondisiAset['perlu_perbaikan'] ?? 0;
            $persenRusak = $kondisiAset['rusak'] ?? 0;

            $circumference = 2 * M_PI * 60; // ~377, keliling lingkaran r=60

            $lenBaik = round(($persenBaik / 100) * $circumference, 1);
            $lenPerlu = round(($persenPerlu / 100) * $circumference, 1);
            $lenRusak = round(($persenRusak / 100) * $circumference, 1);

            $offsetPerlu = -$lenBaik;
            $offsetRusak = -($lenBaik + $lenPerlu);
        @endphp
        <div class="donut-wrap">
            <div class="donut">
                <svg width="140" height="140" viewBox="0 0 150 150">
                    <circle cx="75" cy="75" r="60" fill="none" stroke="#f1f5f9" stroke-width="16"/>
                    <circle cx="75" cy="75" r="60" fill="none" stroke="#2563eb" stroke-width="16" stroke-linecap="round" stroke-dasharray="{{ $lenBaik }} {{ $circumference }}" stroke-dashoffset="0"/>
                    <circle cx="75" cy="75" r="60" fill="none" stroke="#f59e0b" stroke-width="16" stroke-linecap="round" stroke-dasharray="{{ $lenPerlu }} {{ $circumference }}" stroke-dashoffset="{{ $offsetPerlu }}"/>
                    <circle cx="75" cy="75" r="60" fill="none" stroke="#ef4444" stroke-width="16" stroke-linecap="round" stroke-dasharray="{{ $lenRusak }} {{ $circumference }}" stroke-dashoffset="{{ $offsetRusak }}"/>
                </svg>
                <div class="donut-center"><span class="big">{{ $persenBaik }}%</span><span class="small">kondisi baik</span></div>
            </div>
            <div class="legend">
                <div class="legend-row"><span class="legend-dot" style="background:#2563eb"></span><span class="lname">Baik</span><span class="lval">{{ $persenBaik }}%</span></div>
                <div class="legend-row"><span class="legend-dot" style="background:#f59e0b"></span><span class="lname">Perlu perbaikan</span><span class="lval">{{ $persenPerlu }}%</span></div>
                <div class="legend-row"><span class="legend-dot" style="background:#ef4444"></span><span class="lname">Rusak</span><span class="lval">{{ $persenRusak }}%</span></div>
            </div>
        </div>
    </div>

</div>

<div class="row-3">

    <div class="panel">
        <div class="panel-head">
            <div>
                <h3>Stok menipis</h3>
                <p>Item di bawah ambang batas minimum</p>
            </div>
        </div>

        @forelse($listStokMenipis ?? [] as $stok)
            <div class="stock-item {{ $stok->jumlah <= 3 ? 'urgent' : 'warn' }}">
                <div class="stock-icon"><i class="fa-solid fa-box-open"></i></div>
                <div class="stock-info">
                    <div class="sname">{{ $stok->barang->nama_barang ?? $stok->nama_item ?? 'Barang Tanpa Nama' }}</div>
                    <div class="smeta">{{ $stok->ruangan->nama_ruangan ?? 'Gudang Utama' }}</div>
                </div>
                <div class="stock-qty">{{ $stok->jumlah }}<span class="min">min. {{ $stok->min_stok ?? 10 }}</span></div>
            </div>
        @empty
            <p style="font-size: 12.5px; color: var(--text-secondary); text-align: center; margin-top: 20px;">
                Semua stok barang dalam kondisi aman.
            </p>
        @endforelse
    </div>

    <div class="panel">
        <div class="panel-head">
            <div>
                <h3>Aktivitas terbaru</h3>
                <p>Riwayat penambahan data pada sistem</p>
            </div>
        </div>
        <table class="activity">
            <thead>
                <tr><th>Waktu</th><th>Aktivitas</th><th>Kategori</th></tr>
            </thead>
            <tbody>
                @forelse($barangTerbaru ?? [] as $barang)
                    <tr>
                        <td class="act-time">{{ $barang->created_at ? $barang->created_at->format('H:i') : '-' }}</td>
                        <td>
                            Menambahkan aset "{{ $barang->nama_barang }}"
                            <span class="act-tag add">Tambah</span>
                        </td>
                        <td>
                            <span class="act-who">
                                <span class="who-dot"></span>
                                {{ $barang->kategori->nama_kategori ?? 'Umum' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center; color: var(--text-secondary);">Belum ada aktivitas terbaru.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection