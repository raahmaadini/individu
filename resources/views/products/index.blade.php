<x-app-layout>
    <h1 class="text-2xl font-bold mb-4">Daftar Produk</h1>

    @if(session('success'))
        <div class="text-green-600">{{ session('success') }}</div>
    @endif

    @if(auth()->user()->role === 'admin')
    <a href="/products/create" class="bg-blue-600 text-white px-3 py-2 rounded">
        Tambah Produk
    </a>
    @endif

    <table class="w-full mt-4 border">
        <tr class="bg-gray-200">
            <th class="p-2">Nama</th>
            <th>Harga</th>
            <th>Size</th>
            <th>Stock</th>
            <th>Gambar</th>
                @if(auth()->user()->role === 'admin')
            <th>Aksi</th>
            @endif
            
        </tr>

        @foreach($products as $p)
        <tr class="border">
            <td class="p-2">{{ $p->name }}</td>
            <td>{{ $p->price }}</td>
            <td>{{ $p->size }}</td>
            <td>{{ $p->stock }}</td>
            <td>
                @if($p->image)
                    <img src="/storage/{{ $p->image }}" width="80">
                @endif
            </td>
            <td>
                @if(auth()->user()->role === 'admin')
                    <a href="/products/{{ $p->id }}/edit" class="text-blue-600">Edit</a>

                    <form action="/products/{{ $p->id }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600" onclick="return confirm('Hapus?')">
                            Hapus
                        </button>
                    </form>
                @endif
            </td>
        </tr>
        @endforeach
    </table>
</x-app-layout>


