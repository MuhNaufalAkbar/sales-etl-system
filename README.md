
# Sales ETL System

Sistem ETL (Extract, Transform, Load) berbasis Laravel untuk mengotomatisasi proses pengolahan data penjualan dari beberapa file Excel menjadi output Marketing dan Finance yang siap digunakan.

## Fitur Utama

* Upload 3 file Excel sekaligus
* Proses ETL menggunakan Laravel Queue
* Validasi data dan pencatatan error
* Dashboard monitoring batch import
* Export Marketing.xlsx
* Export Finance.xlsx
* Download Validation Error Report (.csv)
* Statistik penjualan dan profit
* Tracking status import batch

---

# Teknologi yang Digunakan

* PHP 8.2+
* Laravel 12
* MySQL
* Laravel Queue
* Laravel Blade
* Maatwebsite Excel
* Bootstrap / Custom CSS

---

# Struktur Sistem

1. User mengupload file Excel.
2. Sistem menyimpan data mentah ke tabel `raw_sales`.
3. Queue Job melakukan transformasi data.
4. Sistem mencocokkan SKU dengan master produk.
5. Data valid disimpan ke tabel `sales_transformed`.
6. Data tidak valid disimpan ke tabel `validation_errors`.
7. Sistem menghasilkan:

   * Marketing.xlsx
   * Finance.xlsx
   * Validation Error Report.csv

---

# Instalasi

## 1. Clone Repository

```bash
git clone https://github.com/USERNAME/sales-etl-system.git

cd sales-etl-system
```

Ganti `USERNAME` dengan username GitHub Anda.

---

## 2. Install Dependency

```bash
composer install
```

---

## 3. Copy Environment

```bash
cp .env.example .env
```

atau Windows:

```bash
copy .env.example .env
```

---

## 4. Generate Application Key

```bash
php artisan key:generate
```

---

## 5. Konfigurasi Database

Edit file `.env`

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sales_etl
DB_USERNAME=root
DB_PASSWORD=
```

---

## 6. Jalankan Migration

```bash
php artisan migrate
```

---

## 7. Jalankan Seeder (Opsional)

Jika tersedia seeder:

```bash
php artisan db:seed
```

---

## 8. Buat Symbolic Link Storage

```bash
php artisan storage:link
```

---

# Menjalankan Aplikasi

## Terminal 1

Menjalankan Laravel Server

```bash
php artisan serve
```

Aplikasi dapat diakses melalui:

```text
http://127.0.0.1:8000
```

---

## Terminal 2

Menjalankan Queue Worker

```bash
php artisan queue:work
```

Queue worker harus tetap aktif agar proses ETL berjalan.

---

# Cara Penggunaan

## Upload File

Upload 3 file Excel:

* Sales Daily
* Product Mapping
* Master Product

Setelah upload berhasil:

1. Sistem membuat Import Batch.
2. Queue memproses ETL.
3. Data ditransformasikan ke database.
4. Dashboard diperbarui.

---

# Dashboard

Dashboard menampilkan:

* Total Batch
* Total Sales
* Total Omzet
* Total Profit
* Progress Batch
* Download Export

---

# Download Output

## Marketing Export

```text
Marketing.xlsx
```

Berisi data untuk kebutuhan tim Marketing.

---

## Finance Export

```text
Finance.xlsx
```

Berisi data untuk kebutuhan tim Finance.

---

## Validation Error Report

```text
VALIDATION_ERROR_REPORT.csv
```

Berisi daftar data yang gagal divalidasi seperti:

* SKU tidak ditemukan
* Data kosong
* Mapping gagal

---

# Struktur Database

## import_batches

Menyimpan informasi batch upload.

## uploaded_files

Menyimpan file yang diupload.

## raw_sales

Menyimpan data mentah hasil import.

## products

Master produk dan HPP.

## sales_transformed

Data hasil transformasi.

## validation_errors

Log error validasi.

---

# Queue Workflow

```text
Upload File
      ↓
ImportExcelJob
      ↓
Raw Sales
      ↓
TransformSalesJob
      ↓
Sales Transformed
      ↓
GenerateOutputJob
      ↓
Marketing.xlsx
Finance.xlsx
```

---

# Troubleshooting

## Queue Tidak Berjalan

Pastikan menjalankan:

```bash
php artisan queue:work
```

---

## Export Tidak Bisa Download

Pastikan file sudah berhasil dibuat pada folder:

```text
storage/app/private/exports
```

---

## Error Report Kosong

Error report hanya muncul apabila terdapat data yang gagal divalidasi.

Contoh:

```text
SKU tidak ditemukan
```

---

# Author

Muhammad Naufal Akbar

Case Study Full-Stack Engineer

PT Sigma Digital Nusantara
=======
# sales-etl-system
Fullstack ETL Automation System using Laravel 12 for processing sales Excel files into Marketing and Finance reports.

