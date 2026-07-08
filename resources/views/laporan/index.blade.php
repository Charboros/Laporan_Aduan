<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center flex-wrap gap-3">
            <h2 class="font-semibold text-xl leading-tight">Laporan & Rekapitulasi Aduan</h2>
            {{-- Filter Tahun --}}
            <form method="GET" action="{{ route('laporan.index') }}" class="flex items-center gap-2">
                <label class="text-sm font-medium text-gray-600">Tampilkan tahun:</label>
                <select name="tahun" onchange="this.form.submit()"
                    class="border-gray-300 rounded-md text-sm shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 py-1.5">
                    @foreach($daftarTahun as $t)
                        <option value="{{ $t }}" {{ (string)$t == (string)$tahunDipilih ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
            </form>
        </div>
    </x-slot>

    {{-- ===== KARTU STATISTIK TOTAL (SEMUA WAKTU) ===== --}}
    <div class="mb-2">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Statistik Keseluruhan (Semua Waktu)</p>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow p-5 border-l-4 border-blue-500">
                <p class="text-xs text-gray-500 uppercase font-semibold">Total Aduan</p>
                <p class="text-4xl font-bold text-blue-600 mt-1">{{ $totalAduan }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-5 border-l-4 border-green-500">
                <p class="text-xs text-gray-500 uppercase font-semibold">Sudah Direspon</p>
                <p class="text-4xl font-bold text-green-600 mt-1">{{ $totalSudahDirespon }}</p>
                @if($totalAduan > 0)
                    <p class="text-xs text-gray-400 mt-1">{{ number_format(($totalSudahDirespon / $totalAduan) * 100, 1) }}% dari total</p>
                @endif
            </div>
            <div class="bg-white rounded-lg shadow p-5 border-l-4 border-red-500">
                <p class="text-xs text-gray-500 uppercase font-semibold">Belum Direspon</p>
                <p class="text-4xl font-bold text-red-600 mt-1">{{ $totalBelumDirespon }}</p>
                @if($totalAduan > 0)
                    <p class="text-xs text-gray-400 mt-1">{{ number_format(($totalBelumDirespon / $totalAduan) * 100, 1) }}% dari total</p>
                @endif
            </div>
        </div>
    </div>

    {{-- ===== KARTU STATISTIK TAHUN INI ===== --}}
    <div class="mb-6">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Statistik Tahun {{ $tahunDipilih }}</p>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-5">
                <p class="text-xs text-blue-600 uppercase font-semibold">Total Aduan {{ $tahunDipilih }}</p>
                <p class="text-3xl font-bold text-blue-700 mt-1">{{ $totalTahunIni }}</p>
            </div>
            <div class="bg-green-50 border border-green-200 rounded-lg p-5">
                <p class="text-xs text-green-600 uppercase font-semibold">Sudah Direspon</p>
                <p class="text-3xl font-bold text-green-700 mt-1">{{ $sudahDiresponTahunIni }}</p>
            </div>
            <div class="bg-red-50 border border-red-200 rounded-lg p-5">
                <p class="text-xs text-red-600 uppercase font-semibold">Belum Direspon</p>
                <p class="text-3xl font-bold text-red-700 mt-1">{{ $belumDiresponTahunIni }}</p>
            </div>
        </div>
    </div>

    {{-- ===== GRAFIK PER BULAN ===== --}}
    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-bold text-blue-800">Aduan per Bulan — Tahun {{ $tahunDipilih }}</h3>
        </div>
        <div class="p-6">
            @php $totalBulanIni = array_sum(array_column($dataBulan, 'jumlah')); @endphp
            @if($totalBulanIni > 0)
                <div style="height: 220px;">
                    <canvas id="chartBulan"></canvas>
                </div>
            @endif
            <div class="overflow-x-auto mt-4">
                <table class="w-full text-xs border-collapse">
                    <thead>
                        <tr class="bg-gray-50">
                            @foreach($dataBulan as $b)
                                <th class="text-center p-2 border border-gray-200 font-semibold text-gray-600">{{ $b['bulan'] }}</th>
                            @endforeach
                            <th class="text-center p-2 border border-gray-200 font-bold text-blue-700 bg-blue-50">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach($dataBulan as $b)
                                <td class="text-center p-2 border border-gray-100 {{ $b['jumlah'] > 0 ? 'font-bold text-blue-700' : 'text-gray-300' }}">
                                    {{ $b['jumlah'] }}
                                </td>
                            @endforeach
                            <td class="text-center p-2 border border-gray-200 font-bold text-blue-800 bg-blue-50">
                                {{ $totalBulanIni }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ===== KANAL & KLASIFIKASI ===== --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

        {{-- Per Kanal --}}
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-bold text-blue-800">Per Kanal — {{ $tahunDipilih }}</h3>
            </div>
            <div class="p-6">
                @php $totalKanalTahun = $perKanal->sum('jumlah'); @endphp
                @if($totalKanalTahun > 0)
                    <div style="height: 200px;" class="mb-4">
                        <canvas id="chartKanal"></canvas>
                    </div>
                @endif
                <table class="w-full text-sm border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-xs">
                            <th class="text-left p-2 border-b">Kanal</th>
                            <th class="text-right p-2 border-b">Jumlah</th>
                            <th class="text-right p-2 border-b">%</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($perKanal as $row)
                        <tr class="border-b border-gray-50 hover:bg-gray-50">
                            <td class="p-2 font-medium">{{ $row->kanal }}</td>
                            <td class="p-2 text-right font-bold text-blue-700">{{ $row->jumlah }}</td>
                            <td class="p-2 text-right text-gray-500 text-xs">
                                {{ $totalKanalTahun > 0 ? number_format(($row->jumlah / $totalKanalTahun) * 100, 1) : 0 }}%
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="p-4 text-center text-gray-400 text-sm italic">Belum ada data untuk tahun {{ $tahunDipilih }}</td>
                        </tr>
                        @endforelse
                        @if($totalKanalTahun > 0)
                        <tr class="bg-blue-50 font-bold text-sm">
                            <td class="p-2 text-blue-800">Total</td>
                            <td class="p-2 text-right text-blue-800">{{ $totalKanalTahun }}</td>
                            <td class="p-2 text-right text-blue-800">100%</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Per Klasifikasi --}}
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-bold text-blue-800">Per Klasifikasi — {{ $tahunDipilih }}</h3>
            </div>
            <div class="p-6">
                @php $totalKlasTahun = $perKlasifikasi->sum('jumlah'); @endphp
                @if($totalKlasTahun > 0)
                    <div style="height: 200px;" class="mb-4">
                        <canvas id="chartKlasifikasi"></canvas>
                    </div>
                @endif
                <table class="w-full text-sm border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-xs">
                            <th class="text-left p-2 border-b">Klasifikasi</th>
                            <th class="text-right p-2 border-b">Jumlah</th>
                            <th class="text-right p-2 border-b">%</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($perKlasifikasi as $row)
                        <tr class="border-b border-gray-50 hover:bg-gray-50">
                            <td class="p-2 font-medium">{{ $row->klasifikasi }}</td>
                            <td class="p-2 text-right font-bold text-purple-700">{{ $row->jumlah }}</td>
                            <td class="p-2 text-right text-gray-500 text-xs">
                                {{ $totalKlasTahun > 0 ? number_format(($row->jumlah / $totalKlasTahun) * 100, 1) : 0 }}%
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="p-4 text-center text-gray-400 text-sm italic">Belum ada data untuk tahun {{ $tahunDipilih }}</td>
                        </tr>
                        @endforelse
                        @if($totalKlasTahun > 0)
                        <tr class="bg-purple-50 font-bold text-sm">
                            <td class="p-2 text-purple-800">Total</td>
                            <td class="p-2 text-right text-purple-800">{{ $totalKlasTahun }}</td>
                            <td class="p-2 text-right text-purple-800">100%</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ===== TREN TAHUNAN (jika lebih dari 1 tahun) ===== --}}
    @if($trenTahunan->count() > 1)
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-bold text-blue-800">Tren Aduan Tahunan</h3>
        </div>
        <div class="p-6" style="height: 250px;">
            <canvas id="chartTren"></canvas>
        </div>
    </div>
    @endif

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        const palette = ['#3B82F6','#8B5CF6','#10B981','#F59E0B','#EF4444','#06B6D4','#EC4899','#84CC16'];

        // ---- Chart Bulan (Bar) ----
        @if(array_sum(array_column($dataBulan, 'jumlah')) > 0)
        new Chart(document.getElementById('chartBulan'), {
            type: 'bar',
            data: {
                labels: @json(array_column($dataBulan, 'bulan')),
                datasets: [{
                    label: 'Jumlah Aduan',
                    data: @json(array_column($dataBulan, 'jumlah')),
                    backgroundColor: 'rgba(59,130,246,0.75)',
                    borderColor: '#3B82F6',
                    borderWidth: 1,
                    borderRadius: 5,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });
        @endif

        // ---- Chart Kanal (Doughnut) ----
        @if($perKanal->count() > 0)
        new Chart(document.getElementById('chartKanal'), {
            type: 'doughnut',
            data: {
                labels: @json($perKanal->pluck('kanal')),
                datasets: [{
                    data: @json($perKanal->pluck('jumlah')),
                    backgroundColor: palette,
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom', labels: { font: { size: 11 } } } },
                cutout: '55%'
            }
        });
        @endif

        // ---- Chart Klasifikasi (Doughnut) ----
        @if($perKlasifikasi->count() > 0)
        new Chart(document.getElementById('chartKlasifikasi'), {
            type: 'doughnut',
            data: {
                labels: @json($perKlasifikasi->pluck('klasifikasi')),
                datasets: [{
                    data: @json($perKlasifikasi->pluck('jumlah')),
                    backgroundColor: palette,
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom', labels: { font: { size: 11 } } } },
                cutout: '55%'
            }
        });
        @endif

        // ---- Chart Tren Tahunan (Line) ----
        @if($trenTahunan->count() > 1)
        new Chart(document.getElementById('chartTren'), {
            type: 'line',
            data: {
                labels: @json($trenTahunan->pluck('tahun')),
                datasets: [{
                    label: 'Total Aduan per Tahun',
                    data: @json($trenTahunan->pluck('jumlah')),
                    borderColor: '#3B82F6',
                    backgroundColor: 'rgba(59,130,246,0.1)',
                    fill: true,
                    tension: 0.3,
                    pointRadius: 6,
                    pointBackgroundColor: '#3B82F6',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });
        @endif
    </script>
</x-app-layout>
