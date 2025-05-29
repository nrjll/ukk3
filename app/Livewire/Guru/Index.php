<?php

namespace App\Livewire\Guru;

use Livewire\Component;
use App\Models\Guru;

class Index extends Component
{
    public function render()
    {
        return view('livewire.guru.index', [
            'gurus' => Guru::all(),
        ])->layout('layouts.app');
    }
}
