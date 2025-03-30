<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="api-token" content="{{ session('api_token') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    {{-- <script src="{{ asset('js/landing.js') }}"></script> --}}
    <title>Welcome To Pinjam Satoe</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/landing.js'])
</head>
<body>
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        </script>
    @endif
    <section class="h-screen bg-center bg-no-repeat bg-[url('https://flowbite.s3.amazonaws.com/docs/jumbotron/conference.jpg')] bg-gray-700 bg-blend-multiply">
        <div class="px-4 mx-auto max-w-screen-xl text-center py-24 lg:py-56">
            <h1 class="mb-4 text-3xl font-bold tracking-tight leading-none text-white md:text-4xl lg:text-5xl">Selamat datang, {{ auth()->user() ? auth()->user()->nama_pengguna ?? 'pengguna' : 'pengguna' }}</h1>
            <h2 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl">
                "PALUGADA" Apapun lu mau gw ada. Pinjam apapun disini</h2>
            <p class="mb-8 text-lg font-normal text-gray-300 lg:text-xl sm:px-16 lg:px-48">
                Here at Flowbite we focus on markets where technology, innovation, and capital can unlock long-term value and drive economic growth.
            </p>
            <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0">
                <a href="#dashboard" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
                    Get started
                    <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                    </svg>
                </a>
                <a href="#" class="inline-flex justify-center hover:text-gray-900 items-center py-3 px-5 sm:ms-4 text-base font-medium text-center text-white rounded-lg border border-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-400">
                    Learn more
                </a>
            </div>
        </div>
    </section>

    <section class="bg-gray-100" id="dashboard">
        <header class="bg-white shadow-md sticky top-0 z-40">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center py-4">
                    <a href="/" class="text-2xl font-bold text-emerald-600">SatoeRental</a>

                    <!-- Desktop Navigation -->
                    <nav class="hidden md:flex space-x-8">
                        <a href="/" class="text-gray-600 hover:text-emerald-600 transition">Beranda</a>
                        <a href="/products" class="text-emerald-600 font-medium transition">Produk</a>
                        <a href="/about" class="text-gray-600 hover:text-emerald-600 transition">Tentang Kami</a>
                    </nav>

                    <!-- Desktop Actions -->
                    <div class="hidden md:flex items-center space-x-4">
                        <a href="/search" class="text-gray-600 hover:text-emerald-600 transition">
                            <i class="fas fa-search"></i>
                        </a>
                        <a href="{{ route('keranjang') }}" class="text-gray-600 hover:text-emerald-600 transition relative">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="absolute -top-2 -right-2 bg-emerald-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
                        </a>
                        @if(auth()->check())
                        <button id="logout" class="bg-emerald-600 text-black py-2 px-4 rounded-md hover:bg-emerald-700 transition">Logout</button>
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
        <main class="container mx-auto px-4 py-8">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">Produk Untuk Disewa</h1>
            <div id="user-data" class="mb-6"></div>

            <div class="flex flex-col lg:flex-row space-y-6 lg:space-y-0 lg:space-x-8">
            <!-- Filters Sidebar -->
            <div class="lg:w-1/4">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                    <h3 class="text-lg font-bold mb-4 text-gray-800">Filter Pencarian</h3>

                    <!-- Filter Kategori -->
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2 font-medium">Kategori</label>
                        <select id="filter-kategori" class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">Semua Kategori</option>
                            <option value="Peralatan Dapur">Peralatan Dapur</option>
                            <option value="Peralatan Kebersihan">Peralatan Kebersihan</option>
                            <option value="Perabotan">Perabotan</option>
                            <option value="Elektronik">Elektronik</option>
                            <option value="Dekorasi">Dekorasi</option>
                        </select>
                    </div>

                    <!-- Filter Harga Per Hari -->
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2 font-medium">Harga Per Hari</label>
                        <div class="flex items-center gap-2">
                            <input type="number" id="harga-min" placeholder="Min" class="w-1/2 p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <span>-</span>
                            <input type="number" id="harga-max" placeholder="Max" class="w-1/2 p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                    </div>

                    <!-- Ketersediaan (Dikomentari) -->
                    <!--
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2 font-medium">Ketersediaan</label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" id="filter-tersedia" class="mr-2 rounded text-emerald-600 focus:ring-emerald-500">
                                <span>Tersedia Sekarang</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="mr-2 rounded text-emerald-600 focus:ring-emerald-500">
                                <span>Pengiriman Gratis</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" id="filter-promo" class="mr-2 rounded text-emerald-600 focus:ring-emerald-500">
                                <span>Promo</span>
                            </label>
                        </div>
                    </div>
                    -->

                    <!-- Rating (Dikomentari) -->
                    <!--
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2 font-medium">Rating</label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" class="mr-2 rounded text-emerald-600 focus:ring-emerald-500">
                                <div class="flex text-yellow-400">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="mr-2 rounded text-emerald-600 focus:ring-emerald-500">
                                <div class="flex text-yellow-400">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <span class="ml-1 text-gray-600">& Up</span>
                                </div>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="mr-2 rounded text-emerald-600 focus:ring-emerald-500">
                                <div class="flex text-yellow-400">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <span class="ml-1 text-gray-600">& Up</span>
                                </div>
                            </label>
                        </div>
                    </div>
                    -->

                    <!-- Tombol Terapkan Filter dihapus karena filter akan otomatis diterapkan -->
                </div>
            </div>

            <!-- Product List -->
            <div class="lg:w-3/4">
                <div class="flex justify-between items-center mb-6">
                    <p id="product-count" class="text-gray-600">Menampilkan 0 dari 0 produk</p>

                    <div class="flex items-center space-x-2">
                        <label class="text-gray-700">Urutkan:</label>
                        <select id="sort-option" class="p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="terpopuler">Terpopuler</option>
                            <option value="price-low-high">Harga: Rendah ke Tinggi</option>
                            <option value="price-high-low">Harga: Tinggi ke Rendah</option>
                            <option value="newest">Terbaru</option>
                        </select>
                    </div>
                </div>

                <div id="containerProduk" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4">
                    <!-- Produk akan diisi via JS dari /api/produk -->
                </div>

                <!-- Pagination -->
                <div class="mt-8 flex justify-center">
                    <nav class="flex items-center space-x-1">
                        <a href="#" class="px-3 py-2 rounded-md border border-gray-300 text-gray-500 hover:bg-emerald-50 transition">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                        <a href="#" class="px-3 py-2 rounded-md bg-emerald-600 text-white">1</a>
                        <a href="#" class="px-3 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-emerald-50 transition">2</a>
                        <a href="#" class="px-3 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-emerald-50 transition">3</a>
                        <span class="px-3 py-2 text-gray-500">...</span>
                        <a href="#" class="px-3 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-emerald-50 transition">8</a>
                        <a href="#" class="px-3 py-2 rounded-md border border-gray-300 text-gray-500 hover:bg-emerald-50 transition">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </nav>
                </div>
            </div>
</main>

        <!-- Subscribe Section -->
        <section class="bg-emerald-100 py-12">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Dapatkan Info Terbaru & Promo Menarik</h2>
                <p class="text-gray-600 mb-6 max-w-xl mx-auto">Berlangganan newsletter kami dan dapatkan informasi produk terbaru serta promo eksklusif langsung ke email Anda.</p>
                <div class="flex max-w-md mx-auto">
                    <input type="email" placeholder="Alamat email Anda" class="flex-1 p-3 border-2 border-emerald-300 rounded-l-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <button class="bg-emerald-600 text-white px-6 py-3 rounded-r-md hover:bg-emerald-700 transition">Berlangganan</button>
                </div>
            </div>
        </section>

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
            </div>
        </div>
    </section>
</body>
</html>
