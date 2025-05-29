<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Tambah Data PKL</h2>
    </x-slot>

    <div class="p-6">
        <form wire:submit.prevent="submit">

            {{-- Field Guru --}}
            <div class="mb-4">
                <label>Guru Pembimbing</label>
                <select wire:model="guru_id" class="w-full border rounded">
                    <option value="">-- Pilih Guru --</option>
                    @foreach ($gurus as $guru)
                        <option value="{{ $guru->id }}">{{ $guru->nama }}</option>
                    @endforeach
                </select>
                @error('guru_id') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            {{-- Field Industri --}}
            <div class="mb-4">
                <label>Industri</label>
                <select wire:model="industri_id" class="w-full border rounded">
                    <option value="">-- Pilih Industri --</option>
                    @foreach ($industris as $industri)
                        <option value="{{ $industri->id }}">{{ $industri->nama }}</option>
                    @endforeach
                </select>
                @error('industri_id') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            {{-- Field Siswa --}}
            <div class="mb-4">
                <label>Nama Siswa</label>
                <select wire:model="siswa_id" class="w-full border rounded">
                    <option value="">-- Pilih Siswa --</option>
                    @foreach ($siswas as $siswa)
                        <option value="{{ $siswa->id }}">{{ $siswa->nama }}</option>
                    @endforeach
                </select>
                @error('siswa_id') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>


            {{-- Field Tanggal Mulai --}}
            <div class="mb-4">
                <label>Tanggal Mulai</label>
                <input wire:model="mulai" type="date" class="w-full border rounded" />
                @error('mulai') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            {{-- Field Tanggal Selesai --}}
            <div class="mb-4">
                <label>Tanggal Selesai</label>
                <input wire:model="selesai" type="date" class="w-full border rounded" />
                @error('selesai') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
        </form>
    </div>
</div>
