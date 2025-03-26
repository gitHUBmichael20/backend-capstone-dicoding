addEventListener('DOMContentLoaded', () => {
    sendIdUser();
});

async function getUserId() {
    try {
        const response = await fetch('/api/user', {
            method: 'GET',
            headers: {
                'Accept' : 'application/json',
                'Authorization': `Bearer ${document.querySelector('meta[name="api-token"]').getAttribute('content')}`
            }
        });

        const user = await response.json();
        return user.pengguna_id;
    } catch (error) {
        console.error('Gagal mengambil data user:', error);
        return null;
    }
}

async function sendIdUser() {
    const idPengguna = await getUserId();
    const response = await fetch (`/api/keranjang/${idPengguna}`);
    const data = await response.json();

    data.forEach(item => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
        <td>${item.keranjang_id}</td>
        <td>${item.nama_produk}</td>
        <td>${item.biaya_sewa}</td>
        <td>${item.jumlah} days</td>
        <td>${item.biaya_sewa * item.jumlah}</td>
        <td>
        <button type="button" onclick="deleteKeranjang(${item.keranjang_id})" class="btn btn-sm btn-danger">Hapus</button>
        </td>
        `;
        keranjangBody.appendChild(tr);
    });

    const totalSeluruhHarga = data
        .map(item => item.biaya_sewa * item.jumlah)
        .reduce((total, nilai) => total + nilai, 0);

    document.getElementById('totalHarga').textContent = `Rp ${totalSeluruhHarga || 0}`;


}

async function deleteKeranjang($idKeranjang) {
    try {
        const response = await fetch(`/api/keranjang/item/${$idKeranjang}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${document.querySelector('meta[name="api-token"]').getAttribute('content')}`
            }
        });
        const data = await response.json();
        if (response.ok) {
            Swal.fire({
                icon: 'success',
                title: data.message,
                showConfirmButton: false,
                timer: 1500
            });
            location.reload();
        } else {
            Swal.fire({
                icon: 'error',
                title: data.message,
                showConfirmButton: false,
                timer: 1500
            });
        }
        console.log(data);
    } catch (error) {
        console.error('Gagal menghapus keranjang:', error);
    }
}

async function deleteAll() {
    const idUser = await getUserId();
    const response = await fetch(`/api/keranjang/all_item/${idUser}`, {
        method: 'DELETE',
        headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${document.querySelector('meta[name="api-token"]').getAttribute('content')}`
        }
    });
    const data = await response.json();
    if (response.ok) {
        Swal.fire({
            icon: 'success',
            title: data.message,
            showConfirmButton: false,
            timer: 1500
        });
        location.reload();
    } else {
        Swal.fire({
            icon: 'error',
            title: data.message,
            showConfirmButton: false,
            timer: 1500
        });
    }
    console.log(data);
}

// function renderKeranjang(data) {
//     const body = document.getElementById('container');
//     const keranjangBody = document.getElementById('keranjangContainer');

//     // Kosongkan isi tabel sebelum diisi ulang
//     keranjangBody.innerHTML = "";

//     if (data.length === 0) {
//         body.innerHTML = `
//         <div class="alert alert-info" id="keranjangKosong">
//             Keranjang belanja Anda kosong.
//             <a href="/landing" class="alert-link">Kembali berbelanja</a>.
//         </div>`;
//         return;
//     }

//     data.forEach(item => {
//         const tr = document.createElement('tr');
//         tr.innerHTML = `
//         <td>${item.keranjang_id}</td>
//         <td>${item.nama_produk}</td>
//         <td>${item.biaya_sewa}</td>
//         <td>${item.jumlah} days</td>
//         <td>${item.biaya_sewa * item.jumlah}</td>
//         <td>
//         <button type="button" onclick="deleteKeranjang(${item.keranjang_id})" class="btn btn-sm btn-danger">Hapus</button>
//         </td>
//         `;
//         keranjangBody.appendChild(tr);
//     });

//     const totalSeluruhHarga = data
//         .map(item => item.biaya_sewa * item.jumlah)
//         .reduce((total, nilai) => total + nilai, 0);

//     document.getElementById('totalHarga').textContent = `Rp ${totalSeluruhHarga || 0}`;
// }
