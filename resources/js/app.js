import "./bootstrap";
window.Alpine = Alpine;

Alpine.start();

function togglePassword() {
    const passwordInput = document.getElementById("password");
    const eyeIcon = document.getElementById("eyeIcon");
    const eyeOffIcon = document.getElementById("eyeOffIcon");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.remove("hidden");
        eyeOffIcon.classList.add("hidden");
    } else {
        passwordInput.type = "password";
        eyeIcon.classList.add("hidden");
        eyeOffIcon.classList.remove("hidden");
    }
}
