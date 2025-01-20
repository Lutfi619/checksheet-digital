<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leader Check</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Gaya CSS untuk laporan member QC */
        #reportListOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        #reportListOverlay .popup-form {
            position: relative;
            width: 100%;
            max-width: 600px;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            overflow-y: auto;
            max-height: 80%;
        }

        #reportListOverlay h2 {
            font-size: 1.5em;
            color: darkblue;
            margin-bottom: 10px;
        }

        #reportListOverlay .report-content {
            text-align: left;
        }

        #reportListOverlay .report-card {
            background-color: lightgray;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        #reportListOverlay .report-card p {
            margin: 5px 0;
            color: black;
        }

        #reportListOverlay hr {
            border: 0;
            border-top: 1px solid #ddd;
            margin: 10px 0;
        }

        #reportListOverlay .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 2em;
            cursor: pointer;
            color: red;
        }

        #reportListOverlay {
            display: none; /* Menyembunyikan form secara default */
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            background-color: rgba(0, 191, 255, 0);
            color: #fff;
            padding: 25px;
            position: fixed;
            height: 100%;
        }

        .sidebar h2 {
            margin: 5px;
            padding: 0px;
            font-size: 27px;
            text-align: center;
        }

        .sidebar ul {
            list-style: none;
            padding: 5px;
        }

        .sidebar ul li {
            margin: 10px 0;
        }

        .sidebar ul li a {
            color: #ffffff;
            text-decoration: dashed;
            font-size: 23px;
            display: block;
            padding: 10px;
            border-radius: 5px;
            transition: background 0.3s, padding-left 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: #0066cc;
            padding-left: 20px;
        }

        /* Menyembunyikan submenu secara default */
        .submenu {
            display: none;
            position: relative;
            top: 100%; /* Tepat di bawah tombol has-submenu */
            left: 0;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            min-width: 150px; /* Sesuaikan sesuai kebutuhan */
        }

        /* Menampilkan submenu saat aktif */
        .submenu.active {
            display: block;
        }

        .bell {
            position: relative;
            display: inline-block;
            margin-left: 10px;
        }

        .badge {
            position: absolute;
            top: -5px;
            right: -10px;
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 3px 6px;
            font-size: 12px;
            font-weight: bold;
            display: none; /* Tersembunyi jika tidak ada laporan */
        }

        .accept-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 10px;
        }

        .accept-btn:hover {
            background-color: #45a049;
        }

        .delete-btn {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 6px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
        }

        .delete-btn:hover {
            background-color: #e60000;
        }

    </style>
