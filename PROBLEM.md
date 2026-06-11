# PROBLEM.md

## Challenges & Solutions

Selama pengembangan Sales ETL System, terdapat beberapa tantangan teknis yang dihadapi beserta solusi yang diterapkan.

---

## 1. Memvalidasi Tiga File Dengan Struktur Berbeda

### Problem

Aplikasi harus menerima tiga file Excel yang berbeda dengan struktur dan tujuan data yang berbeda. Risiko yang muncul adalah ketidaksesuaian format kolom, data kosong, dan duplikasi data yang dapat menyebabkan proses ETL gagal.

### Solution

* Membuat validasi file upload untuk memastikan jumlah file sesuai kebutuhan.
* Melakukan validasi setiap baris data sebelum diproses.
* Menyimpan data yang gagal validasi ke tabel `validation_errors`.
* Menyediakan fitur download Validation Error Report agar pengguna dapat memperbaiki data dengan mudah.

---

## 2. Menjaga Integritas Data Saat Proses ETL

### Problem

Data berasal dari beberapa sumber file dan harus digabungkan menjadi satu struktur data yang konsisten sebelum digunakan untuk analisis dan export.

### Solution

* Menggunakan proses ETL (Extract, Transform, Load).
* Membersihkan data sebelum disimpan ke database.
* Menormalisasi format tanggal, angka, dan nilai kosong.
* Memastikan seluruh proses berjalan secara terstruktur sebelum menghasilkan output.

---

## 3. Menangani Data Error Tanpa Menghentikan Seluruh Proses

### Problem

Jika ditemukan beberapa baris data yang tidak valid, seluruh proses tidak boleh langsung gagal karena masih ada data valid yang dapat diproses.

### Solution

* Memisahkan data valid dan data invalid.
* Data valid tetap diproses ke database.
* Data invalid dicatat ke tabel error.
* Pengguna dapat mengunduh laporan error untuk melakukan koreksi.

---

## 4. Pembuatan File Export Dengan Format Berbeda

### Problem

Sistem harus menghasilkan dua file output berbeda (Marketing.xlsx dan Finance.xlsx) dari dataset yang sama namun dengan kebutuhan kolom yang berbeda.

### Solution

* Membuat class export terpisah untuk masing-masing kebutuhan.
* Menggunakan Laravel Excel untuk menghasilkan file secara otomatis.
* Menyimpan file hasil export ke storage dan menyediakan fitur download melalui dashboard.

---

## 5. Meningkatkan User Experience Saat Upload

### Problem

Proses upload dan ETL membutuhkan waktu beberapa detik sehingga pengguna tidak mendapatkan feedback ketika sistem sedang bekerja.

### Solution

* Menambahkan drag-and-drop upload area.
* Menambahkan progress bar saat proses upload.
* Menambahkan status processing pada tombol upload.
* Menampilkan notifikasi keberhasilan maupun kegagalan proses.

---

## 6. Pemisahan Frontend dan Backend

### Problem

Pada tahap awal pengembangan, seluruh CSS dan JavaScript berada dalam file Blade sehingga sulit dikelola dan dikembangkan.

### Solution

* Memisahkan stylesheet ke file CSS terpisah.
* Memisahkan JavaScript ke file JS terpisah.
* Menggunakan struktur folder yang lebih rapi dan mudah dipelihara.

---

## 7. Pengelolaan File Hasil Export

### Problem

File hasil export harus dapat diunduh kembali oleh pengguna tanpa perlu melakukan proses ETL ulang.

### Solution

* Menyimpan file export pada storage aplikasi.
* Membuat endpoint download khusus untuk Marketing dan Finance report.
* Menambahkan validasi keberadaan file sebelum proses download.

---

## Lessons Learned

Melalui proyek ini, saya memperoleh pengalaman dalam:

* Implementasi ETL menggunakan Laravel.
* Validasi dan pembersihan data Excel.
* Pembuatan dashboard berbasis data.
* Pengelolaan export report menggunakan Laravel Excel.
* Error handling dan logging data invalid.
* Pengembangan antarmuka pengguna yang lebih interaktif dan mudah digunakan.

Proyek ini menunjukkan bagaimana proses manual berbasis spreadsheet dapat diotomatisasi menjadi sistem web yang lebih cepat, konsisten, dan mudah dipelihara.
