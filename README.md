
````markdown
# Project Laravel 12 - Setup Awal

Project ini adalah setup awal Laravel 12 dengan konfigurasi koneksi ke database MySQL.

## Persyaratan
- PHP >= 8.4
- Composer
- MySQL
- Laravel 12

## Instalasi

1. **Clone repository**
```bash
git clone git@github.com:Putra-pkwl03/siakk-project-be.git
````

2. **Install dependencies**

```bash
composer install
```

3. **Copy file environment**

```bash
cp .env.example .env
```

4. **Konfigurasi database**
   Edit file `.env` sesuai dengan setting MySQL Anda:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=username_mysql
DB_PASSWORD=password_mysql
```

5. **Generate application key**

```bash
php artisan key:generate
```

6. **Jalankan migration (opsional)**
   Jika sudah ada migration:

```bash
php artisan migrate
```

7. **Jalankan server**

```bash
php artisan serve
```

Project sekarang dapat diakses di `http://127.0.0.1:8000`.

## Struktur Folder Awal

```
app/       -> kode utama aplikasi
config/    -> konfigurasi aplikasi
database/  -> migration, seeders, factories
public/    -> folder publik (index.php)
resources/ -> views, assets (css, js)
routes/    -> file routing
```

## Catatan

* Ini baru setup awal project Laravel 12 dengan koneksi database MySQL.
* Belum ada fitur atau modul tambahan.

```
