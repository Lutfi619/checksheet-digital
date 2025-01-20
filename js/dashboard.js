document.addEventListener("DOMContentLoaded", function() {
    function toggleDropdown(dropdown) {
        // Tutup semua dropdown sebelum menampilkan yang dipilih
        var allDropdowns = document.querySelectorAll('.dropdown-content');
        allDropdowns.forEach(function(dd) {
            dd.style.display = "none";
        });
        
        // Tampilkan atau sembunyikan dropdown yang di-klik
        dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
    }

    function toggleSubmenu(submenu) {
        // Tutup semua submenu sebelum menampilkan yang dipilih
        var allSubmenus = document.querySelectorAll('.submenu');
        allSubmenus.forEach(function(sm) {
            sm.style.display = "none";
        });
        
        // Tampilkan atau sembunyikan submenu yang di-klik
        submenu.style.display = submenu.style.display === "block" ? "none" : "block";
    }

    // Event listener untuk tombol dropdown
    var dropdownButtons = document.querySelectorAll('.dropdown-btn');
    dropdownButtons.forEach(function(btn) {
        btn.addEventListener('click', function(event) {
            event.stopPropagation();
            var dropdownId = this.getAttribute('data-dropdown-id');
            var dropdown = document.getElementById(dropdownId);
            if (dropdown) {
                toggleDropdown(dropdown);
            }
        });
    });

    // Event listener untuk tombol submenu
    var submenuButtons = document.querySelectorAll('.has-submenu');
    submenuButtons.forEach(function(btn) {
        btn.addEventListener('click', function(event) {
            event.stopPropagation();
            var submenuId = this.getAttribute('data-submenu-id');
            var submenu = document.getElementById(submenuId);
            if (submenu) {
                toggleSubmenu(submenu);
            }
        });
    });

    // Tutup dropdown dan submenu jika klik di luar elemen
    document.addEventListener('click', function() {
        var allDropdowns = document.querySelectorAll('.dropdown-content');
        allDropdowns.forEach(function(dd) {
            dd.style.display = "none";
        });
        var allSubmenus = document.querySelectorAll('.submenu');
        allSubmenus.forEach(function(sm) {
            sm.style.display = "none";
        });
    });
});