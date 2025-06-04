<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Guru extends Model
{
    protected $fillable = ['nama', 'nip', 'gender', 'alamat', 'kontak', 'email'];

    public function pkls()
    {
        return $this->hasMany(Pkl::class);
    }

    public function getGenderNameAttribute()
    {
        return DB::select("SELECT get_gender_name(?) as gender_name", [$this->gender])[0]->gender_name;
    }

    public function getFormattedGender()
    {
        return DB::select("SELECT get_gender_name(?) as gender_name", [$this->gender])[0]->gender_name;
    }

    public function scopeByGender($query, $genderCode)
    {
        return $query->where('gender', $genderCode);
    }
}