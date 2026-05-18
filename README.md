# Sistem Cuti Rumah Sakit

Sistem manajemen cuti dan mutasi karyawan untuk rumah sakit dengan fitur approval oleh kepala bagian.

## Fitur Utama

### 1. Manajemen Cuti
- Pengajuan cuti oleh karyawan
- Approval/rejection oleh kepala bagian
- Validasi sisa cuti dan overlap tanggal
- Riwayat cuti lengkap
- Pengurangan sisa cuti otomatis saat disetujui

### 2. Manajemen Mutasi
- Mutasi karyawan medis antar unit
- Validasi divisi dan tipe unit
- Riwayat mutasi lengkap
- Hanya kepala bagian yang bisa memutasi karyawan di divisinya

### 3. Role-based Access Control
- **Admin**: Kelola user dan sistem
- **Kepala Bagian**: Approve cuti dan mutasi karyawan di divisinya
- **Karyawan**: Ajukan cuti dan lihat riwayat

### 4. Divisi yang Didukung
- Kepala Bagian Keperawatan
- Kepala Bidang Penunjang Medis
- Kepala Bagian Keuangan
- Kepala Bidang Pelayanan Medis
- Casemix
- Kepegawaian

## Instalasi

1. Clone repository
```bash
git clone <repository-url>
cd cuti-rumah-sakit
```

2. Install dependencies
```bash
composer install
```

3. Setup environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Konfigurasi database di `.env`
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cuti_rumah_sakit
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. Jalankan migrasi dan seeder
```bash
php artisan migrate
php artisan db:seed --class=DivisiSeeder
php artisan db:seed --class=UnitSeeder
```

6. Jalankan server
```bash
php artisan serve
```

## Struktur Database

### Tabel `users`
- `id`: Primary key
- `nama`: Nama lengkap
- `divisi_id`: Foreign key ke tabel divisi
- `jabatan`: Jabatan karyawan
- `jenis_karyawan`: medis/non-medis
- `role`: admin/kepala_bagian/karyawan
- `sisa_cuti`: Sisa cuti dalam hari
- `email`: Email (optional)
- `password`: Password (optional)

### Tabel `divisi`
- `id`: Primary key
- `nama_divisi`: Nama divisi
- `kepala_divisi`: Nama kepala divisi (optional)

### Tabel `units`
- `id`: Primary key
- `nama_unit`: Nama unit
- `tipe_unit`: medis/non-medis

### Tabel `unit_user` (Pivot)
- `user_id`: Foreign key ke users
- `unit_id`: Foreign key ke units
- `tanggal_mulai`: Tanggal mulai di unit
- `tanggal_selesai`: Tanggal selesai di unit (nullable)

### Tabel `cuti`
- `id`: Primary key
- `user_id`: Foreign key ke users
- `tanggal_mulai`: Tanggal mulai cuti
- `tanggal_selesai`: Tanggal selesai cuti
- `status`: pending/disetujui/ditolak
- `disetujui_oleh`: Foreign key ke users (yang approve)

## API Endpoints

### User Routes
- `GET /dashboard` - Dashboard user
- `GET /cuti` - Daftar cuti user
- `GET /cuti/create` - Form ajukan cuti
- `POST /cuti` - Submit ajukan cuti
- `GET /cuti/history` - Riwayat cuti
- `GET /mutasi/history` - Riwayat mutasi

### Kepala Bagian Routes
- `GET /kepala-bagian/dashboard` - Dashboard kepala bagian
- `POST /kepala-bagian/mutasi` - Mutasi karyawan
- `POST /kepala-bagian/cuti/{id}/approve` - Approve cuti
- `POST /kepala-bagian/cuti/{id}/reject` - Reject cuti

### Admin Routes
- `GET /admin/users` - Daftar semua user
- `GET /admin/users/create` - Form tambah user
- `POST /admin/users` - Submit tambah user

## Validasi Bisnis

### Cuti
1. Tanggal mulai harus >= hari ini
2. Tanggal selesai harus >= tanggal mulai
3. Sisa cuti harus mencukupi
4. Tidak boleh overlap dengan cuti yang sudah disetujui/pending
5. Hanya kepala bagian yang bisa approve cuti karyawan di divisinya

### Mutasi
1. Hanya karyawan medis yang bisa dimutasi
2. Unit tujuan harus bertipe medis
3. Hanya kepala bagian yang bisa memutasi karyawan di divisinya
4. Tidak boleh mutasi ke unit yang sama
5. Unit lama akan ditutup otomatis

## Middleware

- `auth`: User harus login
- `admin`: User harus berrole admin
- `kepala_bagian`: User harus berrole kepala_bagian

## Views

### Layout
- `layouts/app.blade.php` - Layout utama dengan sidebar

### User Views
- `user/dashboard.blade.php` - Dashboard karyawan
- `user/cuti/index.blade.php` - Daftar cuti
- `user/cuti/create.blade.php` - Form ajukan cuti
- `user/cuti/history.blade.php` - Riwayat cuti
- `user/mutasi/history.blade.php` - Riwayat mutasi

### Kepala Bagian Views
- `kepala_bagian/dashboard.blade.php` - Dashboard kepala bagian

### Auth Views
- `auth/login.blade.php` - Halaman login

## Styling

Menggunakan Bootstrap 5 dengan custom CSS untuk:
- Gradient backgrounds
- Card styling
- Status badges
- Responsive design
- Font Awesome icons

## Testing

Untuk testing, buat user dengan role yang berbeda:

1. **Admin User**
```php
User::create([
    'nama' => 'Admin',
    'divisi_id' => 1,
    'jabatan' => 'Administrator',
    'jenis_karyawan' => 'non-medis',
    'role' => 'admin',
    'sisa_cuti' => 12,
    'email' => 'admin@rs.com',
    'password' => Hash::make('password')
]);
```

2. **Kepala Bagian**
```php
User::create([
    'nama' => 'Kepala Keperawatan',
    'divisi_id' => 1,
    'jabatan' => 'Kepala Bagian Keperawatan',
    'jenis_karyawan' => 'medis',
    'role' => 'kepala_bagian',
    'sisa_cuti' => 12,
    'email' => 'kepala@rs.com',
    'password' => Hash::make('password')
]);
```

3. **Karyawan**
```php
User::create([
    'nama' => 'Perawat A',
    'divisi_id' => 1,
    'jabatan' => 'Perawat',
    'jenis_karyawan' => 'medis',
    'role' => 'karyawan',
    'sisa_cuti' => 12,
    'email' => 'perawat@rs.com',
    'password' => Hash::make('password')
]);
```

## Troubleshooting

### Error: "Class 'App\Models\Divisi' not found"
Pastikan model Divisi sudah dibuat dan namespace-nya benar.

### Error: "Table 'divisi' doesn't exist"
Jalankan migrasi: `php artisan migrate`

### Error: "Middleware not found"
Pastikan middleware sudah didaftarkan di `bootstrap/app.php`

### Error: "Route not found"
Pastikan routes sudah didefinisikan dengan benar di `routes/web.php`

## Kontribusi

1. Fork repository
2. Buat feature branch
3. Commit changes
4. Push ke branch
5. Buat Pull Request

## Lisensi

MIT License