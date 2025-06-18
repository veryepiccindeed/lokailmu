# LokaIlmu - Backend

Repositori ini berisi source code untuk aplikasi LokaIlmu, sebuah platform pembelajaran online yang dirancang untuk menghubungkan guru, khususnya yang mengajar di sekolah terakreditasi B, dan mentor.

## Gambaran Umum

Backend ini dibangun menggunakan kerangka kerja **Laravel** dan menyediakan RESTful API untuk mendukung semua fitur aplikasi LokaIlmu, termasuk:
- Otentikasi pengguna (guru, mentor)
- Manajemen profil
- Manajemen kursus dan pelatihan
- Diskusi forum

**Catatan:** Repositori ini hanya berisi layanan backend. Aplikasi frontend dikelola di repositori terpisah. Repositori frontend dapat dilihat di https://github.com/KingPublic/LokaIlmu_FE_Guru

## Memulai

### Prasyarat
- PHP >= 8.1
- Composer
- MySQL


### Instalasi & Pengaturan

1.  **Kloning repositori:**
    ```bash
    git clone https://github.com/veryepiccindeed/lokailmu
    cd lokailmu
    ```

2.  **Instal dependensi PHP:**
    ```bash
    composer install
    ```

3.  **Buat file environment Anda:**
    ```bash
    cp .env.example .env
    ```

4.  **Generate kunci aplikasi:**
    ```bash
    php artisan key:generate
    ```

5.  **Konfigurasikan database Anda:**
    Buka file `.env` dan atur detail koneksi database Anda (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).

6.  **Jalankan migrasi database:**
    ```bash
    php artisan migrate
    ```

7.  **(Opsional) Isi database dengan data awal:**
    ```bash
    php artisan db:seed
    ```

### Menjalankan Server

Untuk memulai server development lokal, jalankan perintah berikut:
```bash
php artisan serve
```
API akan tersedia di `http://127.0.0.1:8000`.

## Dokumentasi API

Dokumentasi API untuk proyek ini dibuat secara otomatis menggunakan [Scramble](https://scramble.dedoc.co/). Anda dapat mengakses dokumentasi lengkap di route berikut setelah menjalankan server:

`/docs/api`
