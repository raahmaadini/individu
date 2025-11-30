<x-app-layout>
<div class="p-6">

    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-semibold">Data Member</h2>

        {{-- Hanya admin yang boleh tambah --}}
        @unless(auth()->user()->role === 'owner')
        <button onclick="openCreateModal()" 
            class="bg-blue-600 text-white px-4 py-2 rounded">
            + Tambah Member
        </button>
        @endunless
    </div>

    <table class="w-full border">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="border px-3 py-2">Nama</th>
                <th class="border px-3 py-2">Email</th>
                <th class="border px-3 py-2">Phone</th>
                <th class="border px-3 py-2">Alamat</th>
                @if(auth()->user()->role === 'admin')
            <th>Aksi</th>
            @endif
            </tr>
        </thead>

        <tbody id="memberTable">
            <tr>
                <td colspan="5" class="text-center p-3">Loading...</td>
            </tr>
        </tbody>
    </table>

</div>

{{-- =================================================== --}}
{{-- MODAL CREATE --}}
{{-- =================================================== --}}
@unless(auth()->user()->role === 'owner')
<div id="createModal" 
    class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center">
    <div class="bg-white p-6 rounded w-1/3">
        <h3 class="text-lg font-semibold mb-3">Tambah Member</h3>

        <form id="createForm">
            <input name="name" type="text" placeholder="Nama" class="border p-2 w-full mb-2">
            <input name="email" type="email" placeholder="Email" class="border p-2 w-full mb-2">
            <input name="phone" type="text" placeholder="Phone" class="border p-2 w-full mb-2">
            <textarea name="address" placeholder="Alamat" class="border p-2 w-full mb-2"></textarea>

            <div class="flex justify-end gap-2 mt-3">
                <button type="button" onclick="closeCreateModal()" 
                        class="px-3 py-2 bg-gray-500 text-white rounded">
                    Batal
                </button>

                <button type="submit"
                        class="px-3 py-2 bg-blue-600 text-white rounded">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endunless


{{-- =================================================== --}}
{{-- MODAL EDIT --}}
{{-- =================================================== --}}
@unless(auth()->user()->role === 'owner')
<div id="editModal" 
    class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center">
    <div class="bg-white p-6 rounded w-1/3">
        <h3 class="text-lg font-semibold mb-3">Edit Member</h3>

        <form id="editForm">
            <input type="hidden" name="id">

            <input name="name" type="text" placeholder="Nama" class="border p-2 w-full mb-2">
            <input name="email" type="email" placeholder="Email" class="border p-2 w-full mb-2">
            <input name="phone" type="text" placeholder="Phone" class="border p-2 w-full mb-2">
            <textarea name="address" placeholder="Alamat" class="border p-2 w-full mb-2"></textarea>

            <div class="flex justify-end gap-2 mt-3">
                <button type="button" onclick="closeEditModal()" 
                        class="px-3 py-2 bg-gray-500 text-white rounded">
                    Batal
                </button>

                <button type="submit"
                        class="px-3 py-2 bg-blue-600 text-white rounded">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endunless


<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;

// helper: parse JSON safely
async function safeJson(res) {
    const txt = await res.text();
    try { return JSON.parse(txt); }
    catch (e) { return txt; }
}

/* ======================================================
   LOAD MEMBER DATA
====================================================== */
async function loadMembers() {
    try {
        const res = await fetch("/api/members", {
            headers: { "Accept": "application/json" }
        });

        const tbody = document.getElementById("memberTable");
        
        if (!res.ok) {
            tbody.innerHTML = `<tr><td colspan="5" class="text-center text-red-600">
                Gagal memuat data (status ${res.status})
            </td></tr>`;
            return;
        }

        const result = await res.json();
        tbody.innerHTML = "";

        (result.data ?? result).forEach(member => {
            tbody.innerHTML += `
                <tr>
                    <td class="border px-3 py-2">${member.name}</td>
                    <td class="border px-3 py-2">${member.email}</td>
                    <td class="border px-3 py-2">${member.phone}</td>
                    <td class="border px-3 py-2">${member.address ?? '-'}</td>
                    <td class="border px-3 py-2 space-x-2">

                        @unless(auth()->user()->role === 'owner')
                        <button onclick="openEditModal(${member.id})"
                            class="px-2 py-1 bg-yellow-500 hover:bg-yellow-600 text-black rounded">
                            Edit
                        </button>

                        <button onclick="deleteMember(${member.id})"
                            class="px-2 py-1 bg-red-600 hover:bg-red-700 text-white rounded">
                            Hapus
                        </button>
                        @endunless

                    </td>
                </tr>
            `;
        });

    } catch (err) {
        console.error(err);
    }
}
loadMembers();


/* ======================================================
   CREATE MEMBER (ADMIN ONLY)
====================================================== */
@unless(auth()->user()->role === 'owner')
function openCreateModal() {
    document.getElementById("createModal").classList.remove("hidden");
}
function closeCreateModal() {
    document.getElementById("createModal").classList.add("hidden");
}

document.getElementById("createForm")?.addEventListener("submit", async function(e) {
    e.preventDefault();
    const form = this;

    const payload = {
        name: form.name.value,
        email: form.email.value,
        phone: form.phone.value,
        address: form.address.value,
    };

    const res = await fetch("/api/members", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": CSRF,
            "Accept": "application/json"
        },
        body: JSON.stringify(payload)
    });

    if (!res.ok) {
        alert("Gagal menambah member");
        return;
    }

    alert("Member ditambahkan!");
    closeCreateModal();
    form.reset();
    loadMembers();
});
@endunless


/* ======================================================
   EDIT MEMBER (ADMIN ONLY)
====================================================== */
@unless(auth()->user()->role === 'owner')
async function openEditModal(id) {
    try {
        const res = await fetch(`/api/members/${id}`, {
            headers: { "Accept": "application/json" }
        });

        const data = await safeJson(res);
        if (!res.ok) return alert("Gagal memuat data member");

        const form = document.getElementById("editForm");
        form.id.value = data.data.id;
        form.name.value = data.data.name;
        form.email.value = data.data.email;
        form.phone.value = data.data.phone;
        form.address.value = data.data.address ?? "";

        document.getElementById("editModal").classList.remove("hidden");

    } catch (e) {
        alert("Error memuat data member");
    }
}

function closeEditModal() {
    document.getElementById("editModal").classList.add("hidden");
}

document.getElementById("editForm")?.addEventListener("submit", async function(e) {
    e.preventDefault();
    const form = this;

    const res = await fetch(`/api/members/${form.id.value}`, {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": CSRF,
            "Accept": "application/json"
        },
        body: JSON.stringify({
            name: form.name.value,
            email: form.email.value,
            phone: form.phone.value,
            address: form.address.value
        })
    });

    if (!res.ok) {
        alert("Gagal update member");
        return;
    }

    alert("Member diupdate!");
    closeEditModal();
    loadMembers();
});
@endunless


/* ======================================================
   DELETE MEMBER (ADMIN ONLY)
====================================================== */
@unless(auth()->user()->role === 'owner')
async function deleteMember(id) {
    if (!confirm("Hapus member ini?")) return;

    const res = await fetch(`/api/members/${id}`, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": CSRF,
            "Accept": "application/json"
        }
    });

    if (!res.ok) {
        alert("Gagal menghapus");
        return;
    }

    alert("Member dihapus!");
    loadMembers();
}
@endunless

</script>

</x-app-layout>
