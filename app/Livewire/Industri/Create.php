<?php

namespace App\Livewire\Industri;

use Livewire\Component;
use App\Models\Industri;

class Create extends Component
{
    public $nama, $bidang_usaha, $alamat, $kontak, $email, $website;

    protected $rules = [
        'nama' => 'required',
        'bidang_usaha' => 'required',
        'alamat' => 'required',
        'kontak' => 'required',
        'email' => 'required|email',
        'website' => 'required|url',
    ];

    public function submit()
    {
        $this->validate();

        Industri::create([
            'nama' => $this->nama,
            'bidang_usaha' => $this->bidang_usaha,
            'alamat' => $this->alamat,
            'kontak' => $this->kontak,
            'email' => $this->email,
            'website' => $this->website,
        ]);

        session()->flash('message', 'Data Industri Berhasil Ditambahkan!');
        return redirect()->route('livewire.industri.index');
    }

    public function render()
    {
        return view('livewire.industri.create')->layout('layouts.app');
    }
}
