<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Siswa SIJA') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Data Siswa</h3>

                <table class="table-auto w-full border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-4 py-2">No</th>
                            <th class="border px-4 py-2">Nama</th>
                            <th class="border px-4 py-2">Gender</th>
                            <th class="border px-4 py-2">NIS</th>
                            <th class="border px-4 py-2">Email</th>
                            <th class="border px-4 py-2">Kontak</th>
                            <th class="border px-4 py-2">Status Lapor PKL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($siswas as $index => $siswa)
                            <tr>
                                <td class="border px-4 py-2">{{ $index + 1 }}</td>
                                <td class="border px-4 py-2">{{ $siswa->nama }}</td>
                                <td class="border px-4 py-2">{{ $siswa->gender }}</td>
                                <td class="border px-4 py-2">{{ $siswa->nis }}</td>
                                <td class="border px-4 py-2">{{ $siswa->email }}</td>
                                <td class="border px-4 py-2">{{ $siswa->kontak }}</td>
                                <td class="border px-4 py-2">{{ $siswa->status_lapor_pkl }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-gray-500 py-4">
                                    Tidak ada data siswa.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>