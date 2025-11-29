<x-app-layout>
<h1 class="text-2xl font-bold mb-4">Tambah Produk</h1>

<form action="/products" method="POST" enctype="multipart/form-data">
    @csrf

    <label>Nama Produk</label>
    <input name="name" class="border w-full mb-2">

    <label>Harga</label>
    <input name="price" class="border w-full mb-2">

    <label>Ukuran (S/M/L/XL)</label>
    <input name="size" class="border w-full mb-2">

    <label>Stock</label>
    <input name="stock" class="border w-full mb-2">

    <label>Deskripsi</label>
    <textarea name="description" class="border w-full mb-2"></textarea>

    <label>Gambar Produk</label>
    <input type="file" name="image" class="mb-4">

    <button class="bg-blue-600 text-white px-4 py-2">Simpan</button>
</form>
</x-app-layout>