</head>
<body>
    <?php
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

    <div class="sidebar">
        <h2>Leader Check</h2>
        <ul>
            <li><a href="#" onclick="showPanduanleader()">Panduan untuk Leader</a></li>
            <li>
                <a href="#" onclick="openReportList()">
                    Laporan member QC
                    <span id="notificationIcon" class="bell">
                        <img src="../gambar/bell.png" alt="Bell" width="20">
                        <span id="notificationBadge" class="badge">0</span>
                    </span>
                </a>
            </li>
        </ul>
    </div>

    <div class="overlay" id="reportListOverlay">
        <div class="popup-form">
            <span class="close-btn" onclick="closeReportList()">&times;</span>
            <h2>Laporan dari Member QC</h2>
            <div class="report-content">
                <?php
                $sql = "SELECT id, report_date, report_line, report_part, report_desc, status FROM leader_reports ORDER BY report_date DESC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<div class='report-card'>";
                        echo "<p><strong>Tanggal:</strong> " . $row["report_date"] . "</p>";
                        echo "<p><strong>Line:</strong> " . $row["report_line"] . "</p>";
                        echo "<p><strong>Nama Part:</strong> " . $row["report_part"] . "</p>";
                        echo "<p><strong>Deskripsi:</strong> " . $row["report_desc"] . "</p>";

                        // Tombol centang hanya muncul jika status laporan belum selesai
                        if ($row["status"] == "pending") {
                            echo "<button class='accept-btn' onclick='acceptReport(" . $row["id"] . ")'>✔ Terima</button>";
                        } else {
                            echo "<p><em>Laporan sudah diterima</em></p>";
                            //tombol x muncul setelah laporan diterima
                            echo "<button class='delete-btn' onclick='deleteReport(" . $row["id"] . ")'>✖ Hapus</button>";
                        }

                        echo "</div><hr>";
                    }
                } else {
                    echo "<p>Belum ada laporan yang diterima.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Leader Check Lines</h1>
        </div>
        <div class="content">
            <div class="card">
                <h3>LINE CR-1</h3>
                <p>Some content goes here.</p>
            </div>
            <div class="card">
                <h3>Line CR-2</h3>
                <p>Some content goes here.</p>
            </div>
            <div class="card">
                <h3>Line CR-3</h3>
                <p>Some content goes here.</p>
            </div>
            <div class="card">
                <h3>Line CR-4</h3>
                <p>Some content goes here.</p>
            </div>
            <div class="card">
                <h3>Line CR-5</h3>
                <p>Some content goes here.</p>
            </div>
            <div class="card">
                <h3>Line CR-6</h3>
                <p>Some content goes here.</p>
            </div>
            <div class="card">
                <h3>Line CR-7</h3>
                <p>Some content goes here.</p>
            </div>
            <div class="card">
                <h3>Line CR-8</h3>
                <p>Some content goes here.</p>
            </div>
            <div class="card">
                <h3>Line CR-9</h3>
                <div class="dropdown">
                    <button class="dropdown-btn" data-dropdown-id="gd-line-cr9" onclick="toggleDropdown('gd-line-cr9')">GD LINE CR-9</button>
                    <div class="dropdown-content" id="gd-line-cr9">
                        <div class="nested-dropdown">
                            <button class="has-submenu" data-submenu-id="gd-20" onclick="toggleSubmenu('gd-20')">#20</button>
                            <div class="submenu" id="gd-20">
                                <a href="../pages/GDLINECR9/idh-25.php">IDH-25</a>
                            </div>
                            <button class="has-submenu" data-submenu-id="gd-30" onclick="toggleSubmenu('gd-30')">#30</button>
                            <div class="submenu" id="gd-30">
                                <a href="../pages/GDLINECR9/imc-12.php">IMC-12</a>
                                <a href="../pages/GDLINECR9/imc-61.php">IMC-61</a>
                            </div>
                            <button class="has-submenu" data-submenu-id="gd-70" onclick="toggleSubmenu('gd-70')">#70</button>
                            <div class="submenu" id="gd-70">
                                <a href="../pages/GDLINECR9/imc-94.php">IMC-94</a>
                                <a href="../pages/GDLINECR9/imc-103.php">IMC-103</a>
                            </div>
                            <button class="has-submenu" data-submenu-id="gd-80" onclick="toggleSubmenu('gd-80')">#80</button>
                            <div class="submenu" id="gd-80">
                                <a href="../pages/GDLINECR9/imc-19.php">IMC-19</a>
                                <a href="../pages/GDLINECR9/imc-20.php">IMC-20</a>
                                <a href="../pages/GDLINECR9/imc-21.php">IMC-21</a>
                                <a href="../pages/GDLINECR9/imc-28.php">IMC-28</a>
                                <a href="../pages/GDLINECR9/imc-29.php">IMC-29</a>
                                <a href="../pages/GDLINECR9/imc-40.php">IMC-40</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dropdown">
                        <button class="dropdown-btn" data-dropdown-id="902fB" onclick="toggleDropdown('902fB')">902F LINE CR-9</button>
                        <div class="dropdown-content" id="902fB">
                            <div class="nested-dropdown">
                                <button class="has-submenu" data-submenu-id="902fB-20" onclick="toggleSubmenu('902fB-20')">#20</button>
                                <div class="submenu" id="902fB-20">
                                    <a href="../pages/902F-B/idh-23.php">IDH - 23</a>
                                </div>
                                <button class="has-submenu" data-submenu-id="902fB-30" class="has-submenu" onclick="toggleSubmenu('902fB-30')">#30</button>
                                <div class="submenu" id="902fB-30">
                                    <a href="../pages/902F-B/imc-251.php">IMC - 251</a>
                                    <a href="../pages/902F-B/imc-61.php">IMC - 61</a>
                                </div>
                                <button class="has-submenu" data-submenu-id="902fB-70" onclick="toggleSubmenu('902fB-70')">#70</button>
                                <div class="submenu" id="902fB-70">
                                    <a href="option-a.html">Option A</a>
                                </div>
                                <button class="has-submenu" data-submenu-id="902fB-80" onclick="toggleSubmenu('902fB-80')">#80</button>
                                <div class="submenu" id="902fB-80">
                                    <a href="option-a.html">Option A</a>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="card">
                <h3>Line CR-10</h3>
                <p>Some content goes here.</p>
            </div>
            <div class="card">
                <h3>Line CR-11</h3>
                <p>Some content goes here.</p>
            </div>
            <div class="card">
                <h3>Line CR-12</h3>
                <p>Some content goes here.</p>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Fungsi untuk memperbarui badge
            function updateNotificationBadge(count) {
                const badge = document.getElementById("notificationBadge");
                if (count > 0) {
                    badge.textContent = count;
                    badge.style.display = "inline-block";
                } else {
                    badge.style.display = "none";
                }
            }

            // Ambil jumlah laporan dari database menggunakan PHP
            fetch("get_report_count.php")
                .then((response) => response.json())
                .then((data) => {
                    updateNotificationBadge(data.count);
                })
                .catch((error) => {
                    console.error("Error fetching report count:", error);
                }); 
        });
    </script>
    <script src="../js/dashboard.js"></script>
    <script src="../js/report.js"></script>
</body>
</html>
