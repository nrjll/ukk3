<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lapor PKL') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Data PKL</h3>
                <a href="{{ route('livewire.pkl.create') }}" class="mb-4 inline-block bg-green-600 text-white px-4 py-2 rounded">
                    Tambah PKL
                </a>
                <table class="table-auto w-full border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-4 py-2">No</th>
                            <th class="border px-4 py-2">Nama Siswa</th>
                            <th class="border px-4 py-2">Guru Pembimbing</th>
                            <th class="border px-4 py-2">Indsutri</th>
                            <th class="border px-4 py-2">Mulai</th>
                            <th class="border px-4 py-2">Selesai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pkls as $index => $pkl)
                            <tr>
                                <td class="border px-4 py-2">{{ $index + 1 }}</td>
                                <td class="border px-4 py-2">{{ $pkl->siswa?->nama ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $pkl->guru?->nama ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $pkl->industri?->nama ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $pkl->mulai->format('d-m-Y') }}</td>
                                <td class="border px-4 py-2">{{ $pkl->selesai->format('d-m-Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-gray-500 py-4">
                                    Tidak ada data PKL.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>