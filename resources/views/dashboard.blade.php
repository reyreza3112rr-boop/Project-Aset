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
    }

    .dash-head p {
        margin: 0;
        color: var(--text-muted);
        font-size: 13.5px;
    }

    .date-chip {
        display: flex;
        align-items: center;
        gap: 7px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 8px 13px;
        font-size: 12.5px;
        color: var(--text-muted);
        font-weight: 500;
    }

    .metric-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 16px;
    }

    .metric-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 16px 18px 15px;
        box-shadow: 0 1px 2px rgba(16,20,42,.04), 0 8px 20px -14px rgba(16,20,42,.14);
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
        background: var(--mono-tint);
        color: var(--mono-strong);
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
        background: var(--mono-tint);
        color: var(--mono-strong);
    }

    .metric-trend.warn {
        background: var(--mono-strong);
        color: #fff;
    }

    .metric-num {
        font-family: "Sora", sans-serif;
        font-size: 25px;
        font-weight: 700;
        letter-spacing: -.3px;
    }

    .metric-label {
        font-size: 12.5px;
        color: var(--text-muted);
        margin-top: 2px;
        font-weight: 500;
    }

    .panel {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 18px 20px 20px;
        box-shadow: 0 1px 2px rgba(16,20,42,.04), 0 8px 20px -14px rgba(16,20,42,.14);
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
    }

    .panel-head p {
        font-size: 11.5px;
        color: var(--text-muted);
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
        padding-top: 4px;
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
        height: 100%;
        display: flex;
        align-items: flex-end;
        background: #f7f7f8;
        border-radius: 7px;
        overflow: hidden;
    }

    .bar-fill {
        width: 100%;
        border-radius: 7px 7px 0 0;
        background: linear-gradient(180deg, #4a4b52, var(--mono-strong));
        transition: height 1s cubic-bezier(.2, .7, .2, 1);
    }

    .bar-val {
        font-size: 11px;
        font-weight: 700;
        font-family: "IBM Plex Mono", monospace;
    }

    .bar-name {
        font-size: 11px;
        color: var(--text-muted);
        text-align: center;
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
    }

    .donut-center .small {
        font-size: 10.5px;
        color: var(--text-muted);
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
        color: var(--text-muted);
        flex: 1;
    }

    .legend-row .lval {
        font-weight: 700;
        font-family: "IBM Plex Mono", monospace;
        font-size: 11.5px;
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
        background: #f0f0f1;
        border-left: 3px solid var(--mono-strong);
    }

    .stock-item.warn {
        background: #f7f7f8;
        border-left: 3px dashed #b5b6be;
    }

    .stock-icon {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        background: rgba(255, 255, 255, .7);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 13px;
    }

    .stock-info {
        flex: 1;
        min-width: 0;
    }

    .stock-info .sname {
        font-size: 12.5px;
        font-weight: 600;
    }

    .stock-info .smeta {
        font-size: 11px;
        color: var(--text-muted);
    }

    .stock-qty {
        font-family: "IBM Plex Mono", monospace;
        font-size: 12px;
        font-weight: 700;
        text-align: right;
    }

    .stock-qty .min {
        display: block;
        font-size: 10px;
        color: var(--text-faint);
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
        color: var(--text-faint);
        font-weight: 600;
        padding: 0 8px 9px;
        border-bottom: 1px solid var(--border);
    }

    table.activity td {
        padding: 11px 8px;
        font-size: 12.5px;
        border-bottom: 1px solid var(--border);
    }

    table.activity tr:last-child td {
        border-bottom: none;
    }

    .act-time {
        color: var(--text-faint);
        font-family: "IBM Plex Mono", monospace;
        font-size: 11px;
        white-space: nowrap;
    }

    .act-who {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 11.5px;
        color: var(--text-muted);
        font-weight: 500;
    }

    .who-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--mono-strong);
    }

    .who-dot.sys {
        background: var(--text-faint);
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
        background: var(--mono-strong);
        color: #fff;
    }

    .act-tag.edit {
        background: var(--mono-tint);
        color: var(--mono-strong);
    }

    .act-tag.del {
        background: #fff;
        color: var(--mono-strong);
        border: 1px solid var(--mono-strong);
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
        <h1>Selamat datang kembali, Administrator</h1>
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
            <div class="metric-trend"><i class="fa-solid fa-arrow-trend-up"></i> 4.2%</div>
        </div>
        <div class="metric-num">{{ $totalAset ?? '1.284' }}</div>
        <div class="metric-label">Total aset terdaftar</div>
    </div>

    <div class="metric-card">
        <div class="metric-top">
            <div class="metric-icon"><i class="fa-solid fa-tags"></i></div>
            <div class="metric-trend">2 baru</div>
        </div>
        <div class="metric-num">{{ $totalKategori ?? '12' }}</div>
        <div class="metric-label">Kategori aktif</div>
    </div>

    <div class="metric-card">
        <div class="metric-top">
            <div class="metric-icon"><i class="fa-solid fa-building"></i></div>
            <div class="metric-trend">92% terisi</div>
        </div>
        <div class="metric-num">{{ $totalRuangan ?? '34' }}</div>
        <div class="metric-label">Ruangan terdaftar</div>
    </div>

    <div class="metric-card">
        <div class="metric-top">
            <div class="metric-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
            <div class="metric-trend warn"><i class="fa-solid fa-circle-exclamation"></i> Perlu aksi</div>
        </div>
        <div class="metric-num">{{ $stokMenipis ?? '7' }}</div>
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
            <div class="bar-col"><span class="bar-val">320</span><div class="bar-shell"><div class="bar-fill" style="height:100%"></div></div><span class="bar-name">Elektronik</span></div>
            <div class="bar-col"><span class="bar-val">240</span><div class="bar-shell"><div class="bar-fill" style="height:75%"></div></div><span class="bar-name">Furnitur</span></div>
            <div class="bar-col"><span class="bar-val">180</span><div class="bar-shell"><div class="bar-fill" style="height:56%"></div></div><span class="bar-name">ATK</span></div>
            <div class="bar-col"><span class="bar-val">150</span><div class="bar-shell"><div class="bar-fill" style="height:47%"></div></div><span class="bar-name">Alat Lab</span></div>
            <div class="bar-col"><span class="bar-val">90</span><div class="bar-shell"><div class="bar-fill" style="height:28%"></div></div><span class="bar-name">Lainnya</span></div>
            <div class="bar-col"><span class="bar-val">40</span><div class="bar-shell"><div class="bar-fill" style="height:13%"></div></div><span class="bar-name">Kendaraan</span></div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-head">
            <div>
                <h3>Kondisi aset</h3>
                <p>Status keseluruhan aset</p>
            </div>
        </div>
        <div class="donut-wrap">
            <div class="donut">
                <svg width="140" height="140" viewBox="0 0 150 150">
                    <circle cx="75" cy="75" r="60" fill="none" stroke="#eeeef0" stroke-width="16"/>
                    <circle cx="75" cy="75" r="60" fill="none" stroke="#1a1b20" stroke-width="16" stroke-linecap="round" stroke-dasharray="294 377" stroke-dashoffset="0"/>
                    <circle cx="75" cy="75" r="60" fill="none" stroke="#8b8c94" stroke-width="16" stroke-linecap="round" stroke-dasharray="53 377" stroke-dashoffset="-294"/>
                    <circle cx="75" cy="75" r="60" fill="none" stroke="#c7c8ce" stroke-width="16" stroke-linecap="round" stroke-dasharray="30 377" stroke-dashoffset="-347"/>
                </svg>
                <div class="donut-center"><span class="big">78%</span><span class="small">kondisi baik</span></div>
            </div>
            <div class="legend">
                <div class="legend-row"><span class="legend-dot" style="background:#1a1b20"></span><span class="lname">Baik</span><span class="lval">78%</span></div>
                <div class="legend-row"><span class="legend-dot" style="background:#8b8c94"></span><span class="lname">Perlu perbaikan</span><span class="lval">14%</span></div>
                <div class="legend-row"><span class="legend-dot" style="background:#c7c8ce"></span><span class="lname">Rusak</span><span class="lval">8%</span></div>
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

        <div class="stock-item urgent">
            <div class="stock-icon"><i class="fa-solid fa-box-open"></i></div>
            <div class="stock-info"><div class="sname">Toner Fotocopy</div><div class="smeta">Gudang ATK</div></div>
            <div class="stock-qty">2<span class="min">min. 5</span></div>
        </div>
        <div class="stock-item urgent">
            <div class="stock-icon"><i class="fa-solid fa-box-open"></i></div>
            <div class="stock-info"><div class="sname">Tinta Printer</div><div class="smeta">Gudang ATK</div></div>
            <div class="stock-qty">3<span class="min">min. 10</span></div>
        </div>
        <div class="stock-item warn">
            <div class="stock-icon"><i class="fa-solid fa-box-open"></i></div>
            <div class="stock-info"><div class="sname">Kertas A4</div><div class="smeta">Gudang ATK</div></div>
            <div class="stock-qty">12<span class="min">min. 20</span></div>
        </div>
        <div class="stock-item warn">
            <div class="stock-icon"><i class="fa-solid fa-box-open"></i></div>
            <div class="stock-info"><div class="sname">Baterai AA</div><div class="smeta">Gudang Umum</div></div>
            <div class="stock-qty">15<span class="min">min. 30</span></div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-head">
            <div>
                <h3>Aktivitas terbaru</h3>
                <p>Riwayat perubahan data pada sistem</p>
            </div>
        </div>
        <table class="activity">
            <thead>
                <tr><th>Waktu</th><th>Aktivitas</th><th>Oleh</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td class="act-time">10:24</td>
                    <td>Menambahkan aset baru "Proyektor Epson X200"<span class="act-tag add">Tambah</span></td>
                    <td><span class="act-who"><span class="who-dot"></span>Administrator</span></td>
                </tr>
                <tr>
                    <td class="act-time">09:47</td>
                    <td>Memperbarui data ruangan "Lab Komputer 2"<span class="act-tag edit">Ubah</span></td>
                    <td><span class="act-who"><span class="who-dot"></span>Administrator</span></td>
                </tr>
                <tr>
                    <td class="act-time">09:15</td>
                    <td>Stok "Kertas A4" berkurang menjadi 12 pak<span class="act-tag edit">Ubah</span></td>
                    <td><span class="act-who"><span class="who-dot sys"></span>Sistem</span></td>
                </tr>
                <tr>
                    <td class="act-time">Kemarin</td>
                    <td>Menambahkan kategori baru "Alat Kesehatan"<span class="act-tag add">Tambah</span></td>
                    <td><span class="act-who"><span class="who-dot"></span>Administrator</span></td>
                </tr>
                <tr>
                    <td class="act-time">Kemarin</td>
                    <td>Menghapus aset "Kursi Rusak #114"<span class="act-tag del">Hapus</span></td>
                    <td><span class="act-who"><span class="who-dot"></span>Administrator</span></td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

@endsection