<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="api-token" content="{{ session('api_token') }}">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    {{-- <script src="{{ asset('js/confirm.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/confirm.js'])
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Pinjam</h4>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title mb-4">Ringkasan Peminjaman</h5>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Durasi Peminjaman</th>
                                    <th>Tanggal peminjaman</th>
                                    <th>Tanggal Pengembalian</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                {{-- @foreach ($keranjang as $item)
                                <tr>
                                    <td>{{ $item->namaproduk }}</td>
                                    <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach --}}
                            </tbody>
                            <tfoot>
                                <tr class="table-primary">
                                    <th colspan="5" class="text-end">Total</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>

                        {{-- <div class="mt-4">
                            <h5 class="card-title">Informasi Peminjaman</h5>
                            <p><strong>Tanggal Peminjaman:</strong> </p>
                            <p><strong>Tanggan Pengembalian:</strong> </p>
                        </div> --}}

                        <form action="" method="POST" class="mt-4">
                            @csrf
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('keranjang') }}" class="btn btn-secondary">Kembali ke Keranjang</a>
                                <button type="button" class="btn btn-success" onclick="sendDataPeminjaman()">Konfirmasi Pinjaman</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>
</html>
