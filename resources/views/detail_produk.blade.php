<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail Page</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<body class="font-sans text-gray-800 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Product Gallery -->
            <div class="relative">
                <div class="relative h-96 overflow-hidden rounded-lg">
                    <div class="absolute top-3 left-3 bg-blue-500 text-white text-xs font-semibold py-1 px-2.5 rounded-full z-10">New</div>
                    <div class="absolute top-3 left-20 bg-red-500 text-white text-xs font-semibold py-1 px-2.5 rounded-full z-10">-20%</div>
                    <img src="/api/placeholder/600/400" alt="Mountain Bike" class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                </div>
                <div class="flex space-x-2 mt-3 overflow-x-auto pb-2">
                    <div class="w-20 h-20 flex-shrink-0 rounded-md overflow-hidden border-2 border-emerald-500">
                        <img src="/api/placeholder/80/80?text=1" alt="Thumbnail 1" class="w-full h-full object-cover">
                    </div>
                    <div class="w-20 h-20 flex-shrink-0 rounded-md overflow-hidden border-2 border-transparent hover:opacity-85 cursor-pointer">
                        <img src="/api/placeholder/80/80?text=2" alt="Thumbnail 2" class="w-full h-full object-cover">
                    </div>
                    <div class="w-20 h-20 flex-shrink-0 rounded-md overflow-hidden border-2 border-transparent hover:opacity-85 cursor-pointer">
                        <img src="/api/placeholder/80/80?text=3" alt="Thumbnail 3" class="w-full h-full object-cover">
                    </div>
                    <div class="w-20 h-20 flex-shrink-0 rounded-md overflow-hidden border-2 border-transparent hover:opacity-85 cursor-pointer">
                        <img src="/api/placeholder/80/80?text=4" alt="Thumbnail 4" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>

            <!-- Product Info -->
            <div>
                <h1 class="text-3xl font-bold text-gray-800 leading-tight mb-2"> {{ $produk->nama_produk }} </h1>

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
                    <span class="text-3xl font-bold text-emerald-600"> {{ $produk->biaya_sewa }} </span>
                </div>

                <div class="text-gray-600 mb-6">
                    <p> {{ $produk->deskripsi }} </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                    <div class="flex items-center">
                        {{-- <div class="text-emerald-500 mr-2"><i class="fas fa-weight-hanging"></i></div> --}}
                        <div class="text-gray-600">Weight: 12.5 kg</div>
                    </div>
                    <div class="flex items-center">
                        {{-- <div class="text-emerald-500 mr-2"><i class="fas fa-cog"></i></div> --}}
                        <div class="text-gray-600">Gears: 21-Speed</div>
                    </div>
                    <div class="flex items-center">
                        {{-- <div class="text-emerald-500 mr-2"><i class="fas fa-ruler-horizontal"></i></div> --}}
                        <div class="text-gray-600">Frame: Aluminum</div>
                    </div>
                    <div class="flex items-center">
                        {{-- <div class="text-emerald-500 mr-2"><i class="fas fa-tachometer-alt"></i></div> --}}
                        <div class="text-gray-600"> Stok : {{ $produk->stok }} </div>
                    </div>
                </div>

                <div class="mb-8">
                    <div class="flex items-center mb-4">
                        <div class="text-gray-700 mr-3">Rental Days:</div>
                        <div class="flex items-center border border-gray-300 rounded-md overflow-hidden">
                            <button class="bg-gray-100 hover:bg-gray-200 px-3 py-1.5 transition-colors">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="text" value="3" class="w-16 text-center border-0 py-1.5 focus:outline-none">
                            <button class="bg-gray-100 hover:bg-gray-200 px-3 py-1.5 transition-colors">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="font-medium text-gray-700">Total rental cost: <span class="font-semibold text-emerald-600">$269.97</span></div>
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
                <!-- Reviews Tab Content -->
                <div class="flex flex-col md:flex-row mb-8 pb-8 border-b border-gray-200">
                    <div class="text-center mr-0 md:mr-8 mb-6 md:mb-0">
                        <div class="text-5xl font-bold text-gray-800 leading-none">4.5</div>
                        <div class="text-yellow-400 text-xl my-2">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <div class="text-gray-600 text-sm">Based on 128 reviews</div>
                    </div>

                    <div class="flex-1">
                        <div class="flex items-center mb-2">
                            <div class="w-12 text-sm text-gray-600">5 Stars</div>
                            <div class="flex-1 h-2 bg-gray-200 rounded-full mx-2 overflow-hidden">
                                <div class="h-full bg-yellow-400" style="width: 75%"></div>
                            </div>
                            <div class="w-12 text-sm text-gray-600 text-right">75%</div>
                        </div>
                        <div class="flex items-center mb-2">
                            <div class="w-12 text-sm text-gray-600">4 Stars</div>
                            <div class="flex-1 h-2 bg-gray-200 rounded-full mx-2 overflow-hidden">
                                <div class="h-full bg-yellow-400" style="width: 15%"></div>
                            </div>
                            <div class="w-12 text-sm text-gray-600 text-right">15%</div>
                        </div>
                        <div class="flex items-center mb-2">
                            <div class="w-12 text-sm text-gray-600">3 Stars</div>
                            <div class="flex-1 h-2 bg-gray-200 rounded-full mx-2 overflow-hidden">
                                <div class="h-full bg-yellow-400" style="width: 6%"></div>
                            </div>
                            <div class="w-12 text-sm text-gray-600 text-right">6%</div>
                        </div>
                        <div class="flex items-center mb-2">
                            <div class="w-12 text-sm text-gray-600">2 Stars</div>
                            <div class="flex-1 h-2 bg-gray-200 rounded-full mx-2 overflow-hidden">
                                <div class="h-full bg-yellow-400" style="width: 3%"></div>
                            </div>
                            <div class="w-12 text-sm text-gray-600 text-right">3%</div>
                        </div>
                        <div class="flex items-center">
                            <div class="w-12 text-sm text-gray-600">1 Star</div>
                            <div class="flex-1 h-2 bg-gray-200 rounded-full mx-2 overflow-hidden">
                                <div class="h-full bg-yellow-400" style="width: 1%"></div>
                            </div>
                            <div class="w-12 text-sm text-gray-600 text-right">1%</div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="pb-6 mb-6 border-b border-gray-200">
                        <div class="flex justify-between mb-2">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 font-bold flex items-center justify-center mr-3">JD</div>
                                <div>
                                    <div class="font-medium text-gray-800">John Doe</div>
                                    <div class="text-sm text-gray-500">March 8, 2025</div>
                                </div>
                            </div>
                            <div class="text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                        <div class="text-gray-600 leading-relaxed">
                            <p>This bike exceeded all my expectations! I've been using it for both trail rides and daily commuting, and it performs brilliantly in both scenarios. The suspension system handles bumps and rough terrain with ease, and the shifting is smooth and precise. Definitely worth every penny!</p>
                        </div>
                        <div class="flex gap-2 mt-3">
                            <div class="w-16 h-16 rounded overflow-hidden">
                                <img src="/api/placeholder/100/100?text=Trail" alt="Customer Photo" class="w-full h-full object-cover">
                            </div>
                            <div class="w-16 h-16 rounded overflow-hidden">
                                <img src="/api/placeholder/100/100?text=Mountain" alt="Customer Photo" class="w-full h-full object-cover">
                            </div>
                        </div>
                    </div>

                    <div class="pb-6 mb-6 border-b border-gray-200">
                        <div class="flex justify-between mb-2">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 font-bold flex items-center justify-center mr-3">AS</div>
                                <div>
                                    <div class="font-medium text-gray-800">Alice Smith</div>
                                    <div class="text-sm text-gray-500">March 3, 2025</div>
                                </div>
                            </div>
                            <div class="text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                        </div>
                        <div class="text-gray-600 leading-relaxed">
                            <p>Great bike for the price! The frame is lightweight yet sturdy, and the components are of good quality. I've taken it on several weekend trips already, and it handles well on various terrains. Only giving 4 stars because the seat could be more comfortable for longer rides, but that's an easy fix.</p>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between mb-2">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 font-bold flex items-center justify-center mr-3">RJ</div>
                                <div>
                                    <div class="font-medium text-gray-800">Robert Johnson</div>
                                    <div class="text-sm text-gray-500">February 27, 2025</div>
                                </div>
                            </div>
                            <div class="text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                        <div class="text-gray-600 leading-relaxed">
                            <p>I'm an experienced mountain biker, and I'm impressed with the quality of this bike. The gearing system is smooth and reliable, and the bike feels balanced and responsive on technical trails. Assembly was straightforward, and everything was well-packaged. The 20% discount made this an absolute steal!</p>
                        </div>
                        <div class="flex gap-2 mt-3">
                            <div class="w-16 h-16 rounded overflow-hidden">
                                <img src="/api/placeholder/100/100?text=Biking" alt="Customer Photo" class="w-full h-full object-cover">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <div class="mt-12">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">You Might Also Like</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg hover:-translate-y-1 transition-all">
                    <div class="h-48 relative">
                        <img src="/api/placeholder/300/200?text=Helmet" alt="Bike Helmet" class="w-full h-full object-cover">
                        <div class="absolute top-2 right-2 bg-red-500 text-white text-xs font-semibold py-1 px-2 rounded-full">-15%</div>
                    </div>
                    <div class="p-4">
                        <h4 class="text-lg font-semibold text-gray-800 truncate mb-1">Premium Bike Helmet</h4>
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
                                $34.99
                                <span class="text-sm text-gray-500 line-through ml-1">$41.00</span>
                            </div>
                            <div class="text-emerald-600 p-2 rounded-full hover:bg-emerald-50 transition-colors">
                                <i class="far fa-heart"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional product cards would go here -->

            </div>
        </div>
    </div>
</body>
</html>
