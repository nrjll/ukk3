<?php

namespace App\Livewire\Pkl;

use Livewire\Component;
use App\Models\Pkl;

class Index extends Component
{
    public function render()
    {
        return view('livewire.pkl.index', [
            'pkls' => Pkl::all(),
        ])->layout('layouts.app');
    }
}
