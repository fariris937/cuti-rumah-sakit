<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nama', 'divisi', 'divisi_id', 'jabatan', 'jumlah_cuti', 'jenis_karyawan', 'role', 'sisa_cuti', 'email', 'password'
    ];

    protected $hidden = ['password', 'remember_token'];

    // Relasi ke divisi
    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }

    // Relasi ke cuti
    public function cutis()
    {
        return $this->hasMany(Cuti::class);
    }

    // Relasi ke cuti yang disetujui
    public function cutiDisetujui()
    {
        return $this->hasMany(Cuti::class, 'disetujui_oleh');
    }

    // Relasi ke unit melalui pivot
    public function units()
    {
        return $this->belongsToMany(Unit::class, 'unit_user')
                    ->withPivot(['tanggal_mulai', 'tanggal_selesai'])
                    ->withTimestamps();
    }

    // Relasi ke unit aktif
    public function unitAktif()
    {
        return $this->belongsToMany(Unit::class, 'unit_user')
                    ->wherePivot('tanggal_selesai', null)
                    ->orWherePivot('tanggal_selesai', '>', now());
    }

    // Relasi ke unit asal (unit pertama)
    public function unitAsal()
    {
        return $this->belongsToMany(Unit::class, 'unit_user')
                    ->withPivot(['tanggal_mulai', 'tanggal_selesai'])
                    ->orderBy('pivot_tanggal_mulai', 'asc')
                    ->limit(1);
    }

    // Check if user is kepala bagian
    public function isKepalaBagian()
    {
        return $this->role === 'kepala_bagian';
    }

    // Check if user is kepala ruangan
    public function isKepalaRuangan()
    {
        return $this->role === 'kepala_ruangan';
    }

    // Check if user is admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Check if user is kepala kepegawaian
    public function isKepalaKepegawaian()
    {
        return $this->role === 'kepala_kepegawaian';
    }

    // Check if user is kepala bagian kepegawaian
    public function isKepalaBagianKepegawaian()
    {
        return $this->role === 'kepala_bagian_kepegawaian';
    }
}
