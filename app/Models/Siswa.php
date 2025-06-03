<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswas';

    protected $fillable = ['nama','nis','gender','alamat','kontak','email','status_lapor_pkl'];

    public function pkls() {
        return $this->hasMany(Pkl::class);
    }

    protected $casts = [
        'status_lapor_pkl' => 'boolean',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'email', 'email');
    }
}