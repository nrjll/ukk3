<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Tambah Data Industri</h2>
    </x-slot>

    <div class="p-6">
        <form wire:submit.prevent="submit">

            {{-- Field Nama --}}
            <div class="mb-4">
                <label>Nama Industri</label>
                <input wire:model="nama" type="text" class="w-full border rounded" placeholder="Masukkan nama industri" />
                @error('nama') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            {{-- Field Bidang Usaha --}}
            <div class="mb-4">
                <label>Bidang Usaha</label>
                <input wire:model="bidang_usaha" type="text" class="w-full border rounded" placeholder="Masukkan bidang usaha industri" />
                @error('bidang_usaha') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            {{-- Field Alamat --}}
            <div class="mb-4">
                <label>Alamat</label>
                <input wire:model="alamat" type="text" class="w-full border rounded" placeholder="Masukkan Alamat Industri" />
                @error('alamat') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>


            {{-- Field Kontak --}}
            <div class="mb-4">
                <label>Kontak</label>
                <input wire:model="kontak" type="text" class="w-full border rounded" placeholder="Masukkan kontak Industri" />
                @error('kontak') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            {{-- Field Email --}}
            <div class="mb-4">
                <label>Email</label>
                <input wire:model="email" type="email" class="w-full border rounded" placeholder="Masukkan email industri" />
                @error('email') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            {{-- Field Website --}}
            <div class="mb-4">
                <label>website</label>
                <input wire:model="website" type="url" class="w-full border rounded" placeholder="Masukkan website industri" />
                @error('website') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
        </form>
    </div>
</div>
