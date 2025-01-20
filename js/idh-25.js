// Fungsi untuk submit form
//notifikasi sweetalert
document.getElementById('checkSheetForm').addEventListener('submit', async function (event) {
    event.preventDefault(); // Mencegah reload halaman

    const formData = new FormData(this);

    try {
        const response = await fetch('../../php/save_data.php', {
            method: 'POST',
            body: formData,
        });

        const result = await response.json();

        if (result.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: result.message,
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = window.location.href; // Refresh halaman
            });
        } else if (result.status === 'warning') {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: result.message,
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = window.location.href; // Refresh halaman
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Kesalahan',
                text: result.message,
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = window.location.href; // Refresh halaman
            });
        }
    } catch (error) {
        console.error('Fetch Error:', error);

        Swal.fire({
            icon: 'error',
            title: 'Kesalahan',
            text: 'Gagal mengirim data. Periksa koneksi Anda.',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = window.location.href; // Refresh halaman
        });
    }
});

// Fungsi untuk berpindah halaman
function setupNextButton(buttonId, targetPage) {
    const button = document.getElementById(buttonId);
    if (button) {
        button.addEventListener('click', function () {
            window.location.href = targetPage;
        });
    }
}

// GD-B LINE CR 9
setupNextButton('NextButtonA', 'idh25B.html');
setupNextButton('NextButtonB', 'idh25C.html');
setupNextButton('NextButtonC', 'idh25D.html');
setupNextButton('NextButtonD', 'imc-12arasa.html');
setupNextButton('NextButtonimc12arasa', 'imc-12flat.html');
setupNextButton('NextButtonimc12flat', 'imc-61arasa.html');
setupNextButton('NextButtonimc61arasa', 'imc-61flat.html');
setupNextButton('NextButtonimc61flat', 'imc-94arasam20.html');
setupNextButton('NextButtonimc94arasam20', 'imc-94flatm20.html');
setupNextButton('NextButtonimc94flatm20', 'imc-94arasam10.html');
setupNextButton('NextButtonimc94arasam20', 'imc-94flatm20.html');
setupNextButton('NextButtonimc94arasam10', 'imc-94flatm10.html');
setupNextButton('NextButtonimc94flatm10', 'imc-94arasa176.html');
setupNextButton('NextButtonimc94arasa176', 'imc-103arasam20.html');
setupNextButton('NextButtonimc103arasam20', 'imc-103flatm20.html');
setupNextButton('NextButtonimc103flatm20', 'imc-103arasam10.html');
setupNextButton('NextButtonimc103arasam10', 'imc-103flatm10.html');
setupNextButton('NextButtonimc103flatm10', 'imc-103arasa176.html');
setupNextButton('NextButtonimc103arasa176', 'imc-19arasainj14.html');
setupNextButton('NextButtonimc19arasainj', 'imc-19roundinj14.html');
setupNextButton('NextButtonimc19roundinj', 'imc-20arasainj14.html');
setupNextButton('NextButtonimc20arasainj', 'imc-20roundinj14.html');
setupNextButton('NextButtonimc20roundinj', 'imc-21arasainj14.html');
setupNextButton('NextButtonimc21arasainj', 'imc-21roundinj14.html');
setupNextButton('NextButtonimc21roundinj', 'imc-28arasainj14.html');
setupNextButton('NextButtonimc28arasainj', 'imc-28roundinj14.html');
setupNextButton('NextButtonimc28roundinj', 'imc-29arasainj14.html');
setupNextButton('NextButtonimc29arasainj', 'imc-29roundinj14.html');
setupNextButton('NextButtonimc29roundinj', 'imc-40arasainj14.html');
setupNextButton('NextButtonimc40arasainj', 'imc-40roundinj14.html');
setupNextButton('NextButtonimc40roundinj', '../../dashboard.html');

