<?php

namespace App\Livewire\Pkl;

use Livewire\Component;
use App\Models\Pkl;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public function render()
    {
        $currentUser = Auth::user();
        $currentSiswa = Siswa::where('email', $currentUser->email)->first();
        
        // Hanya tampilkan PKL milik siswa yang login
        $pkls = collect([]);
        if ($currentSiswa) {
            $pkls = Pkl::where('siswa_id', $currentSiswa->id)->get();
        }

        return view('livewire.pkl.index', [
            'pkls' => $pkls,
            'currentSiswa' => $currentSiswa,
            'canCreatePkl' => $currentSiswa ? !$currentSiswa->status_lapor_pkl : false
        ])->layout('layouts.app');
    }
}
