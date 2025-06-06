<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Siswa\Index;
use App\Livewire\Guru\Index as GuruIndex;
use App\Livewire\Pkl\Index as PklIndex;
use App\Livewire\Pkl\Create as PklCreate;
use App\Livewire\Industri\Index as IndustriIndex;
use App\Livewire\Industri\Create as IndustriCreate;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([ 
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::middleware(['auth', 'role:guru'])->group(function () {
        Route::get('/siswa', Index::class)->name('livewire.siswa.index');
    });
    Route::middleware(['auth', 'role:guru'])->group(function () {
        Route::get('/guru', GuruIndex::class)->name('livewire.guru.index');
    });
    Route::middleware(['auth', 'role:siswa'])->group(function () {
        Route::get('/pkl', PklIndex::class)->name('livewire.pkl.index');
    });
    Route::middleware(['auth', 'role:siswa'])->group(function () {
        Route::get('/pkl/create', PklCreate::class)->name('livewire.pkl.create');
    });
    Route::middleware(['auth', 'role:siswa'])->group(function () {
        Route::get('/industri', IndustriIndex::class)->name('livewire.industri.index');
    });
    Route::middleware(['auth', 'role:siswa'])->group(function () {
        Route::get('/industri/create', IndustriCreate::class)->name('livewire.industri.create');
    });

    // Route::get('/siswa', Index::class)->name('livewire.siswa.index');
    // Route::get('/guru', GuruIndex::class)->name('livewire.guru.index');
    // Route::get('/pkl/create', PklCreate::class)->name('livewire.pkl.create');
    // Route::get('/industri', IndustriIndex::class)->name('livewire.industri.index');
    // Route::get('/industri/create', IndustriCreate::class)->name('livewire.industri.create');
});