document.getElementById("loginForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch("login_process.php", {
        method: "POST",
        body: formData,
    })
    .then((response) => response.json())
    .then((data) => {
        if (data.success) {
            // Redirect user to the appropriate page
            window.location.href = data.redirect;
        } else {
            document.getElementById("login-message").textContent = data.message;
        }
    })
    .catch((error) => {
        console.error("Error:", error);
    });
});
