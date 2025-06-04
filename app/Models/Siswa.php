<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    // Accessor untuk mendapatkan nama gender menggunakan stored function
    public function getGenderNameAttribute()
    {
        return DB::select("SELECT get_gender_name(?) as gender_name", [$this->gender])[0]->gender_name;
    }

    // Method untuk mendapatkan gender dengan stored function
    public function getFormattedGender()
    {
        return DB::select("SELECT get_gender_name(?) as gender_name", [$this->gender])[0]->gender_name;
    }

    // Scope untuk filter berdasarkan gender menggunakan stored function
    public function scopeByGender($query, $genderCode)
    {
        return $query->where('gender', $genderCode);
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