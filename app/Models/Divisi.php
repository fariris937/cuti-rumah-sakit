<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    protected $table = 'divisi';
    
    protected $fillable = ['nama_divisi', 'kepala_divisi'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function kepalaBagian()
    {
        return $this->hasOne(User::class)->where('role', 'kepala_bagian');
    }
}
