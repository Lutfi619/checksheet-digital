document.getElementById('resetDataButton').addEventListener('click', function () {
    Swal.fire({
        title: 'Simpan & Reset Check Sheet?',
        text: "Pastikan data sudah benar sebelum disimpan dan direset.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Save & Reset',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('p', 'mm', 'a4');
            const pageWidth = doc.internal.pageSize.getWidth();
            const pageHeight = doc.internal.pageSize.getHeight();

            // Header PDF
            doc.setFontSize(16);
            doc.setFont('helvetica', 'bold');
            doc.text('CHECK SHEET REPORT', pageWidth / 2, 15, { align: 'center' });

            // Ambil elemen informasi item secara spesifik
            const infoElement = document.querySelector('.item-info');

            html2canvas(infoElement, { scale: 1.5 }).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const imgWidth = pageWidth - 20; // Sesuaikan lebar gambar
                const imgHeight = (canvas.height / canvas.width) * imgWidth; // Sesuaikan tinggi gambar

                doc.addImage(imgData, 'PNG', 10, 20, imgWidth, imgHeight); // Tambahkan gambar informasi item

                // Tambahkan grafik
                const chartCanvas1 = document.getElementById('roughnessChart');
                const chartCanvas2 = document.getElementById('rangeChart');

                html2canvas(chartCanvas1).then(canvas1 => {
                    const imgData1 = canvas1.toDataURL('image/png');
                    const imgWidth1 = pageWidth - 20;
                    const imgHeight1 = (canvas1.height / canvas1.width) * imgWidth1;

                    doc.addImage(imgData1, 'PNG', 10, 30 + imgHeight, imgWidth1, imgHeight1);

                    html2canvas(chartCanvas2).then(canvas2 => {
                        const imgData2 = canvas2.toDataURL('image/png');
                        const imgHeight2 = (canvas2.height / canvas2.width) * imgWidth1;

                        if (30 + imgHeight + imgHeight1 + imgHeight2 > pageHeight) {
                            doc.addPage();
                            doc.addImage(imgData2, 'PNG', 10, 20, imgWidth1, imgHeight2);
                        } else {
                            doc.addImage(imgData2, 'PNG', 10, 40 + imgHeight + imgHeight1, imgWidth1, imgHeight2);
                        }

                        // Fetch data tabel dan tambahkan ke PDF
                        fetchData().then(data => {
                            const tableData = data.map((entry, index) => ({
                                no: index + 1,
                                date: formatDate(entry.date),
                                hatsumono1: entry.hatsumono1 || '-',
                                hatsumono2: entry.hatsumono2 || '-',
                                average: entry.average || '-',
                                range: entry.range_value || '-',
                                inspector1: entry.inspector || '-',
                                inspector2: entry.inspector2 || '-',
                                leader_name: entry.leader_name || '-',
                                supervisor_name: entry.supervisor_name || '-',
                                notes_keabnormalan: entry.notes_keabnormalan || '-',
                            }));

                            doc.addPage();
                            doc.autoTable({
                                head: [['No', 'Tanggal', 'H1', 'H2', 'Average', 'Range', 'Shift1', 'Shift2', 'Leader', 'SPV', 'Keabnormalan']],
                                body: tableData.map(row => [
                                    row.no,
                                    row.date,
                                    row.hatsumono1,
                                    row.hatsumono2,
                                    row.average,
                                    row.range,
                                    row.inspector1,
                                    row.inspector2,
                                    row.leader_name,
                                    row.supervisor_name,
                                    row.notes_keabnormalan,
                                ]),
                                startY: 20,
                                theme: 'grid',
                                headStyles: { fillColor: [22, 160, 133] },
                                styles: { fontSize: 8, cellPadding: 2, halign: 'center' },
                                columnStyles: {
                                    0: { cellWidth: 10 }, // No
                                    1: { cellWidth: 17 }, // Tanggal
                                    2: { cellWidth: 17 }, // Hatsumono 1
                                    3: { cellWidth: 17 }, // Hatsumono 2
                                    4: { cellWidth: 17 }, // Average
                                    5: { cellWidth: 17 }, // Range
                                    6: { cellWidth: 17 }, // Shift1
                                    7: { cellWidth: 17 }, // Shift2
                                    8: { cellWidth: 17 }, // Leader
                                    9: { cellWidth: 17 }, // SPV
                                    10: { cellWidth: 17 }, // Keabnormalan
                                },
                            });

                            // Simpan file PDF
                            doc.save('check_sheet.pdf');

                            // Tampilkan notifikasi lanjutan
                            Swal.fire({
                                title: 'Tersimpan!',
                                text: 'Check Sheet berhasil disimpan sebagai PDF. Apakah Anda ingin melanjutkan proses reset data?',
                                icon: 'success',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ya, Reset',
                                cancelButtonText: 'Batal'
                            }).then(async (resetConfirm) => {
                                if (resetConfirm.isConfirmed) {
                                    // Proses reset data
                                    const response = await fetch('../../../php/reset_data.php?table=idh25a');
                                    const result = await response.json();

                                    if (result.status === 'success') {
                                        Swal.fire('Reset!', result.message, 'success').then(() => {
                                            location.reload(); // Refresh halaman setelah reset
                                        });
                                    } else {
                                        Swal.fire('Gagal Reset', result.message, 'error');
                                    }
                                } else {
                                    Swal.fire('Proses Reset Dibatalkan', '', 'info');
                                }
                            });
                        });
                    });
                });
            });
        }
    });
});

