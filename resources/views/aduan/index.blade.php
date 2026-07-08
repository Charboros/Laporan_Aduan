<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl leading-tight">Data Aduan</h2>
            <div class="flex gap-2">
                <a href="{{ route('aduan.export') }}"
                   class="inline-flex items-center gap-1 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Export Excel (.xlsx)
                </a>
                @if(Auth::user()->role === 'petugas' || Auth::user()->role === 'admin')
                <a href="{{ route('aduan.create') }}"
                   class="inline-flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Aduan
                </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-blue-50 border-b-2 border-blue-200 text-blue-900">
                        <th class="p-3 font-semibold">No</th>
                        <th class="p-3 font-semibold">Nomor Aduan</th>
                        <th class="p-3 font-semibold">Tanggal</th>
                        <th class="p-3 font-semibold">Kanal</th>
                        <th class="p-3 font-semibold">Klasifikasi</th>
                        <th class="p-3 font-semibold">Pelapor</th>
                        <th class="p-3 font-semibold text-center">Status Respon</th>
                        <th class="p-3 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($aduans as $index => $item)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                        <td class="p-3 text-gray-500">{{ $index + 1 }}</td>
                        <td class="p-3 font-medium text-blue-800">{{ $item->nomor_aduan }}</td>
                        <td class="p-3 whitespace-nowrap">{{ \Carbon\Carbon::parse($item->tanggal_aduan)->format('d M Y') }}</td>
                        <td class="p-3">
                            @if($item->kanal)
                                <span class="px-2 py-1 bg-indigo-100 text-indigo-700 rounded text-xs font-medium">{{ $item->kanal }}</span>
                            @else
                                <span class="text-gray-300">—</span>
                            @endif
                        </td>
                        <td class="p-3">
                            @if($item->klasifikasi)
                                <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded text-xs font-medium">{{ $item->klasifikasi }}</span>
                            @else
                                <span class="text-gray-300">—</span>
                            @endif
                        </td>
                        <td class="p-3">
                            <span class="font-medium">{{ $item->nama_pelapor }}</span>
                            @if($item->nama_akun)
                                <span class="block text-xs text-indigo-500">{{ $item->nama_akun }}</span>
                            @endif
                        </td>
                        <td class="p-3 text-center">
                            @if($item->sudah_direspon)
                                <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs px-2.5 py-1 rounded-full border border-green-200 font-medium">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    Sudah Direspon
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 bg-red-100 text-red-700 text-xs px-2.5 py-1 rounded-full border border-red-200 font-medium">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                                    Belum Direspon
                                </span>
                            @endif
                        </td>
                        <td class="p-3 text-center whitespace-nowrap">
                            <a href="{{ route('aduan.show', $item->id) }}"
                               class="text-xs bg-indigo-100 text-indigo-700 hover:bg-indigo-200 px-3 py-1.5 rounded font-medium">Detail</a>
                            @if(Auth::user()->role === 'petugas' || Auth::user()->role === 'admin')
                            <a href="{{ route('aduan.edit', $item->id) }}"
                               class="text-xs bg-gray-100 text-gray-700 hover:bg-gray-200 px-3 py-1.5 rounded font-medium">Edit</a>
                            <form action="{{ route('aduan.destroy', $item->id) }}" method="POST"
                                  class="inline-block" onsubmit="return confirm('Yakin ingin menghapus aduan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-xs bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1.5 rounded font-medium">Hapus</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="p-10 text-center text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            Belum ada data aduan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
