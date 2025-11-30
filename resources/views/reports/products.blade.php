<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Laporan Produk Dain Store
        </h2>
    </x-slot>

    <div class="py-12 overflow-x-auto">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-4 shadow rounded">
                <table class="w-full table-auto border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-4 py-2 text-left">Nama</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Harga</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Size</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-300 px-4 py-2">{{ $product->name }}</td>
                            <td class="border border-gray-300 px-4 py-2">Rp {{ number_format($product->price,0,',','.') }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $product->size ?? '-' }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $product->stock }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="border border-gray-300 px-4 py-2 text-center">Tidak ada data produk</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
