<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Industri') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Data Industri</h3>
                <a href="{{ route('livewire.industri.create') }}" class="mb-4 inline-block bg-green-600 text-white px-4 py-2 rounded">
                    Tambah Industri
                </a>
                <table class="table-auto w-full border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-4 py-2">No</th>
                            <th class="border px-4 py-2">Nama</th>
                            <th class="border px-4 py-2">Bidang Usaha</th>
                            <th class="border px-4 py-2">Alamat</th>
                            <th class="border px-4 py-2">Kontak</th>
                            <th class="border px-4 py-2">Email</th>
                            <th class="border px-4 py-2">Website</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($industris as $index => $industri)
                            <tr>
                                <td class="border px-4 py-2">{{ $index + 1 }}</td>
                                <td class="border px-4 py-2">{{ $industri->nama }}</td>
                                <td class="border px-4 py-2">{{ $industri->bidang_usaha }}</td>
                                <td class="border px-4 py-2">{{ $industri->alamat }}</td>
                                <td class="border px-4 py-2">{{ $industri->kontak }}</td>
                                <td class="border px-4 py-2">{{ $industri->email }}</td>
                                <td class="border px-4 py-2">{{ $industri->website }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-gray-500 py-4">
                                    Tidak ada data industri.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>