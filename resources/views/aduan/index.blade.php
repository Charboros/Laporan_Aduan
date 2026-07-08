<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap justify-between items-center gap-3">
            <div>
                <h1 class="font-bold text-xl text-slate-800">Data Aduan</h1>
                <p class="text-sm text-slate-500 mt-0.5">Daftar seluruh aduan yang masuk</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('aduan.export') }}"
                   class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700
                          text-white font-semibold py-2 px-4 rounded-lg text-sm transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Export Excel
                </a>
                @if(Auth::user()->role === 'petugas' || Auth::user()->role === 'admin')
                    <a href="{{ route('aduan.create') }}"
                       class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700
                              text-white font-semibold py-2 px-4 rounded-lg text-sm transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Aduan
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

        {{-- Search Bar --}}
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/60">
            <div class="relative max-w-xs">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                </svg>
                <input type="text" id="searchInput" placeholder="Cari nomor, pelapor, kanal..."
                       class="w-full pl-9 pr-4 py-2 text-sm border border-slate-200 rounded-lg
                              bg-white focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400
                              transition placeholder-slate-400">
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm" id="aduanTable">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 text-xs uppercase tracking-wide">
                        <th class="px-4 py-3 text-left font-semibold w-10">#</th>
                        <th class="px-4 py-3 text-left font-semibold">Nomor Aduan</th>
                        <th class="px-4 py-3 text-left font-semibold">Tanggal</th>
                        <th class="px-4 py-3 text-left font-semibold">Kanal</th>
                        <th class="px-4 py-3 text-left font-semibold">Klasifikasi</th>
                        <th class="px-4 py-3 text-left font-semibold">Pelapor</th>
                        <th class="px-4 py-3 text-center font-semibold">Status</th>
                        <th class="px-4 py-3 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($aduans as $index => $item)
                    <tr class="hover:bg-blue-50/40 transition-colors duration-100 searchable-row">
                        <td class="px-4 py-3 text-slate-400 text-xs">{{ $index + 1 }}</td>

                        <td class="px-4 py-3">
                            <span class="font-semibold text-blue-700 font-mono text-xs tracking-wide">
                                {{ $item->nomor_aduan }}
                            </span>
                        </td>

                        <td class="px-4 py-3 whitespace-nowrap text-slate-600">
                            {{ \Carbon\Carbon::parse($item->tanggal_aduan)->format('d M Y') }}
                        </td>

                        <td class="px-4 py-3">
                            @if($item->kanal)
                                <span class="inline-block px-2.5 py-1 bg-indigo-50 text-indigo-700
                                             border border-indigo-200 rounded-md text-xs font-semibold">
                                    {{ $item->kanal }}
                                </span>
                            @else
                                <span class="text-slate-300">—</span>
                            @endif
                        </td>

                        <td class="px-4 py-3">
                            @if($item->klasifikasi)
                                <span class="inline-block px-2.5 py-1 bg-violet-50 text-violet-700
                                             border border-violet-200 rounded-md text-xs font-semibold">
                                    {{ $item->klasifikasi }}
                                </span>
                            @else
                                <span class="text-slate-300">—</span>
                            @endif
                        </td>

                        <td class="px-4 py-3">
                            <p class="font-medium text-slate-800">{{ $item->nama_pelapor }}</p>
                            @if($item->nama_akun)
                                <p class="text-xs text-indigo-500 mt-0.5">{{ $item->nama_akun }}</p>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-center">
                            @if($item->sudah_direspon)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs
                                             font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                              d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                    Sudah
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs
                                             font-semibold bg-red-50 text-red-600 border border-red-200">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                              d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                    Belum
                                </span>
                            @endif
                        </td>

                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center gap-1.5">
                                <a href="{{ route('aduan.show', $item->id) }}"
                                   class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium
                                          bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-200 transition">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Detail
                                </a>

                                @if(Auth::user()->role === 'petugas' || Auth::user()->role === 'admin')
                                    <a href="{{ route('aduan.edit', $item->id) }}"
                                       class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium
                                              bg-slate-50 text-slate-700 hover:bg-slate-100 border border-slate-200 transition">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>

                                    <form action="{{ route('aduan.destroy', $item->id) }}" method="POST"
                                          class="inline-block"
                                          onsubmit="return confirm('Yakin ingin menghapus aduan {{ $item->nomor_aduan }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium
                                                       bg-red-50 text-red-600 hover:bg-red-100 border border-red-200 transition">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3 text-slate-400">
                                <svg class="w-14 h-14 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                <p class="font-medium text-slate-500">Belum ada data aduan</p>
                                <p class="text-sm">Data aduan yang ditambahkan akan muncul di sini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer info --}}
        @if($aduans->count() > 0)
            <div class="px-6 py-3 bg-slate-50/60 border-t border-slate-100">
                <p class="text-xs text-slate-400">
                    Menampilkan <span class="font-semibold text-slate-600" id="visibleCount">{{ $aduans->count() }}</span>
                    dari <span class="font-semibold text-slate-600">{{ $aduans->count() }}</span> aduan
                </p>
            </div>
        @endif
    </div>

    {{-- Client-side search script --}}
    <script>
        const searchInput  = document.getElementById('searchInput');
        const rows         = document.querySelectorAll('.searchable-row');
        const visibleCount = document.getElementById('visibleCount');

        searchInput?.addEventListener('input', function () {
            const q = this.value.toLowerCase().trim();
            let count = 0;

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const match = !q || text.includes(q);
                row.style.display = match ? '' : 'none';
                if (match) count++;
            });

            if (visibleCount) visibleCount.textContent = count;
        });
    </script>
</x-app-layout>
