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
                window.location.href = `/api/produk/${item.produk_id}`;
            });

            produkContainer.appendChild(produkDiv); // Tambahkan produk ke dalam kontainer
        });
    } catch (error) {
        console.error('Gagal mengambil data produk:', error);
    }
}

// Panggil fungsi ketika halaman sudah dimuat
document.addEventListener('DOMContentLoaded', fetchProduk);


