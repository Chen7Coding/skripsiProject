// resources/js/checkout.js

// Fungsi ini memastikan kode berjalan setelah seluruh halaman dimuat
document.addEventListener("DOMContentLoaded", (event) => {
    // Ambil elemen form dan tombol
    const checkoutForm = document.getElementById("checkout-form");
    const submitButton = document.getElementById("submit-button");
    const buttonText = document.getElementById("button-text");
    const buttonLoading = document.getElementById("button-loading");

    // Pastikan semua elemen ada sebelum menambahkan event listener
    if (checkoutForm) {
        // Tambahkan event listener saat form di-submit
        checkoutForm.addEventListener("submit", function (event) {
            // 1. Cegah perilaku default form (refresh halaman)
            event.preventDefault();

            // 2. Ubah tampilan tombol menjadi loading state
            submitButton.disabled = true;
            buttonText.classList.add("hidden");
            buttonLoading.classList.remove("hidden");

            // 3. Kumpulkan data dari form
            const formData = new FormData(checkoutForm);
            const actionUrl = checkoutForm.getAttribute("action");

            // 4. Kirim data menggunakan Fetch API (AJAX)
            fetch(actionUrl, {
                method: "POST",
                body: formData,
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    // Tambahkan CSRF Token untuk keamanan
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    // 5. Jika berhasil, server akan mengirim URL sukses
                    if (data.success && data.redirect_url) {
                        window.location.href = data.redirect_url;
                    } else {
                        // Jika ada error dari server
                        alert(
                            data.message ||
                                "Terjadi kesalahan. Silakan periksa kembali data Anda."
                        );
                        // Kembalikan tombol ke state semula
                        submitButton.disabled = false;
                        buttonText.classList.remove("hidden");
                        buttonLoading.classList.add("hidden");
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                    alert(
                        "Tidak dapat terhubung ke server. Silakan coba lagi."
                    );
                    // Kembalikan tombol ke state semula
                    submitButton.disabled = false;
                    buttonText.classList.remove("hidden");
                    buttonLoading.classList.add("hidden");
                });
        });
    }
});
