# TASKS - Aplikasi LokaIlmu

# Dasar pengetahuan implementasi fitur

Saat anda menyelesaikan tugas dan merujuk ke file yang relevan, perbarui file ini sebagai memori kami untuk membantu tugas mendatang.

## Deskripsi Proyek
LokaIlmu adalah solusi mobile yang terdiri dari dua aplikasi terpisah untuk mendukung peningkatan keterampilan digital guru. Aplikasi ini menawarkan layanan pelatihan, perpustakaan online, dan forum diskusi untuk meningkatkan keterampilan digital guru, khususnya di sekolah terakreditasi B dan ke bawah.

**Aplikasi terdiri dari dua aplikasi terpisah:**
1. **LokaIlmu Guru** - Aplikasi untuk para guru mencari dan mengakses pelatihan, perpustakaan digital, dan forum diskusi.
2. **LokaIlmu Mentor** - Aplikasi untuk pelatih/ahli yang menawarkan layanan pelatihan kepada guru.

## Tech Stack
- **Frontend**: Flutter (kedua aplikasi)
- **Backend**: Laravel (API terpadu)
- **Database**: MySQL

## Breakdown Tugas

### 1. Setup Proyek dan Infrastruktur
- [x] 1.1. Setup repositori Git dan struktur proyek (Backend repository telah dibuat)
- [x] 1.2. Konfigurasi lingkungan pengembangan Flutter
- [x] 1.3. Setup project Laravel dan konfigurasi database
- [ ] 1.4. Konfigurasi CI/CD untuk kedua aplikasi
- [ ] 1.5. Desain arsitektur API terpadu dan database bersama
- [ ] 1.6. Perencanaan kode yang dapat dibagikan antara kedua aplikasi


### 2. Desain UI/UX
- [x] 2.1. Wireframing untuk kedua aplikasi (Figma/Adobe XD)
- [x] 2.2. Desain tampilan untuk LokaIlmu Guru
- [x] 2.3. Desain tampilan untuk LokaIlmu Mentor
- [x] 2.4. Sistem navigasi untuk kedua aplikasi
- [x] 2.5. Desain responsif untuk berbagai ukuran layar
- [x] 2.6. Desain tema, warna, dan branding untuk kedua aplikasi dengan identitas yang terhubung

### 3. Backend Development - API Terpadu
- [x] 3.1. Implementasi sistem autentikasi terpadu
- [x] 3.2. API login untuk Guru dan Pelatih (endpoint terpisah)
- [ ] 3.3. API registrasi untuk Guru dengan validasi kredensial (nama, email/hp, password, NPSN, NUPTK, tingkat pengajar, spesialisasi, foto KTP)
- [ ] 3.4. API registrasi untuk Pelatih dengan validasi kredensial (nama, email/hp, password, spesialisasi, upload berkas, foto KTP)
- [ ] 3.5. Manajemen profil pengguna untuk kedua jenis pengguna
- [ ] 3.6. Implementasi sistem otorisasi dan role-based access control

### 4. Frontend Development - LokaIlmu Guru (Autentikasi & Profil)
- [ ] 4.1. Implementasi halaman login aplikasi Guru
- [ ] 4.2. Implementasi halaman registrasi aplikasi Guru
- [ ] 4.3. Implementasi halaman profil Guru (lihat & edit)
- [ ] 4.4. Manajemen state autentikasi dengan token di aplikasi Guru

### 5. Frontend Development - LokaIlmu Mentor (Autentikasi & Profil)
- [ ] 5.1. Implementasi halaman login aplikasi Mentor
- [ ] 5.2. Implementasi halaman registrasi aplikasi Mentor
- [ ] 5.3. Implementasi halaman profil Mentor (lihat & edit)
- [ ] 5.4. Manajemen state autentikasi dengan token di aplikasi Mentor

### 6. Backend Development - Fitur Pencarian dan Pesan
- [ ] 6.1. API pencarian mentor/pelatih untuk guru
- [ ] 6.2. Implementasi sistem chat terpadu
- [ ] 6.3. Implementasi sistem pemesanan terpadu
- [ ] 6.4. API untuk mengelola percakapan antara guru dan pelatih
- [ ] 6.5. Integrasi dengan sistem notifikasi
- [ ] 6.6. Implementasi filter dan pencarian lanjutan

### 7. Frontend Development - LokaIlmu Guru (Pencarian dan Pesan)
- [ ] 7.1. Implementasi halaman pencarian mentor
- [ ] 7.2. Halaman detail mentor/pelatih
- [ ] 7.3. Sistem chat/pesan dengan pelatih
- [ ] 7.4. Implementasi UI notifikasi
- [ ] 7.5. Fitur filter dan pencarian lanjutan

