<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = ['nama_unit', 'tipe_unit'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'unit_user')
                    ->withPivot(['tanggal_mulai', 'tanggal_selesai'])
                    ->withTimestamps();
    }
}
