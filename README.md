## Langkah-langkah Instalasi

### Prasyarat
Sebelum memulai, pastikan Anda telah memenuhi persyaratan berikut:

* PHP versi 7.4 atau lebih baru telah terinstal di sistem Anda.
* Composer telah terpasang di sistem Anda.
* MySQL telah terpasang dan berjalan di sistem Anda.
* Redis telah terpasang dan berjalan di sistem Anda.

### Langkah 1: Clone Repositori
Buka terminal atau command prompt, lalu jalankan perintah berikut untuk meng-clone repositori proyek Laravel API pada branch main repository ini

### Langkah 2: Instal Dependensi

Pindah ke direktori proyek yang telah Anda kloning dengan perintah berikut:
<pre>
> cd nama-folder-proyek
</pre>

Selanjutnya, jalankan perintah berikut untuk menginstal semua dependensi proyek melalui Composer:
<pre>
> composer install
</pre>

### Langkah 3: Konfigurasi Database

Buatlah salinan file .env.example menjadi .env:
<pre>
> cp .env.example .env
</pre>

Kemudian, buka file .env menggunakan teks editor favorit Anda dan konfigurasi pengaturan database:

<pre>
DB_CONNECTION=mysql
DB_HOST=nama_host_database
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=username_database
DB_PASSWORD=password_database
</pre>

Pastikan untuk mengganti nama_host_database, nama_database, username_database, dan password_database sesuai dengan informasi koneksi database Anda.

### Langkah 4: Konfigurasi Cache Redis

Buka kembali file .env dan tambahkan konfigurasi untuk cache Redis:
>