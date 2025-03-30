import Swal from 'sweetalert2';

window.Swal = Swal;

async function fetchProduk() {
    try {
        // Ambil nilai filter dari elemen
        const kategori = document.getElementById('filter-kategori').value;
        const hargaMin = document.getElementById('harga-min').value;
        const hargaMax = document.getElementById('harga-max').value;
        const sort = document.getElementById('sort-option').value;

        // Buat query string untuk parameter filter
        const params = new URLSearchParams();
        if (kategori) params.append('kategori', kategori);
        if (hargaMin) params.append('harga_min', hargaMin);
        if (hargaMax) params.append('harga_max', hargaMax);
        if (sort) params.append('sort', sort);

        // Kirim permintaan ke API dengan parameter filter
        const response = await fetch(`/api/produk?${params.toString()}`);
        const data = await response.json();
        const produkContainer = document.getElementById('containerProduk');
        const productCount = document.getElementById('product-count');
        produkContainer.innerHTML = '';
        productCount.textContent = `Menampilkan ${data.length} dari ${data.length} produk`;

        data.forEach(item => {
            const produkDiv = document.createElement('div');
            produkDiv.classList.add(
                'bg-white', 
                'rounded-lg', 
                'shadow-md', 
                'overflow-hidden', 
                'hover:shadow-lg', 
                'transition', 
                'cursor-pointer', 
                'flex', 
                'flex-col', 
                'w-full', 
                'max-w-sm',
                'h-[330px]'
            );
            produkDiv.id = `produk-${item.produk_id}`;
            produkDiv.innerHTML = `
                <div class="relative w-full h-48 overflow-hidden">
                    <img src="${item.gambar_produk ? '/storage/produk/' + item.gambar_produk : '/storage/produk/no_image.png'}" alt="${item.nama_produk}" class="w-full h-full object-cover object-center border border-gray-300 rounded-md" loading="lazy" onerror="this.src='/storage/produk/no_image.png'">
                    <span class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded-md text-sm font-medium">Promo</span>
                    <span class="absolute bottom-0 left-0 text-black px-2 py-1 rounded-md text-sm font-medium">Stok : ${item.stok}</span>
                </div>
                <div class="p-3 flex flex-col flex-1">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 truncate">${item.nama_produk}</h3>
                        <div class="flex text-yellow-400 my-1">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <span class="ml-1 text-gray-600 text-sm">(48)</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-1 truncate">${item.kategori}</p>
                    </div>
                    <p class="text-emerald-600 font-bold mt-2 items-center">Rp${item.biaya_sewa.toLocaleString('id-ID')}/hari</p>
                </div>
            `;
            produkDiv.addEventListener('click', () => {
                fetchDetailProduk(item.produk_id);
            });

            produkContainer.appendChild(produkDiv);
        });

        if (data.length === 0) {
            produkContainer.innerHTML = '<p class="text-gray-600 text-center">Belum ada produk yang tersedia.</p>';
        }
    } catch (error) {
        console.error('Gagal mengambil data produk:', error);
    }
}

// Tambahkan event listener untuk filter dan sorting
document.addEventListener('DOMContentLoaded', () => {
    fetchProduk(); // Panggil saat halaman dimuat

    // Filter Kategori
    document.getElementById('filter-kategori').addEventListener('change', fetchProduk);

    // Filter Harga
    document.getElementById('harga-min').addEventListener('input', fetchProduk);
    document.getElementById('harga-max').addEventListener('input', fetchProduk);

    // Sorting
    document.getElementById('sort-option').addEventListener('change', fetchProduk);
});

async function fetchDetailProduk(produkId) {
    try {
        const response = await fetch(`/api/produk/${produkId}`);
        const data = await response.json();

        if (response.ok) {
            sessionStorage.setItem('detailProduk', JSON.stringify(data));
            window.location.href = `/detail_produk/${produkId}`;
        } else {
            console.error('Gagal mengambil detail produk:', data.message);
        }
    } catch (error) {
        console.error('Fetch error:', error);
    }
}

window.fetchDetailProduk = fetchDetailProduk;

// Toggle Mobile Menu
const openMenu = document.getElementById('open-menu');
const closeMenu = document.getElementById('close-menu');
const mobileMenu = document.getElementById('mobile-menu');

openMenu.addEventListener('click', () => {
    mobileMenu.classList.remove('hidden');
});

closeMenu.addEventListener('click', () => {
    mobileMenu.classList.add('hidden');
});

// Logout (Desktop)
const logoutButton = document.getElementById('logout');
if (logoutButton) {
    logoutButton.addEventListener('click', function() {
        const token = "{{ session('api_token') }}";
        console.log('Attempting logout with token:', token);

        if (!token) {
            console.log('No token found, redirecting to login');
            window.location.href = '/login';
            return;
        }

        axios.post('/logout', {}, {
            headers: { 'Authorization': 'Bearer ' + token }
        })
        .then(response => {
            console.log('Logout success:', response.data);
            // Hapus token dari session di sisi client
            sessionStorage.removeItem('api_token');
            localStorage.removeItem('user_id');
            window.location.href = '/landing';
        })
        .catch(error => {
            console.error('Error logging out:', error.response ? error.response.data : error.message);
            // Jika gagal, tetap hapus token dan redirect
            sessionStorage.removeItem('api_token');
            localStorage.removeItem('user_id');
            window.location.href = '/landing';
        });
    });
}

