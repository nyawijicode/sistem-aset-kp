# 📦 Sistem Manajemen Aset

> Sistem informasi manajemen aset berbasis web yang dibangun dengan **Laravel 12** dan **Filament v3**. Dikembangkan sebagai proyek Kerja Praktek untuk membantu pengelolaan inventaris aset organisasi/perusahaan secara efisien dan terstruktur.

[![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg?logo=laravel)](https://laravel.com)
[![Filament](https://img.shields.io/badge/Filament-3.3-orange.svg)](https://filamentphp.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg?logo=php)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

---

## 📋 Daftar Isi

- [Fitur Utama](#-fitur-utama)
- [Tech Stack](#-tech-stack)
- [System Requirements](#-system-requirements)
- [Instalasi & Setup](#-instalasi--setup)
- [Perintah CLI Penting](#-perintah-cli-penting)
- [Struktur Database](#-struktur-database)
- [Arsitektur & Penjelasan Class](#-arsitektur--penjelasan-class)
- [Alur Penggunaan Sistem](#-alur-penggunaan-sistem)
- [Manajemen Role & Hak Akses](#-manajemen-role--hak-akses)
- [Modul Laporan](#-modul-laporan)
- [Pertanyaan & Jawaban Seminar KP](#-pertanyaan--jawaban-seminar-kp)

---

## ✨ Fitur Utama

| Fitur                        | Keterangan                                                                 |
| ---------------------------- | -------------------------------------------------------------------------- |
| 🗂️ **Daftar Aset**           | CRUD aset dengan kode unik, kategori, satuan, dan stok otomatis            |
| 📥 **Aset Masuk**            | Pencatatan penerimaan aset beserta pengelolaan stok otomatis               |
| 📤 **Aset Keluar**           | Pencatatan distribusi/pengeluaran aset beserta pengelolaan stok otomatis   |
| 🔢 **Serial Number (SN)**    | Tracking per unit untuk aset yang memerlukan identifikasi SN unik          |
| 📊 **Dashboard Statistik**   | Ringkasan total aset, stok, dan transaksi masuk/keluar bulan ini           |
| ⚠️ **Peringatan Stok Habis** | Widget otomatis yang muncul saat ada aset dengan stok = 0                  |
| 📄 **Laporan PDF**           | Cetak laporan Daftar Aset, Aset Masuk, Aset Keluar dengan filter aktif     |
| 👥 **Multi-Role**            | Role `pimpinan` dan `admin` dengan hak akses berbeda                       |
| 🔍 **Filter Canggih**        | Filter berdasarkan tanggal, kategori, supplier, penerima, dan kondisi stok |

---

## 🛠️ Tech Stack

### Backend

| Teknologi          | Versi   | Fungsi                                              |
| ------------------ | ------- | --------------------------------------------------- |
| **PHP**            | ^8.2    | Bahasa pemrograman server-side utama                |
| **Laravel**        | ^12.0   | Framework PHP untuk routing, ORM, middleware, dll   |
| **Filament**       | 3.3     | Admin panel builder (Form, Table, Widget, Resource) |
| **Laravel DomPDF** | ^3.1    | Generasi laporan PDF dari template Blade            |
| **Laravel Tinker** | ^2.10.1 | REPL interaktif untuk debugging dan eksplorasi data |

### Frontend

| Teknologi        | Versi                   | Fungsi                                              |
| ---------------- | ----------------------- | --------------------------------------------------- |
| **Livewire**     | (bundled with Filament) | Reactive UI tanpa menulis JavaScript manual         |
| **Alpine.js**    | (bundled with Filament) | Komponen interaktif ringan di sisi klien            |
| **Tailwind CSS** | (bundled with Filament) | Utility-first CSS framework untuk tampilan Filament |
| **Vite**         | latest                  | Asset bundler untuk kompilasi CSS & JS              |

### Database

| Teknologi              | Keterangan                                                                  |
| ---------------------- | --------------------------------------------------------------------------- |
| **SQLite**             | Default (file: `database/database.sqlite`) — cocok untuk development & demo |
| **MySQL / PostgreSQL** | Didukung penuh, konfigurasi via `.env` (direkomendasikan untuk production)  |

### Development Tools

| Paket            | Fungsi                                   |
| ---------------- | ---------------------------------------- |
| **Laravel Pail** | Real-time log viewer di terminal         |
| **Laravel Pint** | PHP code style fixer (PSR-12)            |
| **Laravel Sail** | Docker environment untuk Laravel         |
| **FakerPHP**     | Generate data palsu untuk seeder/testing |
| **PHPUnit**      | Framework testing otomatis               |

---

## 💻 System Requirements

### Minimum

| Komponen       | Kebutuhan                                         |
| -------------- | ------------------------------------------------- |
| **OS**         | Windows 10/11, macOS 12+, Ubuntu 20.04+           |
| **PHP**        | 8.2 atau lebih baru                               |
| **Composer**   | 2.x                                               |
| **Node.js**    | 18.x atau lebih baru                              |
| **npm**        | 9.x atau lebih baru                               |
| **Database**   | SQLite 3 (default), MySQL 8+, atau PostgreSQL 13+ |
| **Web Server** | Apache / Nginx / PHP Built-in Server              |
| **RAM**        | Minimal 512 MB (rekomendasi 1 GB+)                |
| **Storage**    | Minimal 500 MB bebas                              |

### PHP Extensions yang Diperlukan

```
- php-pdo
- php-pdo_sqlite (atau pdo_mysql / pdo_pgsql)
- php-mbstring
- php-xml
- php-curl
- php-zip
- php-bcmath
- php-gd (untuk PDF)
- php-fileinfo
```

### Tools yang Perlu Terinstal

- **Git** — version control
- **XAMPP** (Windows) / **Homebrew** (macOS) / **apt** (Linux) — untuk PHP & web server
- **Composer** — https://getcomposer.org/download/
- **Node.js + npm** — https://nodejs.org/

---

## 🚀 Instalasi & Setup

### Langkah 1 — Clone Repository

```bash
git clone https://github.com/nyawijicode/sistem-aset-kp.git
cd sistem-aset-kp
```

### Langkah 2 — Install Dependencies PHP

```bash
composer install
```

> Perintah ini akan mengunduh semua package yang tercantum di `composer.json` ke folder `vendor/`.

### Langkah 3 — Buat File Environment

```bash
cp .env.example .env
```

Kemudian buka file `.env` dan sesuaikan konfigurasi:

```dotenv
APP_NAME="Sistem Aset KP"
APP_ENV=local
APP_KEY=                          # akan diisi otomatis di langkah berikutnya
APP_DEBUG=true
APP_URL=http://localhost:8000

# Pilihan 1: SQLite (default, tanpa konfigurasi tambahan)
DB_CONNECTION=sqlite
# DB_DATABASE=/absolute/path/to/database.sqlite

# Pilihan 2: MySQL
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=sistem_aset_kp
# DB_USERNAME=root
# DB_PASSWORD=
```

### Langkah 4 — Generate Application Key

```bash
php artisan key:generate
```

> Key ini digunakan untuk enkripsi session, cookie, dan data sensitif lainnya.

### Langkah 5 — Siapkan Database

**Jika menggunakan SQLite (default):**

```bash
# File database sudah ada di repo: database/database.sqlite
# Jika belum ada, buat file kosong:
touch database/database.sqlite       # Linux/macOS
type nul > database\database.sqlite  # Windows
```

**Jika menggunakan MySQL:**

```sql
-- Buat database terlebih dahulu di MySQL
CREATE DATABASE sistem_aset_kp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Langkah 6 — Jalankan Migrasi Database

```bash
php artisan migrate
```

> Perintah ini akan membuat semua tabel sesuai schema yang telah didefinisikan di folder `database/migrations/`.

### Langkah 7 — Isi Data Awal (Seeder)

```bash
php artisan db:seed
```

Seeder akan membuat:

- **2 akun user** default: `pimpinan@example.com` dan `admin@example.com` (password: `password`)
- **Contoh data aset**, transaksi masuk, dan transaksi keluar

> Untuk melihat akun default yang dibuat, cek file `database/seeders/UserSeeder.php`.

### Langkah 8 — Install Dependencies JavaScript

```bash
npm install
```

### Langkah 9 — Build Assets Frontend

```bash
# Untuk production / demo:
npm run build

# Untuk development (hot-reload):
npm run dev
```

### Langkah 10 — Jalankan Aplikasi

```bash
php artisan serve
```

Buka browser dan akses: **http://localhost:8000**

Panel admin Filament ada di: **http://localhost:8000/admin**

---

### Setup Cepat (One-Command)

Jika Anda ingin setup sekaligus, jalankan script yang sudah disediakan:

```bash
composer run setup
```

Script ini secara otomatis menjalankan: `composer install` → copy `.env` → `key:generate` → `migrate` → `npm install` → `npm run build`.

---

### Menjalankan Mode Development Lengkap

```bash
composer run dev
```

Perintah ini menjalankan **4 proses sekaligus** secara bersamaan:

1. `php artisan serve` — Web server PHP
2. `php artisan queue:listen` — Antrean pekerjaan background
3. `php artisan pail` — Real-time log viewer
4. `npm run dev` — Vite dev server dengan hot-reload

---

## ⌨️ Perintah CLI Penting

### Artisan Commands

```bash
# =================================================================
# DATABASE
# =================================================================

# Menjalankan semua migration (membuat tabel)
php artisan migrate

# Rollback semua migration, lalu jalankan ulang (HAPUS semua data!)
php artisan migrate:fresh

# Rollback + migration ulang + seeder (reset total)
php artisan migrate:fresh --seed

# Rollback 1 langkah migration
php artisan migrate:rollback

# Melihat status migration
php artisan migrate:status

# Menjalankan seeder
php artisan db:seed
php artisan db:seed --class=UserSeeder      # seeder spesifik

# =================================================================
# FILAMENT
# =================================================================

# Upgrade Filament (jalankan setelah update)
php artisan filament:upgrade

# Buat Resource Filament baru
php artisan make:filament-resource NamaModel --generate

# Buat Widget baru
php artisan make:filament-widget NamaWidget --stats-overview
php artisan make:filament-widget NamaWidget --table

# =================================================================
# CACHE & OPTIMASI
# =================================================================

# Bersihkan semua cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Bersihkan semuanya sekaligus
php artisan optimize:clear

# Cache untuk production (percepat loading)
php artisan optimize

# =================================================================
# DEBUG & DEVELOPMENT
# =================================================================

# Buka sesi interaktif Tinker (REPL)
php artisan tinker

# Lihat semua route yang terdaftar
php artisan route:list

# Jalankan testing
php artisan test

# Lihat semua model yang ada
php artisan model:show Asset

# Buat Observer baru
php artisan make:observer NamaObserver --model=NamaModel
```

### Composer Commands

```bash
# Install semua dependency
composer install

# Update dependency ke versi terbaru (sesuai constraint)
composer update

# Autoload ulang (setelah tambah class baru)
composer dump-autoload

# Jalankan setup lengkap
composer run setup

# Jalankan mode development
composer run dev

# Jalankan testing
composer run test

# Format kode dengan Pint (PSR-12)
./vendor/bin/pint
```

### npm Commands

```bash
# Install node modules
npm install

# Build untuk production
npm run build

# Dev server dengan hot-reload
npm run dev
```

---

## 🗄️ Struktur Database

### Diagram Relasi Entitas (ERD)

```
┌─────────────────────────────────────────────────────────────────┐
│                           users                                  │
│  PK id (bigint, auto_increment)                                  │
│     name (varchar 255, NOT NULL)                                 │
│     email (varchar 255, UNIQUE, NOT NULL)                        │
│     email_verified_at (timestamp, nullable)                      │
│     password (varchar 255, NOT NULL)                             │
│     role (enum: 'pimpinan'|'admin', NOT NULL)                    │
│     remember_token (varchar 100, nullable)                       │
│     created_at / updated_at (timestamps)                         │
└────────────────────────────┬────────────────────────────────────┘
                             │ created_by FK (1:N)
              ┌──────────────┴──────────────┐
              │                             │
┌─────────────▼──────────┐   ┌─────────────▼──────────┐
│       asset_ins         │   │       asset_outs        │
│  PK id                  │   │  PK id                  │
│  FK asset_id ───────────┤   │  FK asset_id ───────────┤
│  FK created_by          │   │  FK created_by          │
│     qty (uint)          │   │     qty (uint)          │
│     date (date)         │   │     date (date)         │
│     supplier (varchar)  │   │     recipient (varchar) │
│     notes (text)        │   │     notes (text)        │
│     timestamps          │   │     timestamps          │
└─────────────┬──────────┘   └─────────────┬──────────┘
              │                             │
              │ asset_in_id FK              │ asset_out_id FK
              │                             │
┌─────────────▼─────────────────────────────▼──────────────────┐
│                    asset_serial_numbers                        │
│  PK id (bigint, auto_increment)                               │
│  FK asset_id → assets.id (CASCADE DELETE)                     │
│  FK asset_in_id → asset_ins.id (SET NULL on delete)          │
│  FK asset_out_id → asset_outs.id (SET NULL on delete)        │
│     serial_number (varchar 255, NOT NULL)                     │
│     status (enum: 'in'|'out', DEFAULT 'in')                  │
│     UNIQUE INDEX (asset_id, serial_number)                   │
│     timestamps                                                │
└───────────────────────────────────────────────────────────────┘
              ▲                 ▲                ▲
              │                 │                │
              │ (HasMany)       │ (HasMany)      │ (HasMany)
              │                 │                │
┌─────────────┴─────────────────┴────────────────┴──────────────┐
│                           assets                               │
│  PK id (bigint, auto_increment)                               │
│     code (varchar 50, UNIQUE, NOT NULL) — Kode aset unik      │
│     name (varchar 255, NOT NULL) — Nama aset                  │
│     category (varchar 255, nullable) — Kategori               │
│     unit (varchar 255, DEFAULT 'unit') — Satuan               │
│     has_serial_number (boolean, DEFAULT false)                │
│     qty (uint, DEFAULT 0) — Stok otomatis (dikelola Observer) │
│     description (text, nullable)                              │
│     timestamps                                                │
└───────────────────────────────────────────────────────────────┘
```

---

### Detail Tabel

#### 1. Tabel `users`

Menyimpan akun pengguna yang dapat login ke sistem admin.

| Kolom               | Tipe            | Constraint             | Keterangan                               |
| ------------------- | --------------- | ---------------------- | ---------------------------------------- |
| `id`                | bigint unsigned | **PK**, AUTO_INCREMENT | Identifier unik user                     |
| `name`              | varchar(255)    | NOT NULL               | Nama lengkap user                        |
| `email`             | varchar(255)    | NOT NULL, **UNIQUE**   | Email login (digunakan sebagai username) |
| `email_verified_at` | timestamp       | nullable               | Waktu verifikasi email                   |
| `password`          | varchar(255)    | NOT NULL               | Password di-hash dengan bcrypt           |
| `role`              | varchar(255)    | NOT NULL               | Role user: `pimpinan` atau `admin`       |
| `remember_token`    | varchar(100)    | nullable               | Token untuk fitur "remember me"          |
| `created_at`        | timestamp       | nullable               | Waktu dibuat                             |
| `updated_at`        | timestamp       | nullable               | Waktu diperbarui terakhir                |

**Index:**

- `PRIMARY KEY (id)`
- `UNIQUE INDEX (email)`

---

#### 2. Tabel `assets`

Master data seluruh aset yang dimiliki organisasi.

| Kolom               | Tipe            | Constraint                 | Keterangan                                          |
| ------------------- | --------------- | -------------------------- | --------------------------------------------------- |
| `id`                | bigint unsigned | **PK**, AUTO_INCREMENT     | Identifier unik aset                                |
| `code`              | varchar(50)     | NOT NULL, **UNIQUE**       | Kode aset unik (misal: `AST-001`)                   |
| `name`              | varchar(255)    | NOT NULL                   | Nama aset (misal: `Laptop Dell Inspiron`)           |
| `category`          | varchar(255)    | nullable                   | Kategori aset (misal: `Elektronik`, `Furnitur`)     |
| `unit`              | varchar(255)    | NOT NULL, DEFAULT `'unit'` | Satuan (misal: `unit`, `pcs`, `buah`)               |
| `has_serial_number` | tinyint(1)      | NOT NULL, DEFAULT `0`      | `true` = aset ini memerlukan Serial Number per unit |
| `qty`               | int unsigned    | NOT NULL, DEFAULT `0`      | Stok saat ini — dikelola otomatis oleh Observer     |
| `description`       | text            | nullable                   | Keterangan tambahan aset                            |
| `created_at`        | timestamp       | nullable                   | Waktu dibuat                                        |
| `updated_at`        | timestamp       | nullable                   | Waktu diperbarui terakhir                           |

**Index:**

- `PRIMARY KEY (id)`
- `UNIQUE INDEX (code)`

**Catatan Penting:** Kolom `qty` bersifat **read-only dari UI**. Nilainya dikelola sepenuhnya oleh `AssetInObserver` dan `AssetOutObserver` secara otomatis setiap kali ada transaksi masuk atau keluar.

---

#### 3. Tabel `asset_ins`

Mencatat setiap transaksi penerimaan/masuknya aset.

| Kolom        | Tipe            | Constraint                                      | Keterangan                    |
| ------------ | --------------- | ----------------------------------------------- | ----------------------------- |
| `id`         | bigint unsigned | **PK**, AUTO_INCREMENT                          | Identifier transaksi masuk    |
| `asset_id`   | bigint unsigned | NOT NULL, **FK** → `assets.id` (CASCADE DELETE) | Aset yang diterima            |
| `qty`        | int unsigned    | NOT NULL                                        | Jumlah unit yang diterima     |
| `date`       | date            | NOT NULL                                        | Tanggal penerimaan            |
| `supplier`   | varchar(255)    | nullable                                        | Nama supplier/sumber aset     |
| `notes`      | text            | nullable                                        | Catatan tambahan              |
| `created_by` | bigint unsigned | NOT NULL, **FK** → `users.id`                   | User yang menginput transaksi |
| `created_at` | timestamp       | nullable                                        | Waktu record dibuat           |
| `updated_at` | timestamp       | nullable                                        | Waktu record diperbarui       |

**Index:**

- `PRIMARY KEY (id)`
- `INDEX (asset_id)` — otomatis dari `foreignId()`
- `INDEX (created_by)` — otomatis dari `foreignId()`

**Foreign Key Behavior:**

- `asset_id` → `CASCADE DELETE`: Jika aset induk dihapus, semua record transaksi masuknya ikut terhapus
- `created_by` → `RESTRICT`: Tidak bisa hapus user jika masih ada transaksi yang ia buat

---

#### 4. Tabel `asset_outs`

Mencatat setiap transaksi distribusi/keluarnya aset.

| Kolom        | Tipe            | Constraint                                      | Keterangan                            |
| ------------ | --------------- | ----------------------------------------------- | ------------------------------------- |
| `id`         | bigint unsigned | **PK**, AUTO_INCREMENT                          | Identifier transaksi keluar           |
| `asset_id`   | bigint unsigned | NOT NULL, **FK** → `assets.id` (CASCADE DELETE) | Aset yang dikeluarkan                 |
| `qty`        | int unsigned    | NOT NULL                                        | Jumlah unit yang dikeluarkan          |
| `date`       | date            | NOT NULL                                        | Tanggal pengeluaran                   |
| `recipient`  | varchar(255)    | nullable                                        | Penerima atau tujuan pengeluaran aset |
| `notes`      | text            | nullable                                        | Catatan tambahan                      |
| `created_by` | bigint unsigned | NOT NULL, **FK** → `users.id`                   | User yang menginput transaksi         |
| `created_at` | timestamp       | nullable                                        | Waktu record dibuat                   |
| `updated_at` | timestamp       | nullable                                        | Waktu record diperbarui               |

**Index:**

- `PRIMARY KEY (id)`
- `INDEX (asset_id)` — otomatis dari `foreignId()`
- `INDEX (created_by)` — otomatis dari `foreignId()`

**Foreign Key Behavior:**

- `asset_id` → `CASCADE DELETE`: Jika aset induk dihapus, semua record transaksi keluarnya ikut terhapus

---

#### 5. Tabel `asset_serial_numbers`

Melacak setiap unit individual dari aset yang memiliki Serial Number.

| Kolom           | Tipe             | Constraint                                      | Keterangan                                      |
| --------------- | ---------------- | ----------------------------------------------- | ----------------------------------------------- |
| `id`            | bigint unsigned  | **PK**, AUTO_INCREMENT                          | Identifier SN                                   |
| `asset_id`      | bigint unsigned  | NOT NULL, **FK** → `assets.id` (CASCADE DELETE) | Aset pemilik SN ini                             |
| `serial_number` | varchar(255)     | NOT NULL                                        | Nomor seri unit (misal: `SN-ABC-001`)           |
| `status`        | enum('in','out') | NOT NULL, DEFAULT `'in'`                        | `in` = tersedia di gudang, `out` = sudah keluar |
| `asset_in_id`   | bigint unsigned  | nullable, **FK** → `asset_ins.id` (SET NULL)    | Transaksi masuk saat SN ini diterima            |
| `asset_out_id`  | bigint unsigned  | nullable, **FK** → `asset_outs.id` (SET NULL)   | Transaksi keluar saat SN ini dikeluarkan        |
| `created_at`    | timestamp        | nullable                                        | Waktu dibuat                                    |
| `updated_at`    | timestamp        | nullable                                        | Waktu diperbarui                                |

**Index:**

- `PRIMARY KEY (id)`
- `UNIQUE INDEX (asset_id, serial_number)` — **Mencegah duplikasi SN dalam satu jenis aset yang sama**
- `INDEX (asset_in_id)` — otomatis dari `foreignId()`
- `INDEX (asset_out_id)` — otomatis dari `foreignId()`

**Foreign Key Behavior:**

- `asset_id` → `CASCADE DELETE`: SN ikut terhapus jika aset dihapus
- `asset_in_id` → `SET NULL`: Jika transaksi masuk terhapus, kolom ini menjadi NULL
- `asset_out_id` → `SET NULL`: Jika transaksi keluar terhapus, kolom ini menjadi NULL dan status SN dikembalikan ke `'in'`

---

#### Tabel Pendukung Laravel

| Tabel                                  | Fungsi                               |
| -------------------------------------- | ------------------------------------ |
| `sessions`                             | Menyimpan data sesi login pengguna   |
| `cache`                                | Penyimpanan cache aplikasi           |
| `jobs` / `job_batches` / `failed_jobs` | Antrian pekerjaan background (Queue) |
| `password_reset_tokens`                | Token reset password                 |

---

## 🏗️ Arsitektur & Penjelasan Class

### Struktur Direktori Utama

```
sistem-aset-kp/
├── app/
│   ├── Filament/
│   │   ├── Resources/              # CRUD Resource (Filament)
│   │   │   ├── AssetResource.php
│   │   │   ├── AssetInResource.php
│   │   │   ├── AssetOutResource.php
│   │   │   └── UserResource.php
│   │   └── Widgets/               # Widget Dashboard
│   │       ├── StatsOverviewWidget.php
│   │       ├── AssetStokKritisWidget.php
│   │       ├── AssetMasukChartWidget.php
│   │       └── AssetKeluarChartWidget.php
│   ├── Models/                    # Eloquent Models (ORM)
│   │   ├── Asset.php
│   │   ├── AssetIn.php
│   │   ├── AssetOut.php
│   │   ├── AssetSerialNumber.php
│   │   └── User.php
│   ├── Observers/                 # Business Logic Otomatis
│   │   ├── AssetInObserver.php
│   │   └── AssetOutObserver.php
│   └── Providers/
│       └── AppServiceProvider.php  # Registrasi Observer
├── database/
│   ├── migrations/                # Schema database
│   ├── seeders/                   # Data awal
│   └── database.sqlite            # File SQLite
├── resources/
│   └── views/
│       └── laporan/               # Template laporan PDF
│           ├── asset.blade.php
│           ├── asset-in.blade.php
│           └── asset-out.blade.php
└── routes/
    └── web.php                    # Route laporan PDF
```

---

### 📁 Models (Eloquent ORM)

#### `Asset.php` — Model Aset

Model utama yang merepresentasikan satu jenis aset dalam sistem.

```
Kelas  : App\Models\Asset
Tabel  : assets
Extends: Illuminate\Database\Eloquent\Model
```

| Method/Property            | Jenis    | Penjelasan                                                                                                                         |
| -------------------------- | -------- | ---------------------------------------------------------------------------------------------------------------------------------- |
| `$fillable`                | Property | Daftar kolom yang boleh diisi via mass assignment: `code`, `name`, `category`, `unit`, `has_serial_number`, `qty`, `description`   |
| `$casts`                   | Property | `has_serial_number` di-cast ke tipe `boolean` agar nilai 0/1 dari DB otomatis menjadi true/false di PHP                            |
| `ins()`                    | Relation | **HasMany** ke `AssetIn` — mengambil semua transaksi masuk untuk aset ini                                                          |
| `outs()`                   | Relation | **HasMany** ke `AssetOut` — mengambil semua transaksi keluar untuk aset ini                                                        |
| `serialNumbers()`          | Relation | **HasMany** ke `AssetSerialNumber` — semua Serial Number yang dimiliki aset ini                                                    |
| `availableSerialNumbers()` | Method   | Scoped query dari `serialNumbers()` yang hanya mengembalikan SN dengan `status = 'in'` (tersedia) — berguna saat input aset keluar |

---

#### `AssetIn.php` — Model Transaksi Masuk

Merepresentasikan satu transaksi penerimaan aset.

```
Kelas  : App\Models\AssetIn
Tabel  : asset_ins
Extends: Illuminate\Database\Eloquent\Model
```

| Method/Property   | Jenis    | Penjelasan                                                                                          |
| ----------------- | -------- | --------------------------------------------------------------------------------------------------- |
| `$fillable`       | Property | `asset_id`, `qty`, `date`, `supplier`, `notes`, `created_by`                                        |
| `$casts`          | Property | `date` di-cast ke tipe `date` — memastikan kolom date selalu menjadi objek Carbon                   |
| `asset()`         | Relation | **BelongsTo** ke `Asset` — mengambil data aset induk transaksi ini                                  |
| `creator()`       | Relation | **BelongsTo** ke `User` menggunakan FK `created_by` — mengambil data user yang menginput            |
| `serialNumbers()` | Relation | **HasMany** ke `AssetSerialNumber` menggunakan FK `asset_in_id` — SN yang masuk dalam transaksi ini |

---

#### `AssetOut.php` — Model Transaksi Keluar

Merepresentasikan satu transaksi pengeluaran/distribusi aset.

```
Kelas  : App\Models\AssetOut
Tabel  : asset_outs
Extends: Illuminate\Database\Eloquent\Model
```

| Method/Property   | Jenis    | Penjelasan                                                                                    |
| ----------------- | -------- | --------------------------------------------------------------------------------------------- |
| `$fillable`       | Property | `asset_id`, `qty`, `date`, `recipient`, `notes`, `created_by`                                 |
| `$casts`          | Property | `date` di-cast ke tipe `date`                                                                 |
| `asset()`         | Relation | **BelongsTo** ke `Asset` — aset yang dikeluarkan                                              |
| `creator()`       | Relation | **BelongsTo** ke `User` via FK `created_by` — user yang menginput                             |
| `serialNumbers()` | Relation | **HasMany** ke `AssetSerialNumber` via FK `asset_out_id` — SN yang keluar dalam transaksi ini |

---

#### `AssetSerialNumber.php` — Model Serial Number

Melacak satu unit individual aset dengan nomor seri.

```
Kelas  : App\Models\AssetSerialNumber
Tabel  : asset_serial_numbers
Extends: Illuminate\Database\Eloquent\Model
```

| Method/Property | Jenis    | Penjelasan                                                             |
| --------------- | -------- | ---------------------------------------------------------------------- |
| `$fillable`     | Property | `asset_id`, `serial_number`, `status`, `asset_in_id`, `asset_out_id`   |
| `asset()`       | Relation | **BelongsTo** ke `Asset` — aset pemilik SN ini                         |
| `assetIn()`     | Relation | **BelongsTo** ke `AssetIn` — transaksi masuk saat SN diterima          |
| `assetOut()`    | Relation | **BelongsTo** ke `AssetOut` — transaksi keluar saat SN didistribusikan |

---

#### `User.php` — Model Pengguna

Merepresentasikan akun yang dapat mengakses panel admin.

```
Kelas  : App\Models\User
Tabel  : users
Extends: Illuminate\Foundation\Auth\User (Authenticatable)
Implements: Filament\Models\Contracts\FilamentUser
```

| Method/Property                | Jenis    | Penjelasan                                                                                                                   |
| ------------------------------ | -------- | ---------------------------------------------------------------------------------------------------------------------------- |
| `$fillable`                    | Property | `name`, `email`, `password`, `role`                                                                                          |
| `$hidden`                      | Property | `password`, `remember_token` — tidak ikut di-serialize ke JSON                                                               |
| `isPimpinan()`                 | Method   | Mengembalikan `true` jika role user adalah `'pimpinan'` — digunakan untuk conditional UI                                     |
| `canAccessPanel(Panel $panel)` | Method   | **Interface Filament** — menentukan apakah user boleh login ke panel. Saat ini mengembalikan `true` (kedua role boleh login) |

---

### 👁️ Observers (Business Logic Otomatis)

Observer adalah class yang "mendengarkan" event pada Eloquent Model dan menjalankan logika bisnis secara otomatis. Observer menerapkan pola **Separation of Concerns** sehingga bisnis logik tidak tercampur di controller.

#### `AssetInObserver.php`

Dipanggil otomatis setiap ada perubahan pada record `AssetIn`.

| Method                       | Event          | Penjelasan                                                                                                                                                                             |
| ---------------------------- | -------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `created(AssetIn $assetIn)`  | Setelah INSERT | Menambah stok aset (`assets.qty`) sebesar `qty` yang baru masuk menggunakan `increment()`                                                                                              |
| `updated(AssetIn $assetIn)`  | Setelah UPDATE | Menghitung delta (`qty baru - qty lama`), lalu menerapkan selisih tersebut ke stok aset. Ini memastikan edit transaksi langsung mempengaruhi stok                                      |
| `deleting(AssetIn $assetIn)` | Sebelum DELETE | **Validasi keamanan**: Jika ada SN dari transaksi ini yang sudah keluar (`status = 'out'`), penghapusan ditolak dengan `ValidationException`. Jika aman, stok dikurangi dan SN dihapus |

#### `AssetOutObserver.php`

Dipanggil otomatis setiap ada perubahan pada record `AssetOut`.

| Method                         | Event          | Penjelasan                                                                                                                                                  |
| ------------------------------ | -------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `created(AssetOut $assetOut)`  | Setelah INSERT | Mengurangi stok aset (`assets.qty`) sebesar `qty` yang keluar menggunakan `decrement()`                                                                     |
| `updated(AssetOut $assetOut)`  | Setelah UPDATE | Menghitung delta dan menerapkan perubahan ke stok. Jika qty keluar bertambah, stok berkurang lebih banyak; jika berkurang, stok kembali                     |
| `deleting(AssetOut $assetOut)` | Sebelum DELETE | Mengembalikan stok sebesar `qty` transaksi keluar ini, dan mengubah status semua SN yang terkait kembali menjadi `'in'` dan mengosongkan `asset_out_id`-nya |

---

### 🏢 Filament Resources

Resource adalah class Filament yang mendefinisikan lengkap bagaimana sebuah Model ditampilkan dan dikelola: form input, tabel list, filter, aksi, dan halaman-halaman CRUD-nya.

#### `AssetResource.php` — Manajemen Daftar Aset

```
URL Panel : /admin/daftar-aset
Model     : Asset
Nav Label : Daftar Aset
Nav Sort  : 1
Nav Icon  : heroicon-o-archive-box
```

| Method Statis                  | Penjelasan                                                                                                                       |
| ------------------------------ | -------------------------------------------------------------------------------------------------------------------------------- |
| `form(Form $form)`             | Mendefinisikan form input: Kode Aset (unik), Nama, Kategori, Satuan, Toggle Serial Number, Qty (disabled/read-only), Deskripsi   |
| `table(Table $table)`          | Mendefinisikan tabel list dengan kolom: Kode, Nama, Kategori, SN?, Stok (badge warna), Satuan, Update Terakhir                   |
| `infolist(Infolist $infolist)` | Tampilan detail view aset, termasuk section "Daftar Serial Number" yang muncul kondisional hanya jika `has_serial_number = true` |
| `getPages()`                   | Mendaftarkan 4 halaman: `index`, `create`, `edit`, `view`                                                                        |
| `canDelete($record)`           | Hanya role `pimpinan` yang boleh menghapus aset                                                                                  |

**Filter yang tersedia:**

- Filter Kategori (`SelectFilter`) — dropdown kategori yang ada di database
- Filter Serial Number (`TernaryFilter`) — Punya SN / Tanpa SN / Semua
- Filter Kondisi Stok (`SelectFilter`) — Tersedia (qty > 0) / Habis (qty = 0)

---

#### `AssetInResource.php` — Manajemen Aset Masuk

```
URL Panel : /admin/aset-masuk
Model     : AssetIn
Nav Label : Aset Masuk
Nav Sort  : 2
Nav Icon  : heroicon-o-arrow-down-tray
```

| Method Statis                   | Penjelasan                                                                                                                                            |
| ------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------- |
| `form(Form $form)`              | Form input dengan Select Aset (searchable + bisa buat aset baru inline), Tanggal, Supplier, Qty, Repeater Serial Number (muncul kondisional), Catatan |
| `table(Table $table)`           | Tabel list: Tanggal, Kode Aset, Nama Aset, Qty (badge hijau), Supplier, Diinput oleh                                                                  |
| `infolist(Infolist $infolist)`  | Detail view transaksi masuk + section "Serial Number yang Masuk" dengan status per SN                                                                 |
| `assetHasSerial(?int $assetId)` | Method protected — mengecek apakah aset yang dipilih memiliki SN. Digunakan untuk kondisi tampil/sembunyikan form SN dan mengunci field qty           |
| `canDelete($record)`            | Hanya `pimpinan` bisa hapus. Observer `AssetInObserver::deleting()` akan memvalidasi sebelum eksekusi                                                 |

**Fitur Khusus Form:**

- Jika aset memiliki `has_serial_number = true`, field Qty **otomatis dikunci** dan mengikuti jumlah SN yang diinput via Repeater
- Form Select Aset dilengkapi tombol **"Tambah Aset Baru"** yang membuka modal form inline tanpa perlu navigasi ke halaman lain
- Aset tidak bisa diganti saat **edit** (disabled setelah tersimpan)

**Filter yang tersedia:**

- Filter Rentang Tanggal (`date_from` s/d `date_to`)
- Filter Aset (dropdown relasi)
- Filter Supplier (dropdown nilai yang ada di DB)

---

#### `AssetOutResource.php` — Manajemen Aset Keluar

```
URL Panel : /admin/aset-keluar
Model     : AssetOut
Nav Label : Aset Keluar
Nav Sort  : 3
Nav Icon  : heroicon-o-arrow-up-tray
```

| Method Statis                   | Penjelasan                                                                                                                                                      |
| ------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `form(Form $form)`              | Form dengan Select Aset (menampilkan stok saat ini di label), Tanggal, Penerima, Multi-select SN (hanya SN berstatus 'in'), Qty (terkunci jika ber-SN), Catatan |
| `table(Table $table)`           | Tabel list: Tanggal, Kode Aset, Nama Aset, Qty (badge merah), Penerima, Diinput oleh                                                                            |
| `infolist(Infolist $infolist)`  | Detail view transaksi keluar + section "Serial Number yang Keluar"                                                                                              |
| `assetHasSerial(?int $assetId)` | Sama seperti di AssetInResource — mengecek keberadaan SN                                                                                                        |
| `canDelete($record)`            | Hanya `pimpinan` bisa hapus. Penghapusan otomatis memulihkan stok dan SN via Observer                                                                           |

**Fitur Khusus Form:**

- Dropdown pilih SN hanya menampilkan SN yang **tersedia** (`status = 'in'`)
- Qty otomatis mengikuti jumlah SN yang dipilih dari multi-select
- Label dropdown aset menampilkan **stok tersisa** secara real-time: `AST-001 — Laptop Dell (stok: 5)`

---

#### `UserResource.php` — Manajemen Pengguna

```
URL Panel : /admin/users
Model     : User
Nav Label : Kelola User
Nav Sort  : 4
Nav Icon  : heroicon-o-users
```

| Method Statis                | Penjelasan                                                                                                 |
| ---------------------------- | ---------------------------------------------------------------------------------------------------------- |
| `shouldRegisterNavigation()` | Menu hanya **terlihat** di navigasi sidebar jika user yang login adalah `pimpinan`                         |
| `canViewAny()`               | Hanya `pimpinan` yang bisa mengakses halaman list user                                                     |
| `canCreate()`                | Hanya `pimpinan` yang bisa membuat user baru                                                               |
| `canEdit($record)`           | Hanya `pimpinan` yang bisa mengedit user                                                                   |
| `canDelete($record)`         | Hanya `pimpinan` yang bisa menghapus user                                                                  |
| `form(Form $form)`           | Form dengan Nama, Email, Role (dropdown: pimpinan/admin), Password (wajib saat create, opsional saat edit) |
| `table(Table $table)`        | Tabel: Nama, Email, Role (badge), Tanggal Dibuat                                                           |

---

### 📊 Widgets Dashboard

Widget adalah komponen yang ditampilkan di halaman utama (Dashboard) Filament.

#### `StatsOverviewWidget.php` — Kartu Statistik Ringkasan

Menampilkan 4 kartu statistik utama:

| Kartu                 | Data yang Ditampilkan                                            | Sumber Data              |
| --------------------- | ---------------------------------------------------------------- | ------------------------ |
| Total Jenis Aset      | Jumlah baris di tabel `assets`                                   | `Asset::count()`         |
| Total Stok            | Jumlah semua `qty` di tabel `assets`                             | `Asset::sum('qty')`      |
| Aset Masuk Bulan Ini  | Total `qty` dari transaksi masuk bulan berjalan + grafik 7 hari  | `AssetIn::whereMonth()`  |
| Aset Keluar Bulan Ini | Total `qty` dari transaksi keluar bulan berjalan + grafik 7 hari | `AssetOut::whereMonth()` |

Kartu Total Stok akan berwarna **warning** (kuning) jika ada aset dengan stok 0.

#### `AssetStokKritisWidget.php` — Tabel Aset Stok Habis

- Hanya muncul (`canView()`) jika **ada** aset dengan `qty = 0`
- Menampilkan tabel berisi semua aset stok = 0, diurutkan berdasarkan nama
- Setiap baris memiliki tombol **"Lihat"** untuk navigasi ke halaman detail aset

#### `AssetMasukChartWidget.php` & `AssetKeluarChartWidget.php`

Menampilkan grafik batang tren transaksi aset masuk dan keluar dalam 30 hari terakhir.

---

## 🔄 Alur Penggunaan Sistem

### 1. Login ke Panel Admin

1. Buka browser, akses **http://localhost:8000/admin**
2. Masukkan email dan password
3. Sistem akan mengarahkan ke **Dashboard**

### 2. Dashboard

Setelah login, Anda akan melihat:

- **Kartu statistik**: Total jenis aset, total stok, aset masuk/keluar bulan ini
- **Widget aset stok habis** (jika ada aset dengan stok = 0)
- **Grafik tren** transaksi 30 hari terakhir

### 3. Menambah Aset Baru

1. Klik menu **"Daftar Aset"** di sidebar
2. Klik tombol **"Tambah"**
3. Isi formulir:
    - **Kode Aset** — harus unik (misal: `LP-001`)
    - **Nama Aset** — (misal: `Laptop Dell Inspiron 15`)
    - **Kategori** — opsional (misal: `Elektronik`)
    - **Satuan** — (misal: `unit`)
    - **Aset ini memiliki Serial Number?** — Aktifkan jika setiap unit harus dilacak individual dengan SN
    - **Stok** — disabled/read-only, terisi otomatis
    - **Keterangan** — opsional
4. Klik **"Simpan"**

> ⚠️ Toggle "memiliki Serial Number" **tidak bisa diubah** setelah aset tersimpan untuk menjaga konsistensi data.

### 4. Mencatat Aset Masuk

1. Klik menu **"Aset Masuk"**
2. Klik tombol **"Tambah"**
3. Isi formulir:
    - Pilih **Aset** dari dropdown (bisa dicari, bisa buat aset baru langsung dari sini)
    - Isi **Tanggal Masuk**
    - Isi **Supplier** (opsional)
    - Isi **Jumlah Masuk** (untuk aset tanpa SN)
    - Jika aset ber-SN: section **Serial Number** muncul, isi nomor seri setiap unit
    - Qty otomatis mengikuti jumlah SN yang diinput
4. Klik **"Simpan"**

**Yang terjadi di balik layar:**

- `AssetInObserver::created()` dipanggil otomatis
- Stok aset di tabel `assets` bertambah sebesar qty
- Jika ada SN, setiap SN disimpan dengan `status = 'in'`

### 5. Mencatat Aset Keluar

1. Klik menu **"Aset Keluar"**
2. Klik tombol **"Tambah"**
3. Isi formulir:
    - Pilih **Aset** (label menampilkan stok tersisa)
    - Isi **Tanggal Keluar**
    - Isi **Penerima/Tujuan** (opsional)
    - Untuk aset ber-SN: pilih SN dari multi-select (hanya SN tersedia yang muncul)
    - Isi **Jumlah Keluar** (untuk aset tanpa SN, pastikan tidak melebihi stok!)
4. Klik **"Simpan"**

**Yang terjadi di balik layar:**

- `AssetOutObserver::created()` dipanggil otomatis
- Stok aset berkurang sebesar qty
- SN yang dipilih statusnya berubah dari `'in'` ke `'out'`

### 6. Melihat Detail & Filter

- Klik ikon **"Lihat"** pada baris manapun untuk melihat detail lengkap
- Gunakan **filter di atas tabel** untuk menyaring data:
    - Daftar Aset: filter Kategori, ada/tidaknya SN, kondisi stok
    - Aset Masuk: filter Rentang Tanggal, filter Aset, filter Supplier
    - Aset Keluar: filter Rentang Tanggal, filter Aset, filter Penerima

### 7. Mencetak Laporan

1. Atur filter sesuai kebutuhan (misal: pilih rentang tanggal tertentu)
2. Klik tombol **"Cetak Laporan"** di pojok kanan atas tabel
3. Tab baru terbuka dengan tampilan laporan PDF-ready
4. Gunakan **Ctrl+P** (browser print) untuk mencetak atau save sebagai PDF

> Laporan akan mencerminkan **filter aktif** yang sedang diterapkan.

### 8. Manajemen User (Pimpinan Only)

1. Login sebagai `pimpinan`
2. Menu **"Kelola User"** akan muncul di sidebar
3. Tambah user baru: isi Nama, Email, Role, Password
4. Edit user: semua field bisa diubah (password opsional)
5. Hapus user yang tidak diperlukan

---

## 👥 Manajemen Role & Hak Akses

Sistem memiliki **2 role** yang dikontrol melalui kolom `role` di tabel `users`.

| Aksi/Fitur                | Admin | Pimpinan |
| ------------------------- | ----- | -------- |
| Login ke panel            | ✅    | ✅       |
| Lihat Dashboard           | ✅    | ✅       |
| Lihat Daftar Aset         | ✅    | ✅       |
| Tambah Aset               | ✅    | ✅       |
| Edit Aset                 | ✅    | ✅       |
| **Hapus Aset**            | ❌    | ✅       |
| Lihat Aset Masuk          | ✅    | ✅       |
| Tambah Aset Masuk         | ✅    | ✅       |
| Edit Aset Masuk           | ✅    | ✅       |
| **Hapus Aset Masuk**      | ❌    | ✅       |
| Lihat Aset Keluar         | ✅    | ✅       |
| Tambah Aset Keluar        | ✅    | ✅       |
| Edit Aset Keluar          | ✅    | ✅       |
| **Hapus Aset Keluar**     | ❌    | ✅       |
| Lihat halaman Kelola User | ❌    | ✅       |
| Tambah User               | ❌    | ✅       |
| Edit User                 | ❌    | ✅       |
| Hapus User                | ❌    | ✅       |
| Cetak Laporan             | ✅    | ✅       |

---

## 📄 Modul Laporan

Sistem menyediakan 3 jenis laporan yang dapat dicetak langsung dari browser.

### Cara Kerja Laporan

1. Saat tombol "Cetak Laporan" ditekan, sistem membaca **filter yang sedang aktif** dari Filament Livewire component
2. Filter tersebut dikirimkan sebagai query parameter ke route laporan
3. Route di `routes/web.php` memproses parameter, menjalankan query ke database, lalu me-render Blade template
4. Browser menampilkan halaman laporan yang siap dicetak (dengan CSS `@media print`)

### Jenis Laporan

| Laporan                 | Route                      | Filter yang Didukung                                     |
| ----------------------- | -------------------------- | -------------------------------------------------------- |
| **Laporan Daftar Aset** | `GET /laporan/aset`        | `category`, `has_serial_number`, `stok` (tersedia/habis) |
| **Laporan Aset Masuk**  | `GET /laporan/aset-masuk`  | `date_from`, `date_to`, `asset_id`, `supplier`           |
| **Laporan Aset Keluar** | `GET /laporan/aset-keluar` | `date_from`, `date_to`, `asset_id`, `recipient`          |

Semua route laporan dilindungi middleware `auth` — hanya user yang sudah login yang bisa mengaksesnya.

---

## ❓ Pertanyaan & Jawaban Seminar KP

### Q: Apa fungsi utama sistem ini?

**A:** Sistem ini adalah **Sistem Manajemen Aset** yang membantu organisasi mencatat dan memantau inventaris asetnya. Sistem mengelola tiga hal utama: (1) master data aset, (2) transaksi penerimaan aset masuk, dan (3) transaksi pengeluaran/distribusi aset keluar. Stok aset selalu ter-update secara otomatis setiap ada transaksi.

---

### Q: Mengapa menggunakan Filament, bukan membangun CRUD manual?

**A:** Filament adalah admin panel builder untuk Laravel yang sangat produktif. Dengan Filament, kita dapat mendefinisikan form, tabel, filter, dan akses kontrol hanya dengan kode PHP (tanpa menulis HTML/Blade manual untuk UI admin). Ini mempercepat pengembangan secara signifikan karena komponen seperti tabel yang bisa diurutkan, di-filter, diedit inline, sudah tersedia "out of the box". Panel Filament juga sudah responsif dan modern secara default.

---

### Q: Bagaimana sistem mengelola stok otomatis?

**A:** Sistem menggunakan pola **Observer** dari Laravel. `AssetInObserver` dan `AssetOutObserver` didaftarkan di `AppServiceProvider`. Setiap kali record `AssetIn` atau `AssetOut` dibuat, diperbarui, atau dihapus, Observer akan dipanggil secara otomatis untuk menghitung dan memperbarui kolom `qty` pada tabel `assets`. Dengan pendekatan ini, stok selalu akurat tanpa perlu kode tambahan di controller atau Resource.

---

### Q: Apa itu Serial Number dalam konteks sistem ini?

**A:** Serial Number (SN) adalah identifikasi unik per unit untuk aset tertentu. Misalnya, jika kita memiliki 10 unit laptop, masing-masing laptop memiliki SN yang berbeda. Fitur ini aktif per aset (toggle `has_serial_number`). Jika aktif, setiap transaksi masuk wajib mengisi SN untuk setiap unit yang diterima, dan setiap transaksi keluar harus memilih unit mana (SN mana) yang dikeluarkan. Ini memungkinkan pelacakan aset di level per-unit, bukan hanya kuantitas.

---

### Q: Bagaimana sistem mencegah stok menjadi negatif?

**A:** Ada dua mekanisme: (1) Pada form Aset Keluar, dropdown pilihan SN hanya menampilkan SN dengan status `'in'` (tersedia). (2) Field qty pada aset keluar memiliki validasi `minValue(1)` dan helper text yang mengingatkan operator untuk tidak melebihi stok. Untuk aset ber-SN, qty tidak bisa diisi manual — otomatis mengikuti jumlah SN yang dipilih, sehingga tidak mungkin melebihi SN yang tersedia.

---

### Q: Apa yang terjadi jika sebuah record Aset Masuk dihapus?

**A:** `AssetInObserver::deleting()` akan dipanggil sebelum penghapusan. Observer akan memeriksa apakah ada SN dari transaksi masuk ini yang sudah pernah keluar (status `'out'`). Jika iya, penghapusan **ditolak** dengan pesan error untuk menjaga integritas data. Jika tidak ada SN yang keluar, maka: stok aset dikurangi sebesar qty transaksi itu, dan semua SN yang terkait dihapus.

---

### Q: Bagaimana sistem menangani hak akses (role)?

**A:** Sistem memiliki dua role: `pimpinan` dan `admin`. Role disimpan di kolom `role` tabel `users`. Pembatasan akses diimplementasikan di setiap Resource Filament menggunakan method `canDelete()`, `canViewAny()`, `canCreate()`, `canEdit()`, dan `shouldRegisterNavigation()`. Method-method ini mengecek `auth()->user()->isPimpinan()` dari Model User. Dengan cara ini, `admin` tetap bisa mengelola data aset dan transaksi, tetapi **tidak bisa menghapus** data apapun dan **tidak bisa melihat** menu manajemen user.

---

### Q: Bagaimana laporan yang dihasilkan sudah sesuai dengan filter yang aktif?

**A:** Di Filament, setiap tabel adalah Livewire component. Saat tombol "Cetak Laporan" ditekan, sistem membaca state filter dari properti `$livewire->tableFilters`. Nilai-nilai filter ini kemudian dijadikan query parameter URL. Route laporan (`routes/web.php`) membaca parameter tersebut, membangun query Eloquent yang sesuai, dan mengirim hasilnya ke Blade template untuk ditampilkan.

---

### Q: Mengapa ada tabel `sessions` dan `cache`?

**A:** `sessions` digunakan oleh Laravel untuk menyimpan data sesi login pengguna di database (konfigurasi `SESSION_DRIVER=database` di `.env`). Ini lebih aman dan scalable dibandingkan menyimpan sesi di file. Tabel `cache` digunakan jika `CACHE_DRIVER=database`, menyimpan cache sementara untuk mengoptimalkan performa query yang berulang.

---

## 📁 Lisensi

Sistem ini dilisensikan di bawah [MIT License](LICENSE).

---

## 👤 Pengembang

Dikembangkan sebagai proyek **Kerja Praktek (KP)** oleh:

- **Repository:** [nyawijicode/sistem-aset-kp](https://github.com/nyawijicode/sistem-aset-kp)

---

_README ini dibuat secara komprehensif untuk keperluan presentasi Seminar Kerja Praktek. Seluruh penjelasan didasarkan pada kode aktual yang ada di repository._
