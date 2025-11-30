<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                <!-- Total Produk -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-gradient-to-br from-blue-50 to-blue-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Total Produk</p>
                                <p class="text-3xl font-bold text-blue-600 mt-2">{{ $totalProducts }}</p>
                                <p class="text-xs text-gray-500 mt-2">Produk aktif</p>
                            </div>
                            <div class="text-5xl text-blue-200">📦</div>
                        </div>
                    </div>
                </div>

                <!-- Total Stok -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-gradient-to-br from-green-50 to-green-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Total Stok</p>
                                <p class="text-3xl font-bold text-green-600 mt-2">{{ $totalStock }}</p>
                                <p class="text-xs text-gray-500 mt-2">Barang tersedia</p>
                            </div>
                            <div class="text-5xl text-green-200">📊</div>
                        </div>
                    </div>
                </div>

                <!-- Rata-rata Harga -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-gradient-to-br from-purple-50 to-purple-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Rata-rata Harga</p>
                                <p class="text-2xl font-bold text-purple-600 mt-2">
                                    Rp. {{ number_format($averagePrice, 0, ',', '.') }}
                                </p>
                                <p class="text-xs text-gray-500 mt-2">Per item</p>
                            </div>
                            <div class="text-5xl text-purple-200">💰</div>
                        </div>
                    </div>
                </div>

                <!-- Harga Tertinggi -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-gradient-to-br from-orange-50 to-orange-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Harga Tertinggi</p>
                                <p class="text-2xl font-bold text-orange-600 mt-2">
                                    Rp. {{ number_format($maxPrice, 0, ',', '.') }}
                                </p>
                                <p class="text-xs text-gray-500 mt-2">Produk termahal</p>
                            </div>
                            <div class="text-5xl text-orange-200">⭐</div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Member & Role Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- Total Member -->
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-gradient-to-br from-indigo-50 to-indigo-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Total Member</p>
                <p class="text-3xl font-bold text-indigo-600 mt-2">
                    {{ $totalMembers ?? 0 }}
                </p>
                <p class="text-xs text-gray-500 mt-2">Member terdaftar</p>
            </div>
            <div class="text-5xl text-indigo-200">👥</div>
        </div>
    </div>
</div>


                <!-- Role Info -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-gradient-to-br from-red-50 to-red-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Peran Anda</p>
                                <p class="text-2xl font-bold text-red-600 mt-2">
                                    @if(auth()->user()->role === 'admin')
                                        Administrator
                                    @else
                                        Pemilik Toko
                                    @endif
                                </p>
                                <p class="text-xs text-gray-500 mt-2">{{ auth()->user()->name }}</p>
                            </div>
                            <div class="text-5xl">
                                @if(auth()->user()->role === 'admin')
                                    🔑
                                @else
                                    👔
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Recent Members -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Member Terbaru</h3>

                    <div class="space-y-3">
                        @forelse($recentMembers as $member)
                            <div class="flex items-center justify-between py-2 border-b last:border-b-0">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $member->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $member->email }}</p>
                                </div>
                                <div class="text-xs bg-green-100 text-green-800 px-3 py-1 rounded-full">
                                    Aktif
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">Belum ada member</p>
                        @endforelse
                    </div>

                    @if($totalMembers > 5)
                        <div class="mt-4 text-center">
                            <a href="{{ route('members.index') }}" 
                               class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                Lihat semua member →
                            </a>
                        </div>
                    @endif
                </div>
            </div>


        </div>
    </div>
</x-app-layout>
