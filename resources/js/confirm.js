addEventListener ('DOMContentLoaded', () => {
    const dataKeranjang = JSON.parse(localStorage.getItem('keranjang'));
    const dataDetailProduk = JSON.parse(localStorage.getItem('rentalData'));

    if (dataKeranjang) {
        console.log(dataKeranjang);
        getData(dataKeranjang);
    } else {
        console.log(dataDetailProduk);
        getDataFromDetailProduk(dataDetailProduk);
    }
});

function getData(data) {
    const body = document.getElementById('tableBody');
    console.log(data);
    body.innerHTML = '';
    const updatedData = data.map(item => {
        const [tanggalSewa, tanggalPengembalian] = returnDate(item.jumlah);
        console.log("Hasil returnDate:", returnDate(item.jumlah));
        return {
            ...item,
            'tanggal_peminjaman' : tanggalSewa,
            'tanggal_pengembalian' : tanggalPengembalian,
            'status' : 'Dipinjam'
        }
    });
    console.log("Updated Data setelah mapping:", updatedData);
    updatedData.forEach(item => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
        <td>${item.nama_produk}</td>
        <td>${item.biaya_sewa}</td>
        <td>${item.jumlah} days</td>
        <td>${item.tanggal_peminjaman}</td>
        <td>${item.tanggal_pengembalian}</td>
        <td>${item.biaya_sewa * item.jumlah}</td>
        `;
        body.appendChild(tr);
    });

    return updatedData;
}

function getDataFromDetailProduk(data) {
    console.log(data);
    const body = document.getElementById('tableBody');
    body.innerHTML = '';
    const tr = document.createElement('tr');
    tr.innerHTML = `
    <td>${data.nama_produk}</td>
    <td>${data.harga}</td>
    <td>${data.durasi} days</td>
    <td>${data.tanggal_peminjaman}</td>
    <td>${data.tanggal_pengembalian}</td>
    <td>${data.biaya_sewa}</td>
    `;
    body.appendChild(tr);


}

function currentDate() {
    let today = new Date();
    return today;
}

function returnDate(durasiPeminjaman) {
    let today = currentDate();
    const duration = parseInt(durasiPeminjaman);

    if (isNaN(duration) || duration <= 0) {
        console.error("Durasi peminjaman tidak valid.");
        return;
    }

    let returnDate = new Date(today);
    returnDate.setDate(today.getDate() + duration);

    let formattedToday = today.toISOString().split('T')[0];
    let formattedReturnDate = returnDate.toISOString().split('T')[0];

    return [formattedToday, formattedReturnDate];
}

async function sendDataPeminjaman() {
    const dataKeranjang = JSON.parse(localStorage.getItem('keranjang'));
    const dataPeminjaman = getData(dataKeranjang);
    console.log('data peminjaman: ', dataPeminjaman);
    console.log(JSON.stringify({data:dataPeminjaman}));
    const response = await fetch('/api/peminjaman', {
        method : 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${document.querySelector('meta[name="api-token"]').getAttribute('content')}`
        },
        // body : JSON.stringify({data:dataPeminjaman})
        body: JSON.stringify({
            data:dataPeminjaman
        })
    });
    const message = await response.json();
    console.log(message);

    if (response.ok) {
        localStorage.removeItem('keranjang');
        Swal.fire({
            icon: 'success',
            title: message.message,
            showConfirmButton: false,
            timer: 1500
        });
    } else {
        console.log('Gagal Mengirim data!');
    }
}

window.getData = getData;
window.getDataFromDetailProduk = getDataFromDetailProduk;
window.currentDate = currentDate;
window.returnDate = returnDate;
window.sendDataPeminjaman = sendDataPeminjaman;