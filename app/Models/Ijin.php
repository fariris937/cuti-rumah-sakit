<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ijin extends Model
{
    use HasFactory;

    protected $table = 'ijin';

    protected $fillable = [
        'user_id',
        'tanggal_ijin',
        'jam_mulai',
        'jam_selesai',
        'keterangan',
        'jenis_ijin',
        'status',
        'disetujui_oleh_kepala_ruangan',
        'disetujui_oleh_kepala_bagian',
        'tanggal_persetujuan',
        'catatan_persetujuan',
        'berkas_pendukung',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function disetujuiOlehKepalaRuangan()
    {
        return $this->belongsTo(User::class, 'disetujui_oleh_kepala_ruangan');
    }

    public function disetujuiOlehKepalaBagian()
    {
        return $this->belongsTo(User::class, 'disetujui_oleh_kepala_bagian');
    }
}
