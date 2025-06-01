<?php

namespace App\Livewire\Industri;

use Livewire\Component;
use App\Models\Industri;

class Index extends Component
{
    public function render()
    {
        return view('livewire.industri.index', [
            'industris' => Industri::all(),
        ])->layout('layouts.app');
    }
}
