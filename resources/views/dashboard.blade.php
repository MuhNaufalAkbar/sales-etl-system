<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Sales ETL</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>

<div class="container">

    <div class="header">
        <h1>Dashboard Sales ETL</h1>
        <a href="/" class="btn">Upload Baru</a>
    </div>

    {{-- Summary Cards --}}
    <div class="grid">
        <div class="card">
            <h2>Total Omzet</h2>
            <p>Rp {{ number_format($totalOmzet ?? 0, 0, ',', '.') }}</p>
        </div>
        <div class="card">
            <h2>Total Profit</h2>
            <p>Rp {{ number_format($totalProfit ?? 0, 0, ',', '.') }}</p>
        </div>
        <div class="card">
            <h2>Total Order</h2>
            <p>{{ number_format($totalOrders ?? 0) }}</p>
        </div>
        <div class="card">
            <h2>Total Qty</h2>
            <p>{{ number_format($totalQty ?? 0) }}</p>
        </div>
    </div>

    {{-- Batch History Table --}}
    <div class="section">
        <h3>Riwayat Batch Upload</h3>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Status</th>
                    <th>Progress</th>
                    <th>Total Rows</th>
                    <th>Processed</th>
                    <th>Started</th>
                    <th>Finished</th>
                </tr>
            </thead>
            <tbody>
                @forelse($batches as $batch)
                    <tr>
                        <td>{{ $batch->id }}</td>
                        <td>
                            <span class="badge badge-{{ $batch->status }}">
                                {{ strtoupper($batch->status) }}
                            </span>
                        </td>
                        <td>{{ $batch->progress ?? 0 }}%</td>
                        <td>{{ $batch->total_rows ?? 0 }}</td>
                        <td>{{ $batch->processed_rows ?? 0 }}</td>
                        <td>
                            {{ $batch->started_at
                                ? \Carbon\Carbon::parse($batch->started_at)->format('d-m-Y H:i')
                                : '-' }}
                        </td>
                        <td>
                            {{ $batch->finished_at
                                ? \Carbon\Carbon::parse($batch->finished_at)->format('d-m-Y H:i')
                                : '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">Belum ada data batch.</td>
                    </tr>
                @endforelse
                
            </tbody>
        </table>
    </div>

    {{-- Export Files --}}
    <div class="section">
        <h3>File Export</h3>

        @forelse($batches as $batch)
            @if($batch->status === 'completed')
                <div class="export-item">

                    <a href="{{ route('error.report', $batch->id) }}"
                       class="download-btn"
                       style="background: #dc2626;">
                        Error Report
                    </a>

                    <div>
                        <strong>Batch #{{ $batch->id }}</strong><br>
                        MARKETING_{{ $batch->id }}.xlsx<br>
                        FINANCE_{{ $batch->id }}.xlsx
                    </div>

                    <div>
                        <a href="{{ route('download.marketing', $batch->id) }}" class="download-btn">
                            Download Marketing
                        </a>
                        <a href="{{ route('download.finance', $batch->id) }}" class="download-btn">
                            Download Finance
                        </a>
                    </div>

                </div>
            @endif
        @empty
            <p>Belum ada file export.</p>
        @endforelse
    </div>

</div>

</body>
</html>