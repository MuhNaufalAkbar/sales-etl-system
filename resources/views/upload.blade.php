<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales ETL System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/upload.css') }}">
</head>
<body>

<div class="page">

    {{-- Header --}}
    <div class="header">
        <div class="header-icon">📊</div>
        <h1>Sales ETL System</h1>
        <p>
            Upload 3 file Excel sekaligus untuk menghasilkan
            <strong>Marketing.xlsx</strong> dan <strong>Finance.xlsx</strong> secara otomatis
        </p>
    </div>

    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="alert alert-success">
            <span class="alert-icon">✅</span>
            <div>
                {{ session('success') }}
                <br>
                <a href="/dashboard" class="dashboard-link">Buka Dashboard →</a>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-error">
            <span class="alert-icon">❌</span>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error">
            <span class="alert-icon">⚠️</span>
            <ul style="list-style: none; padding: 0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Upload Card --}}
    <div class="card">

        <form
            action="{{ route('upload.process') }}"
            method="POST"
            enctype="multipart/form-data"
            id="uploadForm">

            @csrf

            <div class="dropzones">
                <div class="dropzone" id="dz" onclick="document.getElementById('fileInput').click()">
                    <div class="dz-icon">📄</div>
                    <div class="dz-body">
                        <h3>Drag & drop 3 file Excel di sini</h3>
                        <p class="dz-hint">Drop 3 file sekaligus atau pilih manual. Format: .xlsx, .xls, .csv</p>
                        <p class="dz-filename" id="fn_file"></p>
                        <ul class="dz-filelist" id="fileList"></ul>
                    </div>
                    <button type="button" class="dz-btn">Pilih file</button>
                    <input type="file" id="fileInput" name="files[]" accept=".xlsx,.xls,.csv" hidden required multiple>
                </div>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-upload" id="btnUpload" disabled>
                <span id="btnIcon">🚀</span>
                <span id="btnText">Upload &amp; Proses</span>
            </button>

            <div class="progress mt-3">
                <div class="progress-container" id="progressContainer">
                    <div class="progress-bar-custom" id="progressBar">
                        <span id="progressText">0%</span>
                    </div>
                </div>
            </div>

        </form>

        {{-- Feature Highlights --}}
        <div class="features">
            <div class="feature">
                <div class="feature-icon">⚡</div>
                <h4>Fast processing</h4>
                <p>Laravel Queue ETL</p>
            </div>
            <div class="feature">
                <div class="feature-icon">📈</div>
                <h4>Dashboard</h4>
                <p>Omzet, profit &amp; orders</p>
            </div>
            <div class="feature">
                <div class="feature-icon">📁</div>
                <h4>Export otomatis</h4>
                <p>Marketing &amp; Finance.xlsx</p>
            </div>
        </div>

    </div>

</div>

<script src="{{ asset('js/upload.js') }}"></script>

</body>
</html>