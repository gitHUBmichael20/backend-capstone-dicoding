<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="{{ asset('js/detail_produk.js') }}"></script>
    <title>Detail Produk - {{ $produk->nama_produk }} | SatoeRental</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow-md sticky top-0 z-40">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a href="/" class="text-2xl font-bold text-emerald-600">SatoeRental</a>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex space-x-8">
                    <a href="/" class="text-gray-600 hover:text-emerald-600 transition">Beranda</a>
                    <a href="/categories" class="text-gray-600 hover:text-emerald-600 transition">Kategori</a>
                    <a href="/products" class="text-emerald-600 font-medium transition">Produk</a>
                    <a href="/about" class="text-gray-600 hover:text-emerald-600 transition">Tentang Kami</a>
                    <a href="/contact" class="text-gray-600 hover:text-emerald-600 transition">Kontak</a>
                </nav>

                <!-- Desktop Actions -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="/search" class="text-gray-600 hover:text-emerald-600 transition">
                        <i class="fas fa-search"></i>
                    </a>
                    <a href="/cart" class="text-gray-600 hover:text-emerald-600 transition relative">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="absolute -top-2 -right-2 bg-emerald-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
                    </a>
                    @if(auth()->check())
                        <button id="logout" class="bg-emerald-600 text-white py-2 px-4 rounded-md hover:bg-emerald-700 transition">Logout</button>
                    @else
                        <a href="/login" class="text-gray-600 hover:text-emerald-600 transition">Masuk</a>
                        <a href="/register" class="bg-emerald-600 text-white py-2 px-4 rounded-md hover:bg-emerald-700 transition">Daftar</a>
                    @endif
                </div>

                <!-- Mobile Menu Button -->
                <button class="md:hidden text-gray-600" id="open-menu">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Product Image -->
            <div class="relative">
                <div class="relative h-96 overflow-hidden rounded-lg">
                    <div class="absolute top-3 left-3 bg-blue-500 text-white text-xs font-semibold py-1 px-2.5 rounded-full z-10">New</div>
                    <div class="absolute top-3 left-20 bg-red-500 text-white text-xs font-semibold py-1 px-2.5 rounded-full z-10">-20%</div>
                    <img src="{{ $produk->gambar_produk ? asset('storage/produk/' . $produk->gambar_produk) : asset('storage/produk/no_image.png') }}" alt="{{ $produk->nama_produk }}" class="w-full h-full object-cover transition-transform duration-300 hover:scale-105" onerror="this.src='{{ asset('storage/produk/no_image.png') }}'">

                </div>
            </div>

            <!-- Product Info -->
            <div>
                <h1 class="text-3xl font-bold text-gray-800 leading-tight mb-2" id="namaProduk"></h1>

                <div class="flex items-center mb-4">
                    <div class="text-yellow-400 flex">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <div class="text-gray-600 text-sm ml-2">4.5 (128 reviews)</div>
                </div>

                <div class="mb-6">
                    <span class="text-3xl font-bold text-emerald-600" id="biayaSewa"></span>
                </div>

                <div class="text-gray-600 mb-6">
                    <p>{{ $produk->deskripsi ?? 'Tidak ada deskripsi tersedia.' }}</p>
                    <p id="deskripsiProduk"></p>
       zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                    <div class="flex items-center">
                        <div class="text-gray-600" id="kategori"></div>
                    </div>
                    <div class="flex items-center">
        zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz
                        <div class="text-gray-600">Stok: {{ $produk->stok > 0 ? $produk->stok . ' unit tersedia' : 'Stok habis' }}</div>
                        <div class="text-gray-600" id="stokProduk"></div>
                    </div>
                </div>

                <div class="mb-8">
                    <div class="flex items-center mb-4">
                        <div class="text-gray-700 mr-3">Rental Days:</div>
                        <div class="flex items-center border border-gray-300 rounded-md overflow-hidden">
                            <button class="bg-gray-100 hover:bg-gray-200 px-3 py-1.5 transition-colors" onclick="kurangiWaktuPeminjaman()">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="text" id="rentalDays" value="1" class="w-16 text-center border-0 py-1.5 focus:outline-none" readonly>
                            <button class="bg-gray-100 hover:bg-gray-200 px-3 py-1.5 transition-colors" onclick="tambahWaktuPeminjaman()">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="font-medium text-gray-700">Total rental cost: <span id="cost" class="font-semibold text-emerald-600"></span></div>
                </div>

                <div class="flex flex-col md:flex-row gap-4">
                    @if($produk->stok > 0)
                        <a href="/cart/add/{{ $produk->produk_id }}" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-3 px-6 rounded-md flex items-center justify-center transition-colors">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            Add to Cart
                        </a>
                    @else
                        <button class="flex-1 bg-gray-400 text-white font-medium py-3 px-6 rounded-md flex items-center justify-center cursor-not-allowed" disabled>
                            <i class="fas fa-shopping-cart mr-2"></i>
                            Stok Habis
                        </button>
                    @endif
                    zzzzzzzzzzzzzzzzz
                    <form  class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-black font-medium py-3 px-6 rounded-md flex items-center justify-center transition-colors">
                        <input type="hidden" id="idPengguna">
                        <input type="hidden" id="idProduk">
                        <input type="hidden" id="durasiSewa">
                        <button type="button" class="flex items-center" onclick="addToCart()">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            Add to Cart
                        </button>
                    </form>
                    <a href="#" class="flex-1 bg-emerald-100 text-emerald-600 border border-emerald-600 font-medium py-3 px-6 rounded-md flex items-center justify-center hover:bg-emerald-200 transition-colors">
                        <i class="far fa-heart mr-2"></i>
                        Wishlist
                    </a>
                </div>
            </div>
        </div>

        <!-- Product Tabs -->
        <div class="mt-12 border-t border-gray-200">
            <div class="flex border-b border-gray-200">
                <div class="py-3 px-6 font-medium text-emerald-600 border-b-2 border-emerald-600 cursor-pointer">Description</div>
                <div class="py-3 px-6 font-medium text-gray-600 border-b-2 border-transparent hover:text-emerald-600 cursor-pointer">Specifications</div>
                <div class="py-3 px-6 font-medium text-gray-600 border-b-2 border-transparent hover:text-emerald-600 cursor-pointer">Reviews</div>
                <div class="py-3 px-6 font-medium text-gray-600 border-b-2 border-transparent hover:text-emerald-600 cursor-pointer">Shipping</div>
            </div>

            <div class="py-6">
                <p class="text-gray-600 leading-relaxed">{{ $produk->deskripsi ?? 'Tidak ada deskripsi tersedia.' }}</p>
                <p class="text-gray-600 leading-relaxed"></p>
                zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz
            </div>
        </div>

        <!-- Related Products -->
        {{-- <div class="mt-12">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">You Might Also Like</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @forelse($relatedProducts as $related)
                    <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg hover:-translate-y-1 transition-all">
                        <div class="h-48 relative">
                            <img src="{{ $related->gambar_produk ? asset('storage/produk/' . $related->gambar_produk) : asset('storage/produk/no_image.png') }}" alt="{{ $related->nama_produk }}" class="w-full h-full object-cover" onerror="this.src='{{ asset('storage/produk/no_image.png') }}'">
                            <div class="absolute top-2 right-2 bg-red-500 text-white text-xs font-semibold py-1 px-2 rounded-full">-15%</div>
                        </div>
                        <div class="p-4">
                            <h4 class="text-lg font-semibold text-gray-800 truncate mb-1">{{ $related->nama_produk }}</h4>
                            <div class="flex items-center mb-2">
                                <div class="text-yellow-400 text-sm">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <div class="text-xs text-gray-600 ml-1">(98)</div>
                            </div>
                            <div class="flex justify-between items-center">
                                <div class="font-semibold text-emerald-600">
                                    Rp{{ number_format($related->biaya_sewa, 0, ',', '.') }}/hari
                                </div>
                                <div class="text-emerald-600 p-2 rounded-full hover:bg-emerald-50 transition-colors">
                                    <i class="far fa-heart"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600">Tidak ada produk terkait yang tersedia.</p>
                @endforelse
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white pt-12 pb-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">SatoeRental</h3>
                    <p class="text-gray-400 mb-4">Solusi praktis untuk kebutuhan peralatan rumah tangga Anda. Sewa alat berkualitas dengan harga terjangkau.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-4">Kategori</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Peralatan Dapur</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Peralatan Kebersihan</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Perabotan</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Elektronik</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Dekorasi</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-4">Bantuan</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Cara Menyewa</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Pembayaran</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Pengiriman</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Pengembalian</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">FAQ</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-4">Kontak Kami</h3>
                    <ul class="space-y-2">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-2 text-emerald-400"></i>
                            <span class="text-gray-400">Jl. Raya Sewa No.123, Jakarta Selatan</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-phone-alt mt-1 mr-2 text-emerald-400"></i>
                            <span class="text-gray-400">(021) 123-4567</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-envelope mt-1 mr-2 text-emerald-400"></i>
                            <span class="text-gray-400">info@SatoeRental.com</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-clock mt-1 mr-2 text-emerald-400"></i>
                            <span class="text-gray-400">Senin - Sabtu: 08.00 - 20.00</span>
                        </li>
                    </ul>
                </div>
            </div>

            <hr class="border-gray-700 my-8">

            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 mb-4 md:mb-0">© 2025 SatoeRental. Hak Cipta Dilindungi.</p>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white transition">Syarat & Ketentuan</a>
                    <a href="#" class="text-gray-400 hover:text-white transition">Kebijakan Privasi</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile Menu (Hidden by default) -->
    <div class="fixed inset-0 bg-gray-900 bg-opacity-90 z-50 hidden" id="mobile-menu">
        <div class="flex justify-end p-4">
            <button class="text-white text-2xl" id="close-menu">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="flex flex-col items-center justify-center h-full space-y-8 text-xl">
            <a href="/" class="text-white hover:text-emerald-400 transition">Beranda</a>
            <a href="/categories" class="text-white hover:text-emerald-400 transition">Kategori</a>
            <a href="/products" class="text-emerald-400 font-medium transition">Produk</a>
            <a href="/about" class="text-white hover:text-emerald-400 transition">Tentang Kami</a>
            <a href="/contact" class="text-white hover:text-emerald-400 transition">Kontak</a>
            <div class="pt-6 border-t border-gray-700 flex flex-col items-center space-y-4 w-1/2">
                @if(auth()->check())
                    <button id="mobile-logout" class="bg-emerald-600 text-white hover:text-emerald-400 transition w-full text-center">Logout</button>
                @else
                    <a href="/login" class="text-white hover:text-emerald-400 transition w-full text-center">Masuk</a>
                    <a href="/register" class="bg-emerald-600 text-white py-2 px-4 rounded-md hover:bg-emerald-700 transition w-full text-center">Daftar</a>
                @endif
            </div>
        </div> --}}
    </div>
    <!-- JavaScript -->
    <script>
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
                    sessionStorage.removeItem('api_token');
                    localStorage.removeItem('user_id');
                    window.location.href = '/landing';
                })
                .catch(error => {
                    console.error('Error logging out:', error.response ? error.response.data : error.message);
                    sessionStorage.removeItem('api_token');
                    localStorage.removeItem('user_id');
                    window.location.href = '/';
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
                    sessionStorage.removeItem('api_token');
                    localStorage.removeItem('user_id');
                    window.location.href = '/login';
                })
                .catch(error => {
                    console.error('Error logging out (mobile):', error.response ? error.response.data : error.message);
                    sessionStorage.removeItem('api_token');
                    localStorage.removeItem('user_id');
                    window.location.href = '/login';
                });
            });
        }
        // Fungsi untuk menghitung total biaya sewa
        const biayaSewa = {{ $produk->biaya_sewa }};
        let rentalDays = 3;

        function updateRentalDays(change) {
            rentalDays = Math.max(1, rentalDays + change); // Minimal 1 hari
            document.getElementById('rental-days').value = rentalDays;
            const totalCost = biayaSewa * rentalDays;
            document.getElementById('total-cost').textContent = 'Rp' + totalCost.toLocaleString('id-ID');
        }
    </script> --}}
</body>
</html>
