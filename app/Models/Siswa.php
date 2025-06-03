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

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($siswa) {
            if ($siswa->isDirty('email')) {
                $oldEmail = $siswa->getOriginal('email');
                $newEmail = $siswa->email;

                User::where('email', $oldEmail)->update(['email' => $newEmail]);
            }
        });
    }
}