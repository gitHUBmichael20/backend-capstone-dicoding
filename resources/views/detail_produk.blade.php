<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail Page - {{ $produk->nama_produk }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-800 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Product Image -->
            <div class="relative">
                <div class="relative h-96 overflow-hidden rounded-lg">
                    <div class="absolute top-3 left-3 bg-blue-500 text-white text-xs font-semibold py-1 px-2.5 rounded-full z-10">New</div>
                    <div class="absolute top-3 left-20 bg-red-500 text-white text-xs font-semibold py-1 px-2.5 rounded-full z-10">-20%</div>
                    <img src="{{ $produk->gambar_produk ? asset($produk->gambar_produk) : '/api/placeholder/600/400' }}" alt="{{ $produk->nama_produk }}" class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                </div>
            </div>

            <!-- Product Info -->
            <div>
                <h1 class="text-3xl font-bold text-gray-800 leading-tight mb-2">{{ $produk->nama_produk }}</h1>

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
                    <span class="text-3xl font-bold text-emerald-600">Rp{{ number_format($produk->biaya_sewa, 0, ',', '.') }}/hari</span>
                </div>

                <div class="text-gray-600 mb-6">
                    <p>{{ $produk->deskripsi }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                    <div class="flex items-center">
                        <div class="text-gray-600">Kategori: {{ $produk->kategori }}</div>
                    </div>
                    <div class="flex items-center">
                        <div class="text-gray-600">Stok: {{ $produk->stok }}</div>
                    </div>
                </div>

                <div class="mb-8">
                    <div class="flex items-center mb-4">
                        <div class="text-gray-700 mr-3">Rental Days:</div>
                        <div class="flex items-center border border-gray-300 rounded-md overflow-hidden">
                            <button class="bg-gray-100 hover:bg-gray-200 px-3 py-1.5 transition-colors" onclick="updateRentalDays(-1)">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="text" id="rental-days" value="3" class="w-16 text-center border-0 py-1.5 focus:outline-none" readonly>
                            <button class="bg-gray-100 hover:bg-gray-200 px-3 py-1.5 transition-colors" onclick="updateRentalDays(1)">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="font-medium text-gray-700">Total rental cost: <span id="total-cost" class="font-semibold text-emerald-600">Rp{{ number_format($produk->biaya_sewa * 3, 0, ',', '.') }}</span></div>
                </div>

                <div class="flex flex-col md:flex-row gap-4">
                    <a href="#" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-3 px-6 rounded-md flex items-center justify-center transition-colors">
                        <i class="fas fa-shopping-cart mr-2"></i>
                        Add to Cart
                    </a>
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
                <p class="text-gray-600 leading-relaxed">{{ $produk->deskripsi }}</p>
            </div>
        </div>

        <!-- Related Products -->
        <div class="mt-12">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">You Might Also Like</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($relatedProducts as $related)
                    <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg hover:-translate-y-1 transition-all">
                        <div class="h-48 relative">
                            <img src="{{ $related->gambar_produk ? asset($related->gambar_produk) : '/api/placeholder/300/200' }}" alt="{{ $related->nama_produk }}" class="w-full h-full object-cover">
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
                @endforeach
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk menghitung total biaya sewa
        const biayaSewa = {{ $produk->biaya_sewa }};
        let rentalDays = 3;

        function updateRentalDays(change) {
            rentalDays = Math.max(1, rentalDays + change); // Minimal 1 hari
            document.getElementById('rental-days').value = rentalDays;
            const totalCost = biayaSewa * rentalDays;
            document.getElementById('total-cost').textContent = 'Rp' + totalCost.toLocaleString('id-ID');
        }
    </script>
</body>
</html>