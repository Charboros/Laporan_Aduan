<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Total Aduan -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold tracking-wider">Total Aduan</p>
                    <p class="text-4xl font-bold text-blue-600 mt-1">{{ $totalAduan }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Belum Direspon -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold tracking-wider">Belum Direspon</p>
                    <p class="text-4xl font-bold text-red-600 mt-1">{{ $aduanBelumDirespon }}</p>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                    <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Sudah Direspon -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold tracking-wider">Sudah Direspon</p>
                    <p class="text-4xl font-bold text-green-600 mt-1">{{ $aduanSudahDirespon }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Progress bar respon --}}
    @if($totalAduan > 0)
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex justify-between items-center mb-2">
            <span class="text-sm font-semibold text-gray-700">Tingkat Respon</span>
            <span class="text-sm font-bold text-green-600">{{ number_format(($aduanSudahDirespon / $totalAduan) * 100, 1) }}%</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-3">
            <div class="bg-green-500 h-3 rounded-full transition-all duration-500"
                 style="width: {{ ($aduanSudahDirespon / $totalAduan) * 100 }}%"></div>
        </div>
        <p class="text-xs text-gray-500 mt-2">{{ $aduanSudahDirespon }} dari {{ $totalAduan }} aduan telah direspon</p>
    </div>
    @endif

    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
        <div class="p-6">
            <h3 class="text-lg font-bold mb-2 text-blue-800">Selamat datang, {{ Auth::user()->name }}!</h3>
            <p class="text-gray-600 text-sm">
                Gunakan menu di sebelah kiri untuk mengelola data aduan dan melihat rekapitulasi laporan.
            </p>
        </div>
    </div>
</x-app-layout>
