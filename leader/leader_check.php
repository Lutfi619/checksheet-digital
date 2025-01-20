<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leader Check</title>
    <link rel="stylesheet" href="../css/leader_check.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Fungsi untuk memformat tanggal
        function formatDate(dateString) {
            const dateObj = new Date(dateString);
            const day = dateObj.getDate().toString().padStart(2, '0');
            const month = dateObj.toLocaleString('default', { month: 'short' });
            const year = dateObj.getFullYear().toString().slice(-2);
            return `${day}-${month}-${year}`;
        }

        // Fungsi untuk memformat tanggal pada tabel
        function renderTable() {
            const rows = document.querySelectorAll('table tr');
            rows.forEach((row, index) => {
                if (index === 0) return; // Lewati header
                const dateCell = row.cells[1]; // Kolom tanggal di posisi kedua setelah "No"
                dateCell.textContent = formatDate(dateCell.textContent);
            });
        }

        // Panggil fungsi setelah halaman dimuat
        document.addEventListener("DOMContentLoaded", () => {
            renderTable();
            renderChart(); // Panggil renderChart di sini
        });
    </script>
</head>
<body>
    <div class="container">
        <h1>Leader Check</h1>
        <?php
        // Ambil parameter type dari URL
        $type = isset($_GET['type']) ? $_GET['type'] : 'idh25a';

        // Tentukan nama tabel dan URL grafik berdasarkan parameter type
        $table_name = $type;
        $graph_url = "../pages/graph" . $type . ".html";

        // Koneksi ke database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "pengukuran_db";

        // Buat koneksi
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Periksa koneksi
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        ?>

        <form action="leader_check.php?type=<?php echo $type; ?>" method="post">
            <div class="form-group">
                <label for="date">Date:</label>
                <select name="date" id="date" required>
                    <?php
                    // Query untuk mengambil tanggal yang tersedia
                    $sql = "SELECT date FROM $table_name";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value=\"" . $row['date'] . "\">" . $row['date'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="leader_name">Leader Name:</label>
                <input type="text" id="leader_name" name="leader_name" required>
            </div>

            <div class="form-group">
                <button type="submit">Submit</button>
            </div>
        </form>

        <div class="chart-container">
            <canvas id="roughnessChart" width="400" height="200"></canvas>
            <canvas id="rangeChart" width="400" height="200"></canvas>
        </div>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Dapatkan data dari form
            $date = $_POST['date'];
            $leader_name = $_POST['leader_name'];

            // Query untuk memperbarui data
            $sql = "UPDATE $table_name SET leader_name='$leader_name' WHERE date='$date'";

            if ($conn->query($sql) === TRUE) {
                echo "<p class='success'>Record updated successfully</p>";
            } else {
                echo "<p class='error'>Error updating record: " . $conn->error . "</p>";
            }
        }

        // Tampilkan tabel hasil pengukuran setelah update
        $sql = "SELECT * FROM $table_name";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Header tabel, tambahkan kolom "No"
            echo '<table><tr><th>No</th><th>Date</th><th>Hatsumono 1</th><th>Hatsumono 2</th><th>Average</th><th>Range</th><th>Inspector</th><th>Leader Name</th><th>Supervisor Name</th><th>Notes Keabnormalan</th></tr>';
            
            // Inisialisasi nomor urut
            $no = 1;

            // Loop untuk menampilkan data
            while($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $no++ . '</td>'; // Kolom No
                echo '<td>' . $row['date'] . '</td>';
                echo '<td>' . $row['hatsumono1'] . '</td>';
                echo '<td>' . $row['hatsumono2'] . '</td>';
                echo '<td>' . $row['average'] . '</td>';
                echo '<td>' . $row['range_value'] . '</td>';
                echo '<td>' . $row['inspector'] . '</td>';
                echo '<td>' . (isset($row['leader_name']) ? $row['leader_name'] : '') . '</td>';
                echo '<td>' . (isset($row['supervisor_name']) ? $row['supervisor_name'] : '') . '</td>';
                echo '<td>' . $row['notes_keabnormalan'] . '</td>';
                echo '</tr>';
            }
            
            echo '</table>';
        } else {
            echo "<p class='info'>No results</p>";
        }

        $conn->close();
        ?>
    </div>

    <script>
        async function fetchData() {
            const urlParams = new URLSearchParams(window.location.search);
            const type = urlParams.get('type') || 'idh25a'; // Dapatkan tipe item dari URL

            const response = await fetch(`../php/fetch_data.php?table=${type}`);
            const data = await response.json();
            return data;
        }

        // Fungsi untuk memformat tanggal agar bisa digunakan di seluruh halaman
        function formatDate(dateString) {
                const dateObj = new Date(dateString);
                const day = dateObj.getDate().toString().padStart(2, '0'); // Menambah 0 jika hari kurang dari 10
                const month = dateObj.toLocaleString('default', { month: 'short' }); // Nama bulan singkat
                const year = dateObj.getFullYear().toString().slice(-2); // Dua digit terakhir tahun

                return `${day}-${month}-${year}`; // Hasil: 19-Mar-24
            }

        // Render Chart
        async function renderChart() {
            const data = await fetchData();
            const ctxRoughness = document.getElementById('roughnessChart').getContext('2d');
            const ctxRange = document.getElementById('rangeChart').getContext('2d');

            // Mendapatkan label untuk sumbu X yang mencakup informasi tanggal, inspector, leader, dan supervisor
            const xLabels = data.map(entry => {
                const rawDate = entry.date || ''; // Memastikan tanggal ada
                const date = rawDate ? formatDate(rawDate) : ''; // Format atau kosong jika tanggal tidak ada
                const inspector1 = entry.inspector ? `${entry.inspector}` : '';
                const inspector2 = entry.inspector2 ? `${entry.inspector2}` : '';
                const leaderName = entry.leader_name ? `${entry.leader_name}` : '';
                const supervisorName = entry.supervisor_name ? `${entry.supervisor_name}` : '';
                // Menggabungkan semua elemen yang tersedia ke dalam satu label dengan baris baru (\n)
                return [inspector1, inspector2, leaderName, supervisorName, date].filter(Boolean).join('\n');
            });

            //mendapatkan data lainnya untuk grafik
            const dates = data.map(entry => entry.date);
            const hatsumono1 = data.map(entry => entry.hatsumono1);
            const hatsumono2 = data.map(entry => entry.hatsumono2);
            const averages = data.map(entry => entry.average);
            const ranges = data.map(entry => entry.range_value);

            new Chart(ctxRoughness, {
                type: 'line',
                data: {
                    labels: xLabels,
                    datasets: [
                        {
                            label: 'Hatsumono 1',
                            data: hatsumono1,
                            borderColor: 'rgba(128, 128, 128, 1)',
                            borderWidth: 1,
                            pointStyle: 'rect',
                            pointRadius: 5,
                            pointBackgroundColor: 'rgba(128, 128, 128, 1)',
                            fill: false,
                            showLine: false
                        },
                        {
                            label: 'Hatsumono 2',
                            data: hatsumono2,
                            borderColor: 'rgba(30, 144, 255, 1)',
                            borderWidth: 1,
                            pointStyle: 'triangle',
                            pointRadius: 5,
                            pointBackgroundColor: 'rgba(30, 144, 255, 1)',
                            fill: false,
                            showLine: false
                        },
                        {
                            label: 'Average',
                            data: averages,
                            borderColor: 'rgba(0, 255, 0, 1)',
                            borderWidth: 1,
                            pointStyle: 'circle',
                            pointRadius: 5,
                            pointBackgroundColor: 'rgba(0, 255, 0, 1)',
                            fill: false
                        }
                    ]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true, max: 17, ticks: { stepSize: 0.5 } },
                        x: {
                            ticks:{
                                autoSkip: false,
                                padding: 10,
                                callback: function(value, index, values) {
                                    return xLabels[index].split('\n');
                                },
                                maxRotation: 15,
                                minRotation: 0,
                                offset: true
                            }
                        }
                    },
                    plugins: {
                        legend: { labels: { usePointStyle: true } },
                        tooltip: {
                            callbacks: {
                                beforeBody: function(tooltipItems) {
                                    // Mengambil data label yang sesuai
                                    const index = tooltipItems[0].dataIndex; // Indeks data
                                    const inspector1 = data[index].inspector || '';
                                    const inspector2 = data[index].inspector2 || '';
                                    const leaderName = data[index].leader_name || '';
                                    const supervisorName = data[index].supervisor_name || '';

                                    // Membuat string keterangan
                                    return [
                                        `QC 1: ${inspector1}`,
                                        `QC 2: ${inspector2}`,
                                        `Leader: ${leaderName}`,
                                        `Supervisor: ${supervisorName}`
                                    ];
                                }
                            }
                        },
                        annotation: {
                            annotations: {
                                line1: {
                                    type: 'line',
                                    yMin: 14,
                                    yMax: 14,
                                    borderColor: 'rgba(255, 0, 0, 1)',
                                    borderWidth: 2,
                                    borderDash: [5, 5],
                                    label: {
                                        content: 'SU',
                                        enabled: true,
                                        position: 'start',
                                        backgroundColor: 'rgba(255, 255, 255, 0.5)',
                                        color: 'rgba(255, 0, 0, 1)',
                                        xAdjust: -10,
                                        yAdjust: -10
                                    }
                                },
                                line2: {
                                    type: 'line',
                                    yMin: 12,
                                    yMax: 12,
                                    borderColor: 'rgba(0, 0, 255, 1)',
                                    borderWidth: 2,
                                    borderDash: [10, 5],
                                    label: {
                                        content: 'UCL',
                                        enabled: true,
                                        position: 'start',
                                        backgroundColor: 'rgba(255, 255, 255, 0.5)',
                                        color: 'rgba(0, 0, 255, 1)',
                                        xAdjust: -10,
                                        yAdjust: -10
                                    }
                                }
                            }
                        }
                    }
                }
            });


            //membuat grafik range
            new Chart(ctxRange, {
                type: 'line',
                data: {
                    labels: xLabels, // Menggunakan xLabels yang sama
                    datasets: [
                        {
                            label: 'Range',
                            data: ranges,
                            borderColor: 'rgba(0, 255, 0, 1)',
                            borderWidth: 1,
                            fill: false
                        }
                    ]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true, max: 14, ticks: { stepSize: 1 } },
                        x: {
                            ticks: {
                                autoSkip: false,
                                padding: 10,
                                callback: function (value, index, values) {
                                    return xLabels[index].split('\n');
                                },
                                maxRotation: 15,
                                minRotation: 0,
                                offset: true
                            }
                        }
                    },
                    plugins: {
                        legend: { labels: { usePointStyle: true } },
                        tooltip: {
                            callbacks: {
                                beforeBody: function (tooltipItems) {
                                    // Mengambil data label yang sesuai
                                    const index = tooltipItems[0].dataIndex; // Indeks data
                                    const inspector1 = data[index].inspector || '';
                                    const inspector2 = data[index].inspector2 || '';
                                    const leaderName = data[index].leader_name || '';
                                    const supervisorName = data[index].supervisor_name || '';

                                    // Membuat string keterangan
                                    return [
                                        `QC 1: ${inspector1}`,
                                        `QC 2: ${inspector2}`,
                                        `Leader: ${leaderName}`,
                                        `Supervisor: ${supervisorName}`
                                    ];
                                }
                            }
                        }
                    }
                }
            });
        }
    </script>
</body>
</html>
