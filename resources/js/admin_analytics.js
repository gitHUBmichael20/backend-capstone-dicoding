import * as tf from "@tensorflow/tfjs";

// Fungsi untuk menghitung durasi peminjaman (dalam hari)
function calculateDuration(tanggalPinjam, tanggalKembali) {
    const start = new Date(tanggalPinjam);
    const end = tanggalKembali ? new Date(tanggalKembali) : new Date(); // Gunakan tanggal saat ini
    const diffTime = Math.abs(end - start);
    return Math.ceil(diffTime / (1000 * 60 * 60 * 24)); // Konversi ke hari
}

// Fungsi untuk memuat dan memproses data dari API
async function loadData() {
    try {
        const response = await fetch("/api/admin/peminjaman");
        const result = await response.json();

        if (!result.success) {
            throw new Error("Gagal memuat data");
        }

        const data = result.data;
        const totalRecords = result.total_records;

        // Proses data untuk ML
        const inputs = [];
        const outputs = [];
        let totalDuration = 0;

        data.forEach((peminjaman) => {
            const duration = calculateDuration(
                peminjaman.tanggal_pinjam,
                peminjaman.tanggal_kembali
            );
            totalDuration += duration;

            // Encode status: "Dikembalikan" = 1, "Dipinjam" = 0
            const statusEncoded = peminjaman.status === "Dikembalikan" ? 1 : 0;

            // Input: [pengguna_id, status]
            inputs.push([peminjaman.pengguna_id, statusEncoded]);
            // Output: durasi peminjaman (dalam hari)
            outputs.push(duration);
        });

        // Hitung rata-rata durasi
        const calculatedAvgDuration =
            totalRecords > 0 ? (totalDuration / data.length).toFixed(2) : 0;

        return {
            inputs,
            outputs,
            totalRecords,
            avgDuration: calculatedAvgDuration,
        };
    } catch (error) {
        console.error("Error loading data:", error);
        return { inputs: [], outputs: [], totalRecords: 0, avgDuration: 0 };
    }
}

// Fungsi untuk melatih model
async function trainModel(inputs, outputs) {
    // Sampling: Ambil 10.000 record untuk pelatihan agar lebih cepat
    const sampleSize = Math.min(10000, inputs.length);
    const sampleIndices = Array.from({ length: inputs.length }, (_, i) => i)
        .sort(() => Math.random() - 0.5)
        .slice(0, sampleSize);

    const sampledInputs = sampleIndices.map((i) => inputs[i]);
    const sampledOutputs = sampleIndices.map((i) => outputs[i]);

    const model = tf.sequential();
    model.add(
        tf.layers.dense({ units: 16, activation: "relu", inputShape: [2] })
    );
    model.add(tf.layers.dense({ units: 8, activation: "relu" }));
    model.add(tf.layers.dense({ units: 1 }));

    model.compile({
        optimizer: "adam",
        loss: "meanSquaredError",
    });

    const xs = tf.tensor2d(sampledInputs);
    const ys = tf.tensor2d(sampledOutputs, [sampledOutputs.length, 1]);

    await model.fit(xs, ys, {
        epochs: 20, // Kurangi epoch untuk kecepatan
        callbacks: {
            onEpochEnd: (epoch, logs) => {
                console.log(`Epoch ${epoch}: loss = ${logs.loss}`);
            },
        },
    });

    return model;
}

// Fungsi untuk membuat prediksi
async function predict(model, penggunaId, status) {
    const statusEncoded = status === "Dikembalikan" ? 1 : 0;
    const input = tf.tensor2d([[penggunaId, statusEncoded]]);
    const prediction = model.predict(input);
    return Math.round(prediction.dataSync()[0]); // Bulatkan ke hari terdekat
}

// Main function
document.addEventListener("DOMContentLoaded", async () => {
    const totalPeminjaman = document.getElementById("total-peminjaman");
    const avgDurationElement = document.getElementById("avg-duration");
    const predictBtn = document.getElementById("predict-btn");
    const penggunaIdInput = document.getElementById("pengguna-id");
    const resultDiv = document.getElementById("prediction-result");

    let model = null; // Variabel untuk menyimpan model

    try {
        // Langkah 1: Muat data
        const { inputs, outputs, totalRecords, avgDuration } = await loadData();
        if (inputs.length === 0) {
            resultDiv.innerText = "Gagal memuat data peminjaman.";
            return;
        }

        // Langkah 2: Tampilkan statistik dasar
        totalPeminjaman.innerText = totalRecords.toLocaleString();
        avgDurationElement.innerText = `${avgDuration} hari`;

        // Langkah 3: Latih model
        model = await trainModel(inputs, outputs);
    } catch (error) {
        console.error("Error in main function:", error);
        resultDiv.innerText = "Terjadi kesalahan dalam memproses data.";
        return;
    }

    // Langkah 4: Event listener untuk tombol prediksi
    predictBtn.addEventListener("click", async () => {
        try {
            const penggunaId = parseInt(penggunaIdInput.value);
            if (isNaN(penggunaId)) {
                resultDiv.innerText = "Masukkan Pengguna ID yang valid.";
                return;
            }

            // Asumsi status "Dipinjam" untuk prediksi
            const status = "Dipinjam";
            const predictedDuration = await predict(model, penggunaId, status);

            resultDiv.innerText = `Prediksi durasi peminjaman untuk pengguna ID ${penggunaId}: ${predictedDuration} hari`;
        } catch (error) {
            console.error("Prediction error:", error);
            resultDiv.innerText =
                "Terjadi kesalahan saat melakukan prediksi. Pastikan model sudah dilatih dengan benar.";
        }
    });
});
