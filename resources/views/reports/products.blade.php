<x-app-layout>
    <div class="p-6">
        <h2 class="text-xl mb-4">Laporan Produk (RESTful API)</h2>

        <table class="table-auto w-full border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-3 py-2">No</th>
                    <th class="border px-3 py-2">Nama</th>
                    <th class="border px-3 py-2">Stok</th>
                    <th class="border px-3 py-2">Harga</th>
                </tr>
            </thead>
            <tbody id="productTable">
                <tr><td colspan="4" class="text-center">Loading...</td></tr>
            </tbody>
        </table>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            fetch("/api/products")
                .then(res => res.json())
                .then(result => {
                    const tbody = document.getElementById("productTable");
                    tbody.innerHTML = "";

                    result.data.forEach((item, index) => {
                        tbody.innerHTML += `
                            <tr>
                                <td class="border px-3 py-2 text-center">${index + 1}</td>
                                <td class="border px-3 py-2">${item.name}</td>
                                <td class="border px-3 py-2 text-center">${item.stock}</td>
                                <td class="border px-3 py-2">Rp ${item.price}</td>
                            </tr>
                        `;
                    });
                });
        });
    </script>
</x-app-layout>