// Logout (Mobile)
const mobileLogoutButton = document.getElementById('mobile-logout');
if (mobileLogoutButton) {
    mobileLogoutButton.addEventListener('click', function() {
        const token = "{{ session('api_token') }}";
        console.log('Attempting mobile logout with token:', token);

        if (!token) {
            console.log('No token found, redirecting to login');
            window.location.href = '/login';
            return;
        }

        axios.post('/logout', {}, {
            headers: { 'Authorization': 'Bearer ' + token }
        })
        .then(response => {
            console.log('Mobile logout success:', response.data);
            // Hapus token dari session di sisi client
            sessionStorage.removeItem('api_token');
            localStorage.removeItem('user_id');
            window.location.href = '/landing';
        })
        .catch(error => {
            console.error('Error logging out (mobile):', error.response ? error.response.data : error.message);
            // Jika gagal, tetap hapus token dan redirect
            sessionStorage.removeItem('api_token');
            localStorage.removeItem('user_id');
            window.location.href = '/landing';
        });
    });
}

// Ambil data user (opsional, hanya jika user login)
const token = "{{ session('api_token') }}";
if (token) {
    axios.get('/api/user', {
        headers: { 'Authorization': 'Bearer ' + token }
    })
    .then(response => {
        document.getElementById('user-data').innerHTML = `Email: ${response.data.email} | Nomor Telepon: ${response.data.nomor_telepon}`;
    })
    .catch(error => console.error('Error fetching user:', error));
}

// Ambil produk
if (token) {
    axios.get('/api/produk', {
        headers: { 'Authorization': 'Bearer ' + token }
    })
    .then(response => {
        const container = document.getElementById('containerProduk');
    })
    .catch(error => console.error('Error fetching products:', error));
}



// async function fetchProduk() {
    //     try {
    //         const token = "{{ session('api_token') }}";
    //         const response = await axios.get('/api/produk', {
    //             headers: { 'Authorization': 'Bearer ' + token }
    //         });
    //         const data = response.data; // Parsing response sebagai JSON
    //         console.log(data); // Debug: cek data dari API
    //         const produkContainer = document.getElementById('containerProduk');

    //         produkContainer.innerHTML = ''; // Kosongkan kontainer sebelum menambahkan produk baru

    //         data.forEach(item => {
    //             const produkDiv = document.createElement('div');
    //             produkDiv.classList.add(
    //                 'bg-white',
    //                 'rounded-lg',
    //                 'shadow-md',
    //                 'overflow-hidden',
    //                 'hover:shadow-lg',
    //                 'transition',
    //                 'cursor-pointer',
    //                 'flex',
    //                 'flex-col',
    //                 'w-full',
    //                 'max-w-sm', // Lebar card (384px)
    //                 'h-[350px]' // Tinggi tetap untuk card
    //             );
    //             produkDiv.id = `produk-${item.produk_id}`;
    //             produkDiv.innerHTML = `
    //                 <div class="relative w-full h-48 overflow-hidden">
    //                     <img src="${item.gambar_produk ? '/storage/produk/' + item.gambar_produk : '/storage/produk/no_image.png'}" alt="${item.nama_produk}" class="w-full h-full object-cover object-center border border-gray-300 rounded-md" loading="lazy" onerror="this.src='/storage/produk/no_image.png'">
    //                     <span class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded-md text-sm font-medium">Promo</span>
    //                 </div>
    //                 <div class="p-3 flex flex-col flex-1">
    //                     <div>
    //                         <h3 class="text-lg font-bold text-gray-800 truncate">${item.nama_produk}</h3>
    //                         <div class="flex text-yellow-400 my-1">
    //                             <i class="fas fa-star"></i>
    //                             <i class="fas fa-star"></i>
    //                             <i class="fas fa-star"></i>
    //                             <i class="fas fa-star"></i>
    //                             <i class="fas fa-star-half-alt"></i>
    //                             <span class="ml-1 text-gray-600 text-sm">(48)</span>
    //                         </div>
    //                         <p class="text-sm text-gray-600 mb-1 truncate">${item.kategori}</p>
    //                     </div>
    //                         <p class="text-emerald-600 font-bold mt-2 items-center">Rp${item.biaya_sewa}/hari</p>
    //                 </div>
    //             `;

    //             produkDiv.addEventListener('click', () => {
    //                 window.location.href = `/detail-produk/${item.produk_id}`;
    //             });

    //             produkContainer.appendChild(produkDiv); // Tambahkan produk ke dalam kontainer
    //         });

    //         if (data.length === 0) {
    //             produkContainer.innerHTML = '<p class="text-gray-600 text-center">Belum ada produk yang tersedia.</p>';
    //         }
    //     } catch (error) {
    //         console.error('Gagal mengambil data produk:', error);
    //     }
    // }

    // // Panggil fungsi ketika halaman sudah dimuat
    // document.addEventListener('DOMContentLoaded', fetchProduk);

document.addEventListener('DOMContentLoaded', fetchProduk);



