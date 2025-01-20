// Fungsi untuk membuka form laporan
function openReportForm() {
    document.getElementById("reportOverlay").style.display = "flex";
}

// Fungsi untuk menutup form laporan
function closeReportForm() {
    document.getElementById("reportOverlay").style.display = "none";
}

// Menghandle form submit dengan SweetAlert2
document.querySelector('form').addEventListener('submit', function (e) {
    e.preventDefault(); // Mencegah submit default

    const formData = new FormData(this);

    // SweetAlert2 untuk konfirmasi sebelum submit
    Swal.fire({
        title: 'Kirim Laporan?',
        text: "Pastikan data yang diisi sudah benar.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Kirim!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit menggunakan fetch
            fetch('php/submit_report.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    Swal.fire('Berhasil!', data.message, 'success');
                    closeReportForm();
                    this.reset(); // Reset form setelah berhasil
                } else {
                    Swal.fire('Gagal!', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'Terjadi kesalahan. Silakan coba lagi.', 'error');
            });
        } else {
            Swal.fire('Dibatalkan!', 'Pengiriman laporan dibatalkan.', 'info');
        }
    });
});

function showDashboardInfo() {
    Swal.fire({
        title: 'Informasi Page Dashboard',
        html: `
            <p><strong>Berikut adalah informasi penjelasan tentang penggunaan halaman ini:</strong></p>
            <ul style="text-align: left;">
                <li>Halaman Dashbord ini merupakan halaman utama untuk member QC memilih
                    Line yang akan di input</li>
                <li>Terdapat pilihan Line dari CR 1 - CR 12, pilih sesuai dengan data yang akan diinput</li>
                <li>Di setiap line CR sudah disesuaikan dengan Part yang diproduksinya masing - masing</li>
                <li>Di setiap Part di sediakan nama mesin dan proses nya</li>
                <li>Laporan ke Leader :<br>Digunakan untuk melakukan laporan ke leader
                    jika terjadi ke abnormalan atau NG. Laporan akan terkirim ke Leader dan Leader akan mengetahuinya.</li>
            </ul>
        `,
        icon: 'info',
        width: '800px',
        confirmButtonText: 'Tutup',
    });
}

function openReportList() {
    document.getElementById("reportListOverlay").style.display = "flex";
}

function closeReportList() {
    document.getElementById("reportListOverlay").style.display = "none";
}

function acceptReport(reportId) {
    fetch('update_report_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: reportId }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Laporan berhasil diterima.',
                    icon: 'success',
                    confirmButtonText: 'OK',
                }).then(() => {
                    document.location.reload(); // Refresh halaman setelah menutup popup
                });
            } else {
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Gagal memperbarui status laporan.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                });
            }
        })
        .catch((error) => {
            Swal.fire({
                title: 'Kesalahan!',
                text: 'Terjadi kesalahan saat memproses permintaan.',
                icon: 'error',
                confirmButtonText: 'OK',
            });
            console.error('Error:', error);
        });
}

function deleteReport(reportId) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: 'Laporan ini akan dihapus secara permanen.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('delete_report.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id=${reportId}`,
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Laporan berhasil dihapus.',
                            icon: 'success',
                            confirmButtonText: 'OK',
                        }).then(() => {
                            location.reload(); // Refresh halaman setelah popup ditutup
                        });
                    } else {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat menghapus laporan.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                        });
                    }
                })
                .catch((error) => {
                    Swal.fire({
                        title: 'Kesalahan!',
                        text: 'Tidak dapat terhubung ke server.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                    });
                });
        }
    });
}

function showPanduanleader() {
    Swal.fire({
        title: 'Panduan untuk Leader',
        html: `
            <p><strong>Berikut adalah panduan untuk leader melakukan pengecekan check sheet:</strong></p>
            <ul style="text-align: left;">
                <li>Pilih Line mana yang akan di check (CR 1- CR 12)</li>
                <li>Pilih Part apa yang akan di cek (setiap part sudah tersedia setiap proses dan nama mesin nya)</li>
                <li>Pilih item yang akan di cek</li>
                <li>Pilih tanggal pengecekkan check sheet lalu isi bagian nama dengan nama leader yang melakukan pengecekkan.</li>
                <li>Laporan member QC:<br>Berisi laporan keabnormalan atau NG yang terjadi. 
                Laporan ini dikirim oleh member QC untuk Leader, supaya leader mengetahui jika ada terjadi keabnormalan atau NG dari QC dan dapat segera melakukan tindakan.</li>
            </ul>
        `,
        icon: 'info',
        width: '800px',
        confirmButtonText: 'Tutup',
    });
}