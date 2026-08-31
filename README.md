# Kantin Multi-Tenant

Aplikasi kantin multi-tenant berbasis **Laravel 13** + **Livewire 4**, dibangun sebagai bagian dari
Modul Praktikum Pemrograman Web Lanjut (14 pertemuan).

## Requirements

Pastikan tool berikut terpasang sebelum memulai:

| Tool | Versi minimum | Cek dengan |
|---|---|---|
| PHP | 8.3+ | `php -v` |
| Composer | terbaru | `composer --version` |
| Node.js / NPM | LTS terbaru | `node -v` / `npm -v` |
| Git | terbaru | `git --version` |
| MariaDB | 10.x | `mysql --version` atau via Docker |
| Redis | 7.x | `redis-cli --version` atau via Docker |

Ekstensi PHP wajib aktif: `pdo_mysql`, `mbstring`, `openssl`, `ctype`, `curl`, `fileinfo`, `xml`, `tokenizer`.

Port yang harus tersedia: `8000` (HTTP), `8080` (opsional), `3306` (MariaDB), `6379` (Redis).

## Setup

```bash
# 1. Clone repository
git clone <url-repo-anda> kantin-multi-tenant
cd kantin-multi-tenant

# 2. Salin file environment
cp .env.example .env
php artisan key:generate

# 3. Install dependency
composer install
npm install

# 4. Isi variabel DB_*, REDIS_*, SESSION_DRIVER, CACHE_STORE,
#    QUEUE_CONNECTION, BROADCAST_CONNECTION di .env
#    (lihat contoh di .env.example)

# 5. Jalankan layanan MariaDB & Redis
#    Opsi A - native: pastikan service MariaDB & Redis lokal aktif
#    Opsi B - Docker: docker compose up -d

# 6. Migrasi database (gunakan database kosong, bukan database berisi data penting)
php artisan migrate:fresh --seed

# 7. Build asset frontend
npm run build
```

## Run (mode pengembangan)

```bash
composer run dev
```

Perintah ini menjalankan HTTP server, queue worker, dan Vite (hot reload) sekaligus.
Jika Reverb belum otomatis tersertakan, jalankan di terminal terpisah:

```bash
php artisan reverb:start
```

Aplikasi dapat diakses di: **http://localhost:8000**

## Test & Quality Gate

```bash
php artisan test              # jalankan test suite (PHPUnit)
./vendor/bin/pint --test      # cek format kode (Pint)
npm run build                 # pastikan asset frontend berhasil dibangun
```

Semua perintah di atas harus keluar dengan exit code `0` sebelum commit.

## Verifikasi Koneksi

```bash
php artisan db:show           # cek koneksi MariaDB
redis-cli -p 6379 ping        # harus mengembalikan PONG
```

## Troubleshooting

| Gejala | Penyebab mungkin | Perbaikan |
|---|---|---|
| `could not find driver` | `pdo_mysql` belum aktif | Aktifkan ekstensi di `php.ini`, lalu restart PHP |
| Port 3306/6379 bentrok | Service lain masih aktif | Ganti port di `compose.yaml` dan `.env` |
| Halaman tanpa CSS/JS | Asset belum dibangun | Jalankan `npm install && npm run build` |
| `connection refused` | Service DB/Redis belum aktif | Cek `docker compose ps` atau service native |
| `access denied` (DB) | Credential salah | Cocokkan `DB_USERNAME`/`DB_PASSWORD` di `.env` |

## Catatan Arsitektur

- **MariaDB**: sumber kebenaran untuk data transaksional (tenant, order, payment, stok, ledger).
- **Redis**: session, cache, cart, dan queue — data berumur pendek/koordinasi cepat.
- Waktu transaksi disimpan dalam **UTC**, dikonversi ke `Asia/Jakarta` hanya pada lapisan presentasi.
- `.env` **tidak pernah** masuk Git; hanya `.env.example` (placeholder aman) yang dicommit.
- Kode aplikasi memanggil `config()`, bukan `env()` langsung, agar tetap valid setelah `config:cache`.

## Struktur Direktori Terkait