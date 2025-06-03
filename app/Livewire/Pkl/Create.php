<?php

namespace App\Livewire\Pkl;

use Livewire\Component;
use App\Models\Pkl;
use App\Models\Guru;
use App\Models\Industri;
use App\Models\Siswa;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    public $guru_id, $industri_id, $siswa_id, $mulai, $selesai;

    public $gurus = [];
    public $industris = [];
    // public $siswas = [];

    protected $rules = [
        'guru_id' => 'required',
        'industri_id' => 'required',
        'siswa_id' => 'required',
        'mulai' => 'required|date',
        'selesai' => 'required|date|after_or_equal:mulai',
    ];

    public function mount()
    {  
        $this->gurus = Guru::all();
        $this->industris = Industri::all();
        // $this->siswas = Siswa::all();

        $currentUser = Auth::user();
        $siswa = Siswa::where('email', $currentUser->email)->first();

        if ($siswa) {
            $this->siswa_id = $siswa->id;
        }
    }

    public function submit()
    {
        $this->validate();

        $mulai = Carbon::parse($this->mulai);
        $selesai = Carbon::parse($this->selesai);

        if ($mulai->diffInDays($selesai) < 90) {
            throw ValidationException::withMessages([
                'selesai' => 'Durasi PKL minimal harus 90 hari.',
            ]);
        }

        Pkl::create([
            'guru_id' => $this->guru_id,
            'siswa_id' => $this->siswa_id,
            'industri_id' => $this->industri_id,
            'mulai' => $this->mulai,
            'selesai' => $this->selesai,
        ]);

        session()->flash('message', 'Data PKL Berhasil Ditambahkan!');
        return redirect()->route('livewire.pkl.index');
    }

    public function render()
    {
        // return view('livewire.pkl.create')->layout('layouts.app');
        $currentUser = Auth::user();
        $currentSiswa = Siswa::where('email', $currentUser->email)->first();

        return view('livewire.pkl.create', [
            'siswas' => $currentSiswa ? collect([$currentSiswa]) : collect([]),
            'currentSiswa' => $currentSiswa
        ])->layout('layouts.app');
    }
}
