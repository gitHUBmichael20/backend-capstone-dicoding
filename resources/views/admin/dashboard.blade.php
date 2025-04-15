<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="api-token" content="{{ session('api_token') }}">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/admin_dashboard.js'])
    <style>
        .sidebar-open {
            transform: translateX(0);
        }

        .content-section {
            display: none;
        }

        .content-section.active {
            display: block;
        }
    </style>
</head>

<body class="bg-gray-100 dark:bg-gray-900">
    <button data-drawer-target="sidebar-multi-level-sidebar" data-drawer-toggle="sidebar-multi-level-sidebar"
        aria-controls="sidebar-multi-level-sidebar" type="button"
        class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
        <span class="sr-only">Open sidebar</span>
        <i class="fas fa-bars w-6 h-6"></i>
    </button>

    <aside id="sidebar-multi-level-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
        aria-label="Sidebar">
        <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="#" data-section="dashboard"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group nav-link">
                        <i
                            class="fas fa-tachometer-alt w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#" data-section="product"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group nav-link">
                        <i
                            class="fas fa-box w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                        <span class="flex-1 ms-3 whitespace-nowrap">Products</span>
                    </a>
                </li>
                <li>
                    <a href="#" data-section="users"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group nav-link">
                        <i
                            class="fas fa-users w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                        <span class="flex-1 ms-3 whitespace-nowrap">Users</span>
                    </a>
                </li>
                <li>
                    <a href="#" data-section="machine-learning-main"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group nav-link">
                        <i
                            class="fa-solid fa-magnifying-glass-chart w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                        <span class="flex-1 ms-3 whitespace-nowrap">Analytics Market</span>
                    </a>
                </li>
                <!-- Tombol Back to Landing -->
                <li>
                    <a href="/"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <i
                            class="fas fa-home w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                        <span class="flex-1 ms-3 whitespace-nowrap">Back to Landing</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="p-4 sm:ml-64">
        <div class="max-w-7xl mx-auto">
            <!-- Dashboard Section -->
            <div id="dashboard" class="content-section active">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Dashboard Overview</h1>
                <p class="text-gray-600 dark:text-gray-400">Welcome back, Admin! Here's your summary for today.</p>
                @include('admin.analytics')
            </div>

            <!-- Products Section -->
            <div id="product" class="content-section">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Manage Products</h1>
                <button onclick="showProductForm('create')" class="mb-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Add New Product
                </button>
                <div id="product-form" class="hidden bg-white p-6 rounded-lg shadow-md mb-6">
                    <h2 id="product-form-title" class="text-xl font-bold mb-4">Add Product</h2>
                    <form id="product-crud-form">
                        <input type="hidden" id="product-id">
                        <div class="mb-4">
                            <label class="block text-gray-700">Product Name</label>
                            <input type="text" id="nama_produk" class="w-full p-2 border rounded-lg" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Description</label>
                            <textarea id="deskripsi" class="w-full p-2 border rounded-lg"></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Stock</label>
                            <input type="number" id="stok" class="w-full p-2 border rounded-lg" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Rental Price (per day)</label>
                            <input type="number" id="biaya_sewa" class="w-full p-2 border rounded-lg" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Category</label>
                            <select id="kategori" class="w-full p-2 border rounded-lg" required>
                                <option value="">Select Category</option>
                                <option value="Peralatan Dapur">Peralatan Dapur</option>
                                <option value="Peralatan Kebersihan">Peralatan Kebersihan</option>
                                <option value="Perabotan">Perabotan</option>
                                <option value="Elektronik">Elektronik</option>
                                <option value="Dekorasi">Dekorasi</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Product Image</label>
                            <input type="file" id="gambar_produk" accept="image/*" class="w-full p-2 border rounded-lg">
                        </div>
                        <div class="flex space-x-4">
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Save</button>
                            <button type="button" onclick="hideProductForm()" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">Cancel</button>
                        </div>
                    </form>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="p-3">Name</th>
                                <th class="p-3">Category</th>
                                <th class="p-3">Stock</th>
                                <th class="p-3">Price</th>
                                <th class="p-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="product-table">
                            <!-- Data akan diisi oleh JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Users Section -->
            <div id="users" class="content-section">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Manage Users</h1>
                <button onclick="showUserForm('create')" class="mb-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Add New User
                </button>
                <div id="user-form" class="hidden bg-white p-6 rounded-lg shadow-md mb-6">
                    <h2 id="user-form-title" class="text-xl font-bold mb-4">Add User</h2>
                    <form id="user-crud-form">
                        <input type="hidden" id="user-id">
                        <div class="mb-4">
                            <label class="block text-gray-700">Name</label>
                            <input type="text" id="nama_pengguna" class="w-full p-2 border rounded-lg" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Email</label>
                            <input type="email" id="email" class="w-full p-2 border rounded-lg" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Phone Number</label>
                            <input type="text" id="nomor_telepon" class="w-full p-2 border rounded-lg">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Address</label>
                            <textarea id="alamat" class="w-full p-2 border rounded-lg"></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Password</label>
                            <input type="password" id="password" class="w-full p-2 border rounded-lg">
                            <p class="text-sm text-gray-500 mt-1">Leave blank to keep current password (for edit).</p>
                        </div>
                        <div class="flex space-x-4">
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Save</button>
                            <button type="button" onclick="hideUserForm()" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">Cancel</button>
                        </div>
                    </form>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="p-3">Name</th>
                                <th class="p-3">Email</th>
                                <th class="p-3">Phone</th>
                                <th class="p-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="user-table">
                            <!-- Data akan diisi oleh JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Analytics Section -->
            <div id="machine-learning-main" class="content-section">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Analisa Pasar dan Penjualan</h1>
                <p class="text-gray-600 dark:text-gray-400">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
            </div>
        </div>
    </div>

    <script>
        // Toggle Sidebar
        const sidebarToggle = document.querySelector('[data-drawer-toggle="sidebar-multi-level-sidebar"]');
        const sidebar = document.getElementById('sidebar-multi-level-sidebar');
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            sidebar.classList.toggle('sidebar-open');
        });

        // Navigation between sections
        const navLinks = document.querySelectorAll('.nav-link');
        const sections = document.querySelectorAll('.content-section');

        navLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const sectionId = link.getAttribute('data-section');
                showSection(sectionId);
            });
        });

        // Function to show a specific section
        function showSection(sectionId) {
            // Hide all sections
            sections.forEach(section => {
                section.classList.remove('active');
            });

            // Show selected section
            document.getElementById(sectionId).classList.add('active');

            // Load data for specific sections
            if (sectionId === 'product') {
                fetchProducts();
            } else if (sectionId === 'users') {
                fetchUsers();
            }
        }

        // Load products and users on page load if respective section is active
        document.addEventListener('DOMContentLoaded', () => {
            if (document.getElementById('product').classList.contains('active')) {
                fetchProducts();
            }
            if (document.getElementById('users').classList.contains('active')) {
                fetchUsers();
            }
        });
    </script>
</body>

</html>