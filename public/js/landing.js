async function fetchProduk() {
    try {
        const response = await fetch('/api/produk');
        const data = await response.json();  // Parsing response sebagai JSON
        const produkContainer = document.getElementById('containerProduk');

        produkContainer.innerHTML = '';  // Kosongkan kontainer sebelum menambahkan produk baru

        data.forEach(item => {
            const produkDiv = document.createElement('div');
            produkDiv.classList.add('bg-white', 'rounded-lg', 'shadow-md', 'overflow-hidden', 'hover:shadow-lg', 'transition', 'cursor-pointer');
            produkDiv.id = `produk-${item.produk_id}`;
            produkDiv.innerHTML = `
                    <div class="relative">
                        <img src="/api/placeholder/300/200" alt="${item.nama_produk}" class="w-full h-48 object-cover">
                        <span class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded-md text-sm font-medium">Promo</span>
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-gray-800">${item.nama_produk}</h3>
                        <div class="flex text-yellow-400 my-1">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <span class="ml-1 text-gray-600 text-sm">(48)</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">${item.kategori}</p>
                        <div class="flex justify-between items-center mt-3">
                            <p class="text-emerald-600 font-bold">Rp${item.biaya_sewa}/hari</p>
                            <button class="bg-emerald-600 text-white px-3 py-1 rounded-md hover:bg-emerald-700 transition">+ Keranjang</button>
                        </div>
                    </div>
                </div>
            `;

            produkDiv.addEventListener('click', () => {
                fetchDetailProduk(item.produk_id);
            });

            produkContainer.appendChild(produkDiv); // Tambahkan produk ke dalam kontainer
        });

        if (data.length === 0) {
            produkContainer.innerHTML = '<p class="text-gray-600 text-center">Belum ada produk yang tersedia.</p>';
        }
    } catch (error) {
        console.error('Gagal mengambil data produk:', error);
    }
}

// Panggil fungsi ketika halaman sudah dimuat
async function fetchDetailProduk(produkId) {
    try {
        const response = await fetch (`api/produk/${produkId}`);
        const data = await response.json();
        sessionStorage.setItem('detailProduk', JSON.stringify(data));
        window.location.href = '/detail_produk';
    } catch (error) {

    }
}

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

// Autentikasi dan API
const token = document.querySelector('meta[name="api-token"]').getAttribute('content');
console.log('Token in landing:', token);

// Ambil data user
if (token) {
    axios.get('/api/user', {
        headers: { 'Authorization': 'Bearer ' + token }
    })
    .then(response => {
        document.getElementById('user-data').innerHTML = `Email: ${response.data.email} | Nomor Telepon: ${response.data.nomor_telepon}`;
        console.log('User data:', response.data);
    })
    .catch(error => console.error('Error fetching user:', error));
}

// Logout (Desktop)
const logoutButton = document.getElementById('logout');
if (logoutButton) {
    logoutButton.addEventListener('click', function() {
        axios.post('/api/logout', {}, {
            headers: { 'Authorization': 'Bearer ' + token }
        })
        .then(response => {
            window.location.href = '/login';
        })
        .catch(error => console.error('Error logging out:', error));
    });
}

// Logout (Mobile)
const mobileLogoutButton = document.getElementById('mobile-logout');
if (mobileLogoutButton) {
    mobileLogoutButton.addEventListener('click', function() {
        axios.post('/api/logout', {}, {
            headers: { 'Authorization': 'Bearer ' + token }
        })
        .then(response => {
            window.location.href = '/login';
        })
        .catch(error => console.error('Error logging out:', error));
    });
}

// Ambil produk
if (token) {
    axios.get('/api/produk', {
        headers: { 'Authorization': 'Bearer ' + token }
    })
    .then(response => {
        const container = document.getElementById('containerProduk');
        // Misalnya response.data adalah array produk
        // Tambah logika untuk render produk di sini
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



