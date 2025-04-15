import Swal from 'sweetalert2'; 

document.addEventListener("DOMContentLoaded", () => {
    const produkId = window.location.pathname.split('/').pop(); // Ambil ID dari /detail_produk/{id}

    if (!produkId || isNaN(produkId)) {
        console.error('ID produk tidak ditemukan di URL');
        document.querySelector('.container').innerHTML = `
            <div class="text-center text-gray-600">
                <p>ID produk tidak valid. Silakan kembali ke <a href="/" class="text-emerald-600 hover:underline">halaman utama</a>.</p>
            </div>
        `;
        return;
    }

    let data = JSON.parse(sessionStorage.getItem("detailProduk"));

    if (!data || data.produk_id != produkId) {
        fetch(`/api/produk/${produkId}`)
            .then(response => response.json())
            .then(result => {
                if (result.produk_id) {
                    sessionStorage.setItem('detailProduk', JSON.stringify(result));
                    displayProduk(result);
                } else {
                    console.error('Produk tidak ditemukan:', result.message);
                    document.querySelector('.container').innerHTML = `
                        <div class="text-center text-gray-600">
                            <p>Produk tidak ditemukan. Silakan kembali ke <a href="/" class="text-emerald-600 hover:underline">halaman utama</a>.</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Gagal mengambil data produk:', error);
                document.querySelector('.container').innerHTML = `
                    <div class="text-center text-gray-600">
                        <p>Gagal mengambil data produk. Silakan kembali ke <a href="/" class="text-emerald-600 hover:underline">halaman utama</a>.</p>
                    </div>
                `;
            });
    } else {
        displayProduk(data);
    }

    getUserId();
});

function displayProduk(data) {
    const imgElement = document.getElementById('gambarProduk');
    const addToCartButton = document.querySelector('button[onclick="addToCart()"]');
    const rentButton = document.querySelector('button[onclick="sendRentalData()"]');

    document.querySelector("title").textContent = `Detail Produk ${data.nama_produk}`;
    document.getElementById("namaProduk").textContent = data.nama_produk;
    document.getElementById("biayaSewa").textContent = `Rp${data.biaya_sewa.toLocaleString('id-ID')}/hari`;
    document.getElementById("deskripsiProduk").textContent = data.deskripsi;
    document.getElementById("kategori").textContent = `Kategori : ${data.kategori}`;
    document.getElementById("stokProduk").textContent = `Stok : ${data.stok}`;
    document.getElementById("cost").textContent = `Rp${data.biaya_sewa.toLocaleString('id-ID')}`;
    document.getElementById("idProduk").value = data.produk_id;
    document.getElementById("durasiSewa").value = 1;

    const stok = parseInt(data.stok);
    if (stok <= 0) {
        addToCartButton.disabled = true;
        rentButton.disabled = true;
        addToCartButton.classList.add('opacity-50', 'cursor-not-allowed');
        rentButton.classList.add('opacity-50', 'cursor-not-allowed');
        document.getElementById("stokProduk").classList.add('text-red-600');
    }

    imgElement.src = data.gambar_produk ? `/storage/produk/${data.gambar_produk}` : '/storage/produk/no_image.png';
    imgElement.alt = data.nama_produk;
    imgElement.onerror = function() {
        console.log('Gambar gagal dimuat, menggunakan fallback');
        this.src = '/storage/produk/no_image.png';
        this.classList.replace('object-scale-down', 'object-cover');
        this.onerror = null;
    };
}

function tambahWaktuPeminjaman() {
    const rentalDays = document.getElementById("rentalDays");
    rentalDays.value++;
    updateDurasiPeminjaman();
    updateCost();
    returnDate();
}

function kurangiWaktuPeminjaman() {
    const rentalDays = document.getElementById("rentalDays");
    if (rentalDays.value > 1) {
        rentalDays.value--;
        updateDurasiPeminjaman();
        updateCost();
        returnDate();
    }
}

function updateDurasiPeminjaman() {
    const rentalDays = document.getElementById("rentalDays").value;
    document.getElementById("durasiSewa").value = rentalDays;
}

async function getUserId() {
    try {
        const response = await fetch("/api/user", {
            method: "GET",
            headers: {
                Accept: "application/json",
                Authorization: `Bearer ${document
                    .querySelector('meta[name="api-token"]')
                    .getAttribute("content")}`,
            },
        });

        const user = await response.json();
        console.log("ID User:", user.pengguna_id);
        document.getElementById("idPengguna").value = user.pengguna_id;
    } catch (error) {
        console.error("Gagal mengambil data user:", error);
    }
}

async function addToCart() {
    const stok = parseInt(document.getElementById("stokProduk").textContent.replace('Stok : ', ''));
    if (stok <= 0) {
        Swal.fire({
            icon: "error",
            title: "Stok Habis",
            text: "Maaf, stok produk ini sudah habis. Silakan pilih produk lain.",
            showConfirmButton: true,
        });
        return;
    }
    try {
        const response = await fetch("/api/add_produk", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${document
                    .querySelector('meta[name="api-token"]')
                    .getAttribute("content")}`,
            },
            body: JSON.stringify({
                id_pengguna: document.getElementById("idPengguna").value,
                id_produk: document.getElementById("idProduk").value,
                durasi_sewa: document.getElementById("durasiSewa").value,
            }),
        });

        const message = await response.json();

        if (response.ok) {
            Swal.fire({
                icon: "success",
                title: message.message,
                showConfirmButton: false,
                timer: 1500,
            });
        } else {
            Swal.fire({
                icon: "error",
                title: message.message,
                showConfirmButton: false,
                timer: 1500,
            });
        }
    } catch (error) {
        console.error("Fetch error:", error);
    }
}

function updateCost() {
    const durasiSewa = parseInt(document.getElementById("rentalDays").value);
    const biayaSewa = parseInt(
        document
            .getElementById("biayaSewa")
            .textContent.replace("Rp", "")
            .replace(/\./g, "")
            .replace("/hari", "")
    );
    const totalBiaya = durasiSewa * biayaSewa;
    document.getElementById("cost").textContent = `Rp${totalBiaya.toLocaleString('id-ID')}`;
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
    const stok = parseInt(document.getElementById("stokProduk").textContent.replace('Stok : ', ''));
    if (stok <= 0) {
        Swal.fire({
            icon: "error",
            title: "Stok Habis",
            text: "Maaf, stok produk ini sudah habis. Silakan pilih produk lain.",
            showConfirmButton: true,
        });
        return;
    }
    
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

window.tambahWaktuPeminjaman = tambahWaktuPeminjaman;
window.kurangiWaktuPeminjaman = kurangiWaktuPeminjaman;
window.updateDurasiPeminjaman = updateDurasiPeminjaman;
window.addToCart = addToCart;
window.updateCost = updateCost;
window.currentDate = currentDate;
window.returnDate = returnDate;
window.sendRentalData = sendRentalData;