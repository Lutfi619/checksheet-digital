<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervisor Check</title>
    <link rel="stylesheet" href="../css/dashboard.css">
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

    </style>
</head>
<body>
<div class="sidebar">
    <h2>Informasi Supervisor</h2>
    <ul>
        <li><a href="#panduan">Panduan Supervisor</a></li>
    </ul>
</div>


    <div class="main-content">
        <div class="header">
            <h1>Supervisor Check Lines</h1>
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
                    <button class="dropdown-btn" onclick="toggleDropdown('f-line-cr9')">902F LINE CR-9</button>
                    <div class="dropdown-content" id="f-line-cr9">
                        <div class="nested-dropdown">
                            <button onclick="toggleSubmenu('f-20')">#20</button>
                            <div class="submenu" id="f-20">
                                <a href="option-a.html">Option A</a>
                            </div>
                            <button class="has-submenu" onclick="toggleSubmenu('f-30')">#30</button>
                            <div class="submenu" id="f-30">
                                <a href="option-a.html">Option A</a>
                                <a href="option-b.html">Option B</a>
                                <a href="option-c.html">Option C</a>
                            </div>
                            <button onclick="toggleSubmenu('f-70')">#70</button>
                            <div class="submenu" id="f-70">
                                <a href="option-a.html">Option A</a>
                            </div>
                            <button onclick="toggleSubmenu('f-80')">#80</button>
                            <div class="submenu" id="f-80">
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

    <script src="../js/dashboard.js"></script>
</body>
</html>
