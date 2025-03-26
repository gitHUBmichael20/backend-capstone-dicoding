<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="api-token" content="{{ session('api_token') }}">
    <script src="{{ asset('js/keranjang.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Keranjang</title>
</head>
<body>
    <div class="container mt-4" id="container">
        <h1 class="mb-4">Keranjang Belanja</h1>

        {{-- <div class="alert alert-info" id="keranjangKosong">
            Keranjang belanja Anda kosong. <a href="{{ route('landing') }}" class="alert-link">Kembali berbelanja</a>.
        </div> --}}
        <div id="keranjangContainer">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Durasi Peminjaman</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="keranjangBody">
                    <!-- Data keranjang akan diisi dengan JavaScript -->
                </tbody>
                <tfoot>
                    <tr class="table-primary">
                        <th colspan="4" class="text-end">Total</th>
                        <th id="totalHarga"></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>

            <div class="d-flex justify-content-between mt-3">
                <div>
                    <button type="button" class="btn btn-warning" id="btnKosongkan" onclick="deleteAll()">Kosongkan Keranjang</button>
                    <a href="{{ route('landing') }}" class="btn btn-secondary">Lanjutkan Belanja</a>
                </div>
                <div>
                    <button class="btn btn-success" id="btnCheckout">Checkout</button>
                </div>
            </div>
        </div>

    </div>
</body>
</html>
