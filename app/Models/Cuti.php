<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    protected $table = 'cuti';
    protected $fillable = [
        'user_id', 'tanggal_mulai', 'tanggal_selesai', 'keterangan', 'berkas_pendukung', 'status', 'disetujui_oleh', 'disetujui_oleh_kepala_bagian', 'disetujui_oleh_kepala_ruangan'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function disetujuiOleh()
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }

    public function disetujuiOlehKepalaBagian()
    {
        return $this->belongsTo(User::class, 'disetujui_oleh_kepala_bagian');
    }

    public function disetujuiOlehKepalaRuangan()
    {
        return $this->belongsTo(User::class, 'disetujui_oleh_kepala_ruangan');
    }

    // Scope untuk cuti pending
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Scope untuk cuti disetujui
    public function scopeDisetujui($query)
    {
        return $query->where('status', 'disetujui');
    }

    // Scope untuk cuti ditolak
    public function scopeDitolak($query)
    {
        return $query->where('status', 'ditolak');
    }
}
