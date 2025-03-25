<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css'], ['resources/js/app.js'])
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
                    <a href="#" data-section="inbox"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group nav-link">
                        <i
                            class="fas fa-envelope w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                        <span class="flex-1 ms-3 whitespace-nowrap">Inbox</span>
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
                        <i class="fa-solid fa-magnifying-glass-chart w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                        <span class="flex-1 ms-3 whitespace-nowrap">Analytics Market</span>
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

            <!-- Inbox Section -->
            <div id="inbox" class="content-section">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Inbox</h1>
                <p class="text-gray-600 dark:text-gray-400">Check your messages and notifications here.</p>
            </div>

            <!-- Users Section -->
            <div id="users" class="content-section">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Users</h1>
                <p class="text-gray-600 dark:text-gray-400">Manage user accounts and permissions.</p>
            </div>

            <!-- machine-learning (Main) Section -->
            <div id="machine-learning-main" class="content-section">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Analisa Pasar dan Penjualan</h1>
                <p class="text-gray-600 dark:text-gray-400">Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora fugit voluptates ab necessitatibus ipsa ducimus rem, perferendis et eius, reprehenderit dignissimos!</p>
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

                // Hide all sections
                sections.forEach(section => {
                    section.classList.remove('active');
                });

                // Show selected section
                document.getElementById(sectionId).classList.add('active');
            });
        });
    </script>
</body>

</html>