// Menampilkan Tabel
const toggleTableButton = document.getElementById('toggleTableButton');
toggleTableButton.addEventListener('click', () => {
    const tableContainer = document.getElementById('table-container');
    if (tableContainer.style.display === 'none') {
        tableContainer.style.display = 'block';
        toggleTableButton.textContent = 'Hide Table';
        tableContainer.style.opacity = 0; // Mulai dari transparan
        setTimeout(() => {
            tableContainer.style.transition = 'opacity 0.5s'; // Durasi transisi
            tableContainer.style.opacity = 1; // Fade in
        }, 10);
    } else {
        tableContainer.style.transition = 'opacity 0.5s'; // Durasi transisi
        tableContainer.style.opacity = 0; // Mulai fade out
        setTimeout(() => {
            tableContainer.style.display = 'none';
            toggleTableButton.textContent = 'Show Table';
        }, 500); // Waktu yang sama dengan durasi transisi
    }
});

// Render Tabel
function renderTable(data) {
    const tableContainer = document.getElementById('table-container');
    let tableHTML = '<table><tr><th>No</th><th>Date</th><th>Hatsumono 1</th><th>Hatsumono 2</th><th>Average</th><th>Range</th><th>Inspector 1</th><th>Inspector 2</th><th>Leader Name</th><th>Supervisor Name</th><th>Notes Keabnormalan</th></tr>';

    data.forEach((entry, index) => {
        const formattedDate = formatDate(entry.date ?? '');
        tableHTML += `<tr>
                        <td>${index + 1}</td>
                        <td>${formattedDate}</td>
                        <td>${entry.hatsumono1 ?? ''}</td>
                        <td>${entry.hatsumono2 ?? ''}</td>
                        <td>${entry.average ?? ''}</td>
                        <td>${entry.range_value ?? ''}</td>
                        <td>${entry.inspector ?? ''}</td?8>
                        <td>${entry.inspector2 ?? ''}</td>
                        <td>${entry.leader_name ?? ''}</td>
                        <td>${entry.supervisor_name ?? ''}</td>
                        <td>${entry.notes_keabnormalan ?? ''}</td>
                    </tr>`;
    });

    tableHTML += '</table>';
    tableContainer.innerHTML = tableHTML;
}