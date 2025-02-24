# DEMO FRONTEND: https://resident-fe.ziakode.com/ 
# DEMO BACKEND: https://resident-be.ziakode.com/
# REPO FRONTEND: https://github.com/azhrzf/resident-mnf
# REPO BACKEND: https://github.com/azhrzf/resident-mnb

# Panduan Instalasi Laravel API-Only

## Langkah Instalasi

### 1. Instal Dependensi

```bash
composer install
```

### 2. Konfigurasi Lingkungan

Salin file lingkungan contoh dan perbarui pengaturannya:

```bash
cp .env.example .env
```

### 3. Perbarui Konfigurasi `.env`

Edit file `.env` dan atur variabel berikut:

```env
FRONTEND_URL=
FRONTEND_URL_DEV=
FRONTEND_URL_PROD=

DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

### 4. Jalankan Migrasi Database

```bash
php artisan migrate
```

### 5. Isi Database dengan Data Awal

```bash
php artisan db:seed
```

### 6. Lanjutkan dengan Konfigurasi Frontend

Pastikan aplikasi frontend telah diatur dengan benar dan dikonfigurasi untuk berkomunikasi dengan API ini.

---

Dikembangkan dengan ❤️ menggunakan Laravel.
