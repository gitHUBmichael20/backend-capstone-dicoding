document.addEventListener('DOMContentLoaded', () => {
    const data = JSON.parse(sessionStorage.getItem('detailProduk'));
    console.log(typeof data);

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
    returnDate();
}

function kurangiWaktuPeminjaman() {
    const rentalDays = document.getElementById('rentalDays');
    if (rentalDays.value > 1) {
        rentalDays.value--;
        updateDurasiPeminjamman();
        updateCost();
        returnDate();
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
        return user.pengguna_id;
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

function currentDate() {
    let today = new Date();
    return today;
}

function returnDate() {
    let today = currentDate();
    const duration = parseInt(document.getElementById('rentalDays').value);

    if (isNaN(duration) || duration <= 0) {
        console.error("Durasi peminjaman tidak valid.");
        return;
    }

    let returnDate = new Date(today);
    returnDate.setDate(today.getDate() + duration);

    let formattedToday = today.toISOString().split('T')[0];
    let formattedReturnDate = returnDate.toISOString().split('T')[0];

    document.getElementById('tanggalSewa').value = formattedToday;
    document.getElementById('tanggalPengembalian').value = formattedReturnDate;
}

async function sendRentalData() {
    const data = JSON.parse(sessionStorage.getItem('detailProduk'));
    const rentalData = {
        'id_pengguna' : await getUserId(),
        'id_produk' : data.produk_id,
        'nama_produk' : data.nama_produk,
        'harga' : data.biaya_sewa,
        'durasi' : parseInt(document.getElementById('durasiSewa').value),
        'tanggal_peminjaman' : document.getElementById('tanggalSewa').value,
        'tanggal_pengembalian' : document.getElementById('tanggalPengembalian').value,
        'biaya_sewa' : parseInt(document.getElementById('cost').textContent.replace('Rp', '').replace(/\./g, ''))
    };

    localStorage.setItem('rentalData', JSON.stringify(rentalData));

    window.location.href = '/confirm?page=detail';
}
