// Elemen untuk efek gelombang
const wave = document.getElementById('wave');

// Gerakan gelombang mengikuti kursor
document.addEventListener('mousemove', (event) => {
    wave.style.left = `${event.pageX}px`;
    wave.style.top = `${event.pageY}px`;
    wave.style.transform = 'translate(-50%, -50%) scale(1.5)';
});

// Efek gelombang tetap saat kursor keluar
document.addEventListener('mouseout', () => {
    wave.style.transform = 'translate(-50%, -50%) scale(1)';
});

document.getElementById('registerForm').addEventListener('submit', function(e) {
e.preventDefault(); // Mencegah form dikirim secara normal

const formData = new FormData(this);

fetch('register_process.php', {
    method: 'POST',
    body: formData,
})
.then(response => response.json())
.then(data => {
    const messageDiv = document.getElementById('register-message');
    if (data.success) {
        // Tampilkan pesan sukses
        messageDiv.textContent = 'Pembuatan akun sukses!';
        messageDiv.style.color = 'green';
        this.reset(); // Reset form setelah sukses
    } else {
        // Tampilkan pesan error
        messageDiv.textContent = data.message || 'Registrasi gagal.';
        messageDiv.style.color = 'red';
    }
})
.catch(error => {
    console.error('Error:', error);
    const messageDiv = document.getElementById('register-message');
    messageDiv.textContent = 'Terjadi kesalahan pada server.';
    messageDiv.style.color = 'red';
});
});