// 902F-A LINE CR 2
setupNextButton('NextButton46A', 'idh46B.html');
setupNextButton('NextButton46B', 'idh46C.html');
setupNextButton('NextButton46C', 'idh46D.html');
setupNextButton('NextButton46D', '107arasa.html');
setupNextButton('NextButton107arasa', '107round.html');
setupNextButton('NextButton107round', '108arasa.html');
setupNextButton('NextButton108arasa', '108round.html');
setupNextButton('NextButton108round', '109arasam20.html');
setupNextButton('NextButton109arasam20', '109flatm20.html');
setupNextButton('NextButton109flatm20', '109arasam10.html');
setupNextButton('NextButton109arasam10', '109flatm10.html');
setupNextButton('NextButton109flatm10', '109arasa176.html');
setupNextButton('NextButton109arasa176', '110arasam20.html');
setupNextButton('NextButton110arasam20', '110flatm20.html');
setupNextButton('NextButton110flatm20', '110arasam10.html');
setupNextButton('NextButton110arasam10', '110flatm10.html');
setupNextButton('NextButton110flatm10', '110arasa176.html');
setupNextButton('NextButton110arasa176', '111arasainj14.html');
setupNextButton('NextButton111arasainj', '111roundinj14.html');
setupNextButton('NextButton111roundinj', '112arasainj14.html');
setupNextButton('NextButton112arasainj', '112roundinj14.html');
setupNextButton('NextButton112roundinj', '113arasainj14.html');
setupNextButton('NextButton113arasainj', '113roundinj14.html');
setupNextButton('NextButton113roundinj', '114arasainj14.html');
setupNextButton('NextButton114arasainj', '114roundinj14.html');
setupNextButton('NextButton114roundinj', '115arasainj14.html');
setupNextButton('NextButton115arasainj', '115roundinj14.html');
setupNextButton('NextButton115roundinj', '116arasanj14.html');
setupNextButton('NextButton116arasainj', '116roundinj14.html');
setupNextButton('NextButton116roundinj', '../../dashboard');

// 902F-B LINE CR 9
setupNextButton('NextButton23A', 'idh23B.html');
setupNextButton('NextButton23B', 'idh23C.html');
setupNextButton('NextButton23C', 'idh23D.html');
setupNextButton('NextButton23D', '902FB-251arasa.html');
setupNextButton('NextButton902fb251arasa', '902FB-251round.html');
setupNextButton('NextButton902fb251round', '902FB-61arasa.html');
setupNextButton('NextButton902fb61arasa', '902FB-61round.html');
setupNextButton('NextButton902fb61round', '902FB-94arasam20.html');
setupNextButton('NextButton902fb94arasam20', '902FB-94flatm20.html');
setupNextButton('NextButton902fb94flatm20', '902FB-94arasam10.html');
setupNextButton('NextButton902fb94arasam20', '902FB-94flatm20.html');
setupNextButton('NextButton902fb94arasam10', '902FB-94flatm10.html');
setupNextButton('NextButton902fb94flatm10', '902FB-94arasa176.html');
setupNextButton('NextButton902fb94arasa176', '902FB-103arasam20.html');
setupNextButton('NextButton902fb103arasam20', '902FB-103flatm20.html');
setupNextButton('NextButton902fb103flatm20', '902FB-103arasam10.html');
setupNextButton('NextButton902fb103arasam10', '902FB-103flatm10.html');
setupNextButton('NextButton902fb103flatm10', '902FB-103arasa176.html');
setupNextButton('NextButton902fb103arasa176', 'imc-19arasainj14.html');
setupNextButton('NextButton902fb19arasainj', 'imc-19roundinj14.html');
setupNextButton('NextButton902fb19roundinj', 'imc-20arasainj14.html');
setupNextButton('NextButton902fb20arasainj', 'imc-20roundinj14.html');
setupNextButton('NextButton902fb20roundinj', 'imc-21arasainj14.html');
setupNextButton('NextButton902fb21arasainj', 'imc-21roundinj14.html');
setupNextButton('NextButton902fb21roundinj', 'imc-28arasainj14.html');
setupNextButton('NextButton902fb28arasainj', 'imc-28roundinj14.html');
setupNextButton('NextButton902fb28roundinj', 'imc-29arasainj14.html');
setupNextButton('NextButton902fb29arasainj', 'imc-29roundinj14.html');
setupNextButton('NextButton902fb29roundinj', 'imc-40arasainj14.html');
setupNextButton('NextButton902fb40arasainj', 'imc-40roundinj14.html');
setupNextButton('NextButton902fb40roundinj', '../../dashboard.html');









