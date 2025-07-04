// const dummyData = {
//   "RESI654321": {
//     status: "Menuju lokasi tujuan",
//     lokasi: "Gudang Probolinggo",
//     barang: "Lemari Kayu Jati",
//     kurir: "Pak Darto",
//     riwayat: [
//       { status: "Pemesanan diproses", kurir: "Bu Sari", distrik: "Lumajang", checkpoint: "Workshop Utama" },
//       { status: "Sedang pickup", kurir: "Pak Darto", distrik: "Lumajang", checkpoint: "Depo Jati" },
//       { status: "Menuju lokasi tujuan", kurir: "Pak Darto", distrik: "Probolinggo", checkpoint: "Gudang Transit" }
//     ]
//   },
//   "RESI123456": {
//     status: "Telah diterima",
//     lokasi: "Toko Mebel Tunas Jaya, Lumajang",
//     barang: "Meja Makan 6 Kursi",
//     kurir: "Pak Budi",
//     riwayat: [
//       { status: "Pemesanan diproses", kurir: "Pak Budi", distrik: "Surabaya", checkpoint: "Gudang Surabaya" },
//       { status: "Sedang pickup", kurir: "Pak Budi", distrik: "Sidoarjo", checkpoint: "Pabrik Mebel" },
//       { status: "Menuju lokasi tujuan", kurir: "Pak Budi", distrik: "Lumajang", checkpoint: "Perjalanan" },
//       { status: "Telah diterima", kurir: "Pak Budi", distrik: "Lumajang", checkpoint: "Toko Utama" }
//     ]
//   }
// };

document.getElementById("tracking-form").addEventListener("submit", function (e) {
  e.preventDefault();

  const resi = document.getElementById("resi").value.trim();

  fetch(`/api/search?resi=${resi}`)
    .then(response => response.json())
    .then(data => {
      const resultBox = document.getElementById("tracking-result");
      const tableBody = document.getElementById("tracking-table-body");
      const toggleBtn = document.getElementById("toggle-history");

      if (data.error) {
        resultBox.style.display = "block";
        document.getElementById("current-status-text").innerText = "Nomor Resi tidak valid!";
        document.getElementById("current-location-text").innerText = "-";
        document.getElementById("resi-text").innerText = resi;
        document.getElementById("barang-text").innerText = "-";
        document.getElementById("kurir-text").innerText = "-";
        tableBody.innerHTML = `<tr><td colspan="5" class="text-center text-danger">Data tidak ditemukan</td></tr>`;
        toggleBtn.style.display = "none";
        return;
      }

      // tampilkan data
      document.getElementById("current-status-text").innerText = data.status;
      document.getElementById("current-location-text").innerText = data.lokasi;
      document.getElementById("resi-text").innerText = resi;
      document.getElementById("barang-text").innerText = data.barang;
      document.getElementById("kurir-text").innerText = data.kurir;

      let html = "";
      data.riwayat.forEach((item, index) => {
        html += `
          <tr>
            <td class="text-center">${index + 1}</td>
            <td>${item.status}</td>
            <td>${item.kurir}</td>
            <td>${item.distrik}</td>
            <td>${item.checkpoint}</td>
          </tr>`;
      });

      tableBody.innerHTML = html;
      resultBox.style.display = "block";
      toggleBtn.innerText = "Sembunyikan Riwayat";
      toggleBtn.style.display = "inline-block";
      document.getElementById("tracking-history").style.display = "block";
    });
});


document.getElementById("toggle-history").addEventListener("click", function () {
  const history = document.getElementById("tracking-history");
  if (history.style.display === "none" || history.style.display === "") {
    history.style.display = "block";
    this.innerText = "Sembunyikan Riwayat";
  } else {
    history.style.display = "none";
    this.innerText = "Tampilkan Riwayat";
  }
});
 