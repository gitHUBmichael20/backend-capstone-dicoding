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

    document.querySelector("title").textContent = `Detail Produk ${data.nama_produk}`;
    document.getElementById("namaProduk").textContent = data.nama_produk;
    document.getElementById("biayaSewa").textContent = `Rp${data.biaya_sewa.toLocaleString('id-ID')}/hari`;
    document.getElementById("deskripsiProduk").textContent = data.deskripsi;
    document.getElementById("kategori").textContent = `Kategori : ${data.kategori}`;
    document.getElementById("stokProduk").textContent = `Stok : ${data.stok}`;
    document.getElementById("cost").textContent = `Rp${data.biaya_sewa.toLocaleString('id-ID')}`;
    document.getElementById("idProduk").value = data.produk_id;
    document.getElementById("durasiSewa").value = 1;

    // Update gambar produk
    if (data && data.gambar_url) {
        imgElement.src = data.gambar_url;
        imgElement.alt = data.nama_produk;
        
        imgElement.onerror = function() {
            console.log('Gambar gagal dimuat, menggunakan fallback');
            this.src = '/storage/produk/no_image.png';
            this.classList.replace('object-scale-down', 'object-cover');
            this.onerror = null; 
        };
    } else {
        imgElement.src = '/storage/produk/no_image.png';
        imgElement.alt = 'Produk';
    }
}

function tambahWaktuPeminjaman() {
    const rentalDays = document.getElementById("rentalDays");
    rentalDays.value++;
    updateDurasiPeminjaman();
    updateCost();
}

function kurangiWaktuPeminjaman() {
    const rentalDays = document.getElementById("rentalDays");
    if (rentalDays.value > 1) {
        rentalDays.value--;
        updateDurasiPeminjaman();
        updateCost();
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

window.tambahWaktuPeminjaman = tambahWaktuPeminjaman;
window.kurangiWaktuPeminjaman = kurangiWaktuPeminjaman;
window.updateDurasiPeminjaman = updateDurasiPeminjaman;
window.addToCart = addToCart;
window.updateCost = updateCost;