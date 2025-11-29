<x-app-layout>
<h1 class="text-2xl font-bold mb-4">Edit Produk</h1>

<form action="/products/{{ $product->id }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label>Nama Produk</label>
    <input name="name" value="{{ $product->name }}" class="border w-full mb-2">

    <label>Harga</label>
    <input name="price" value="{{ $product->price }}" class="border w-full mb-2">

    <label>Ukuran</label>
    <input name="size" value="{{ $product->size }}" class="border w-full mb-2">

    <label>Stock</label>
    <input name="stock" value="{{ $product->stock }}" class="border w-full mb-2">

    <label>Deskripsi</label>
    <textarea name="description" class="border w-full mb-2">{{ $product->description }}</textarea>

    <label>Gambar Produk</label>
    <input type="file" name="image" class="mb-4">

    @if($product->image)
    <p>Gambar Lama:</p>
    <img src="/storage/{{ $product->image }}" width="120">
    @endif

    <br><br>

    <button class="bg-green-600 text-white px-4 py-2">Update</button>
</form>
</x-app-layout>