### 8. Frontend Development - LokaIlmu Mentor (Visibilitas dan Pesan)
- [ ] 8.1. Implementasi halaman profil publik (terlihat oleh guru)
- [ ] 8.2. Halaman manajemen visibilitas profil
- [ ] 8.3. Sistem chat/pesan dengan guru
- [ ] 8.4. Implementasi UI notifikasi
- [ ] 8.5. Statistik pencarian dan profil views

### 9. Backend Development - Sistem Pelatihan
- [ ] 9.1. API untuk permintaan pelatihan
- [ ] 9.2. API untuk menerima/menolak permintaan pelatihan
- [ ] 9.3. API untuk manajemen materi pelatihan
- [ ] 9.4. API untuk penjadwalan sesi pelatihan
- [ ] 9.5. Sistem untuk melacak progres pelatihan

### 10. Frontend Development - LokaIlmu Guru (Sistem Pelatihan)
- [ ] 10.1. Implementasi halaman permintaan pelatihan
- [ ] 10.2. Tampilan status permintaan pelatihan
- [ ] 10.3. Implementasi halaman akses materi pelatihan
- [ ] 10.4. Tampilan jadwal sesi pelatihan
- [ ] 10.5. Halaman progres pelatihan

### 11. Frontend Development - LokaIlmu Mentor (Sistem Pelatihan)
- [ ] 11.1. Implementasi halaman permintaan pelatihan masuk
- [ ] 11.2. Implementasi halaman menerima/menolak permintaan
- [ ] 11.3. Halaman upload dan manajemen materi pelatihan
- [ ] 11.4. Halaman manajemen jadwal sesi pelatihan
- [ ] 11.5. Dashboard monitoring progres pelatihan guru

### 12. Backend Development - Sistem Pembayaran
- [ ] 12.1. Integrasi dengan gateway pembayaran
- [ ] 12.2. API untuk proses pembayaran awal
- [ ] 12.3. API untuk pelunasan/pembayaran akhir
- [ ] 12.4. Sistem pencatatan dan laporan keuangan
- [ ] 12.5. Implementasi keamanan transaksi

### 13. Frontend Development - LokaIlmu Guru (Pembayaran)
- [ ] 13.1. Halaman pembayaran dengan pilihan metode pembayaran
- [ ] 13.2. Halaman konfirmasi pembayaran
- [ ] 13.3. Tampilan riwayat transaksi
- [ ] 13.4. Implementasi UI untuk pelunasan

### 14. Frontend Development - LokaIlmu Mentor (Pembayaran)
- [ ] 14.1. Dashboard pendapatan
- [ ] 14.2. Halaman rincian pendapatan per pelatihan
- [ ] 14.3. Halaman riwayat transaksi
- [ ] 14.4. Halaman pengaturan pembayaran
- [ ] 14.5. Tampilan status pelunasan dari guru

### 15. Backend Development - Rating dan Review
- [ ] 15.1. API untuk memberikan rating kepada pelatih
- [ ] 15.2. API untuk membuat dan menampilkan review
- [ ] 15.3. Sistem perhitungan rating rata-rata
- [ ] 15.4. Integrasi rating dengan sistem pencarian

### 16. Frontend Development - LokaIlmu Guru (Rating dan Review)
- [ ] 16.1. Implementasi UI pemberian rating
- [ ] 16.2. Halaman untuk menulis review
- [ ] 16.3. Tampilan rating dan review di profil pelatih
- [ ] 16.4. Fitur filter berdasarkan rating

### 17. Frontend Development - LokaIlmu Mentor (Rating dan Review)
- [ ] 17.1. Dashboard rating dan review yang diterima
- [ ] 17.2. Halaman detail review dari guru
- [ ] 17.3. Fitur respons terhadap review
- [ ] 17.4. Statistik dan tren rating

### 18. Backend Development - Forum Diskusi
- [ ] 18.1. API untuk membuat topik diskusi baru
- [ ] 18.2. API untuk menampilkan daftar diskusi
- [ ] 18.3. API untuk komentar dan balasan
- [ ] 18.4. Sistem kategori dan tag untuk diskusi
- [ ] 18.5. Implementasi pencarian dalam forum

