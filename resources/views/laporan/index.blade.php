<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap justify-between items-center gap-3">
            <div>
                <h1 class="font-bold text-xl text-slate-800">Rekap Aduan</h1>
                <p class="text-sm text-slate-500 mt-0.5">
                    Semua data aduan — {{ $aduans->count() }} aduan tercatat
                </p>
            </div>
            <a href="{{ route('aduan.export') }}"
               class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700
                      text-white font-semibold py-2.5 px-5 rounded-xl text-sm transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Export Excel
            </a>
        </div>
    </x-slot>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

        {{-- Search & Filter Bar --}}
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/60 flex flex-wrap items-center gap-3">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                </svg>
                <input type="text" id="searchInput" placeholder="Cari nomor, kanal, klasifikasi..."
                       class="pl-9 pr-4 py-2 text-sm border border-slate-200 rounded-lg bg-white
                              focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400
                              transition placeholder-slate-400 w-64">
            </div>
        </div>

        {{-- Tabel --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm" id="rekapTable">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 text-xs uppercase tracking-wide">
                        <th class="px-4 py-3 text-left font-semibold w-8">#</th>
                        <th class="px-4 py-3 text-left font-semibold">Nomor Aduan</th>
                        <th class="px-4 py-3 text-left font-semibold">Tanggal & Waktu</th>
                        <th class="px-4 py-3 text-left font-semibold">Kanal</th>
                        <th class="px-4 py-3 text-left font-semibold">Klasifikasi</th>
                        <th class="px-4 py-3 text-left font-semibold">Nama Akun</th>
                        <th class="px-4 py-3 text-left font-semibold">Isi Aduan</th>
                        <th class="px-4 py-3 text-center font-semibold">Status</th>
                        <th class="px-4 py-3 text-left font-semibold">Petugas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($aduans as $index => $item)
                        <tr class="hover:bg-blue-50/30 transition-colors searchable-row">
                            <td class="px-4 py-3 text-slate-400 text-xs">{{ $index + 1 }}</td>

                            <td class="px-4 py-3">
                                <a href="{{ route('aduan.show', $item->id) }}"
                                   class="font-mono text-xs font-bold text-blue-700 hover:underline">
                                    {{ $item->nomor_aduan }}
                                </a>
                            </td>

                            <td class="px-4 py-3 whitespace-nowrap">
                                <p class="text-slate-700 text-xs font-medium">
                                    {{ \Carbon\Carbon::parse($item->tanggal_aduan)->isoFormat('D MMM Y') }}
                                </p>
                                @if($item->waktu_aduan)
                                    <p class="text-slate-400 text-xs">
                                        {{ \Carbon\Carbon::parse($item->waktu_aduan)->format('H:i') }} WIB
                                    </p>
                                @endif
                            </td>

                            <td class="px-4 py-3">
                                <span class="inline-block px-2 py-0.5 bg-indigo-50 text-indigo-700
                                             border border-indigo-200 rounded-md text-xs font-semibold">
                                    {{ $item->kanal }}
                                </span>
                            </td>

                            <td class="px-4 py-3">
                                <span class="inline-block px-2 py-0.5 bg-violet-50 text-violet-700
                                             border border-violet-200 rounded-md text-xs font-semibold">
                                    {{ $item->klasifikasi }}
                                </span>
                            </td>

                            <td class="px-4 py-3 text-slate-600 text-xs">
                                {{ $item->nama_akun ?? '—' }}
                            </td>

                            <td class="px-4 py-3 max-w-xs">
                                <p class="text-slate-600 text-xs line-clamp-2">{{ $item->isi_aduan }}</p>
                            </td>

                            <td class="px-4 py-3 text-center">
                                @if($item->sudah_direspon)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs
                                                 font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        ✓ Sudah
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs
                                                 font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                        ⏳ Belum
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-xs text-slate-500">
                                {{ $item->petugas->name ?? '—' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-16 text-center">
                                <p class="text-slate-400">Belum ada data aduan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer --}}
        @if($aduans->count() > 0)
            <div class="px-6 py-3 bg-slate-50/60 border-t border-slate-100">
                <p class="text-xs text-slate-400">
                    Menampilkan <span class="font-semibold text-slate-600" id="visibleCount">{{ $aduans->count() }}</span>
                    dari {{ $aduans->count() }} aduan
                </p>
            </div>
        @endif
    </div>

    <script>
        document.getElementById('searchInput')?.addEventListener('input', function () {
            const q     = this.value.toLowerCase().trim();
            const rows  = document.querySelectorAll('.searchable-row');
            let count   = 0;
            rows.forEach(row => {
                const match = !q || row.textContent.toLowerCase().includes(q);
                row.style.display = match ? '' : 'none';
                if (match) count++;
            });
            const vc = document.getElementById('visibleCount');
            if (vc) vc.textContent = count;
        });
    </script>
</x-app-layout>
