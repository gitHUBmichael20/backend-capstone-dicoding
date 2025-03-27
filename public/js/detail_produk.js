document.addEventListener('DOMContentLoaded', () => {
    const data = JSON.parse(sessionStorage.getItem('detailProduk'));

    if (data) {
        document.querySelector('title').textContent = `Detail Produk ${data.nama_produk}`;
        document.getElementById('namaProduk').textContent = data.nama_produk;
        document.getElementById('biayaSewa').textContent = `Rp${data.biaya_sewa}/hari`;
        document.getElementById('deskripsiProduk').textContent = data.deskripsi;
        document.getElementById('kategori').textContent = `Kategori : ${data.kategori}`;
        document.getElementById('stokProduk').textContent = `Stok : ${data.stok}`;
        document.getElementById('cost').textContent = `Rp${data.biaya_sewa}`;
        document.getElementById('idProduk').value = data.produk_id;
        document.getElementById('durasiSewa').value = 1;
    }

    getUserId();

});

function tambahWaktuPeminjaman() {
    const rentalDays = document.getElementById('rentalDays');
    rentalDays.value++;
    updateDurasiPeminjamman();
    updateCost();
}

function kurangiWaktuPeminjaman() {
    const rentalDays = document.getElementById('rentalDays');
    if (rentalDays.value > 1) {
        rentalDays.value--;
        updateDurasiPeminjamman();
        updateCost();
    }
}

function updateDurasiPeminjamman() {
    const rentalDays = document.getElementById('rentalDays').value;
    document.getElementById('durasiSewa').value = rentalDays;
}

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
        console.log('ID User:', user.pengguna_id);
        document.getElementById('idPengguna').value = user.pengguna_id;
    } catch (error) {
        console.error('Gagal mengambil data user:', error);
    }
}

async function addToCart() {
    try {
        const response = await fetch('/api/add_produk', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${document.querySelector('meta[name="api-token"]').getAttribute('content')}`
            },
            body: JSON.stringify({
                id_pengguna: document.getElementById('idPengguna').value,
                id_produk: document.getElementById('idProduk').value,
                durasi_sewa: document.getElementById('durasiSewa').value
            })
        });

        const message = await response.json();

        if (response.ok) {
            Swal.fire({
                icon: 'success',
                title: message.message,
                showConfirmButton: false,
                timer: 1500
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: message.message,
                showConfirmButton: false,
                timer: 1500
            });
        }

    } catch (error) {
        console.error('Fetch error:', error);
    }
}

function updateCost() {
    const durasiSewa = parseInt(document.getElementById('rentalDays').value);
    const biayaSewa = parseInt(document.getElementById('biayaSewa').textContent.replace('Rp', '').replace(/\./g, ''));
    const totalBiaya = durasiSewa * biayaSewa;
    document.getElementById('cost').textContent = `Rp${totalBiaya}`;
}
