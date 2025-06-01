<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Guru SIJA') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Data Guru</h3>

                <table class="table-auto w-full border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-4 py-2">No</th>
                            <th class="border px-4 py-2">Nama</th>
                            <th class="border px-4 py-2">Gender</th>
                            <th class="border px-4 py-2">NIP</th>
                            <th class="border px-4 py-2">Email</th>
                            <th class="border px-4 py-2">Kontak</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($gurus as $index => $guru)
                            <tr>
                                <td class="border px-4 py-2">{{ $index + 1 }}</td>
                                <td class="border px-4 py-2">{{ $guru->nama }}</td>
                                <td class="border px-4 py-2 text-center">{{ $guru->gender }}</td>
                                <td class="border px-4 py-2">{{ $guru->nip }}</td>
                                <td class="border px-4 py-2">{{ $guru->email }}</td>
                                <td class="border px-4 py-2">{{ $guru->kontak }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-gray-500 py-4">
                                    Tidak ada data guru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>