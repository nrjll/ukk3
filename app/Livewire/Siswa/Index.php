<?php

namespace App\Livewire\Siswa;

use Livewire\Component;
use App\Models\Siswa;

class Index extends Component
{
    public function render()
    {
        return view('livewire.siswa.index', [
            'siswas' => Siswa::all(),
        ])->layout('layouts.app');
    }
}