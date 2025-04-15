<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Analytics</title>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@latest"></script>
    @vite(['resources/css/app.css', 'resources/js/admin_analytics.js'])
</head>

<body class="bg-gray-100 font-sans">
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 dark:text-gray-400">Admin Analytics Dashboard</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">Total Peminjaman</h2>
                <p id="total-peminjaman" class="text-2xl font-bold text-blue-600">Memuat...</p>
            </div>
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">Rata-rata Durasi Peminjaman</h2>
                <p id="avg-duration" class="text-2xl font-bold text-green-600">Memuat...</p>
            </div>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Prediksi Durasi Peminjaman</h2>
            <div class="mb-4">
                <label for="pengguna-id" class="block text-gray-600 mb-2">Masukkan Pengguna ID:</label>
                <input type="number" id="pengguna-id" class="border rounded-lg p-2 w-full md:w-1/3"
                    placeholder="Contoh: 48711" value="48711">
            </div>
            <button id="predict-btn"
                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Prediksi</button>
            <div id="prediction-result" class="mt-4 text-gray-600">
                Hasil prediksi akan muncul di sini...
            </div>
        </div>
    </div>
</body>

</html>
