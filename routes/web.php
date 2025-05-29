<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Siswa\Index;
use App\Livewire\Guru\Index as GuruIndex;
use App\Livewire\Pkl\Index as PklIndex;
use App\Livewire\Pkl\Create as PklCreate;

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
    
    Route::get('/siswa', Index::class)->name('livewire.siswa.index');
    Route::get('/guru', GuruIndex::class)->name('livewire.guru.index');
    Route::get('/pkl', PklIndex::class)->name('livewire.pkl.index');
    Route::get('/pkl/create', PklCreate::class)->name('livewire.pkl.create');
});