### 19. Frontend Development - LokaIlmu Guru (Forum Diskusi)
- [ ] 19.1. Halaman utama forum dengan daftar topik
- [ ] 19.2. Halaman untuk membuat topik baru
- [ ] 19.3. Tampilan thread diskusi dengan komentar
- [ ] 19.4. Implementasi sistem balasan bertingkat
- [ ] 19.5. Pencarian dan filter dalam forum

### 20. Frontend Development - LokaIlmu Mentor (Forum Diskusi)
- [ ] 20.1. Halaman utama forum dengan daftar topik
- [ ] 20.2. Halaman untuk membuat topik baru sebagai ahli
- [ ] 20.3. Tampilan thread diskusi dengan komentar
- [ ] 20.4. Fitur penyorotan jawaban dari mentor
- [ ] 20.5. Pencarian dan filter dalam forum

### 21. Backend Development - Perpustakaan Digital
- [ ] 21.1. API untuk mengelola bahan-bahan perpustakaan
- [ ] 21.2. API untuk menyimpan/bookmark materi
- [ ] 21.3. Sistem kategorisasi perpustakaan
- [ ] 21.4. Implementasi pencarian dalam perpustakaan
- [ ] 21.5. Manajemen hak akses materi

### 22. Frontend Development - LokaIlmu Guru (Perpustakaan Digital)
- [ ] 22.1. Halaman utama perpustakaan digital
- [ ] 22.2. Halaman detail materi/buku
- [ ] 22.3. Implementasi fitur bookmark/simpan buku
- [ ] 22.4. Tampilan "Buku Saya" untuk materi tersimpan
- [ ] 22.5. Implementasi pencarian dan filter perpustakaan

### 23. Frontend Development - LokaIlmu Mentor (Perpustakaan Digital)
- [ ] 23.1. Halaman upload materi perpustakaan 
- [ ] 23.2. Halaman manajemen materi yang telah diupload
- [ ] 23.3. Implementasi fitur statistik unduhan/pembacaan
- [ ] 23.4. Halaman untuk mengatur hak akses materi
- [ ] 23.5. Implementasi pencarian dan filter dalam perpustakaan

### 24. Backend Development - Notifikasi
- [ ] 24.1. Sistem notifikasi real-time
- [ ] 24.2. API untuk manajemen notifikasi
- [ ] 24.3. Integrasi notifikasi dengan semua fitur
- [ ] 24.4. Implementasi notifikasi push
- [ ] 24.5. Penyimpanan dan pengaturan preferensi notifikasi

### 25. Frontend Development - LokaIlmu Guru (Notifikasi)
- [ ] 25.1. Implementasi UI untuk notifikasi real-time
- [ ] 25.2. Halaman riwayat notifikasi
- [ ] 25.3. Pengaturan preferensi notifikasi
- [ ] 25.4. Integrasi notifikasi di semua halaman
- [ ] 25.5. Implementasi badge notifikasi

### 26. Frontend Development - LokaIlmu Mentor (Notifikasi)
- [ ] 26.1. Implementasi UI untuk notifikasi real-time
- [ ] 26.2. Halaman riwayat notifikasi
- [ ] 26.3. Pengaturan preferensi notifikasi
- [ ] 26.4. Integrasi notifikasi di semua halaman
- [ ] 26.5. Implementasi badge notifikasi

### 27. Testing
- [ ] 27.1. Unit testing untuk backend
- [ ] 27.2. Testing integrasi API
- [ ] 27.3. UI testing untuk aplikasi Guru
- [ ] 27.4. UI testing untuk aplikasi Mentor
- [ ] 27.5. Testing end-to-end untuk aplikasi Guru
- [ ] 27.6. Testing end-to-end untuk aplikasi Mentor
- [ ] 27.7. Performance testing
- [ ] 27.8. Security testing

### 28. Deployment dan Monitoring
- [ ] 28.1. Setup server produksi
- [ ] 28.2. Deployment backend ke server
- [ ] 28.3. Publikasi aplikasi Guru ke Google Play Store
- [ ] 28.4. Publikasi aplikasi Guru ke Apple App Store
- [ ] 28.5. Publikasi aplikasi Mentor ke Google Play Store
- [ ] 28.6. Publikasi aplikasi Mentor ke Apple App Store
- [ ] 28.7. Implementasi sistem monitoring dan logging
- [ ] 28.8. Setup backup dan disaster recovery

### 29. Dokumentasi
- [ ] 29.1. Dokumentasi API
- [ ] 29.2. Dokumentasi kode
- [ ] 29.3. Manual pengguna untuk aplikasi Guru
- [ ] 29.4. Manual pengguna untuk aplikasi Mentor
- [ ] 29.5. Dokumentasi teknis untuk pengembang
