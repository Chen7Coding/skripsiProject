/* document.addEventListener("DOMContentLoaded", function () {
    const filterButtons = document.querySelectorAll(".flex.gap-2 button");
    const orderCards = document.querySelectorAll("[data-status]");

    filterButtons.forEach((button) => {
        button.addEventListener("click", () => {
            // Hapus kelas 'aktif' dari semua tombol
            filterButtons.forEach((btn) => {
                btn.classList.remove("bg-amber-600", "text-white");
                btn.classList.add("bg-gray-200", "text-gray-700");
            });

            // Tambahkan kelas 'aktif' ke tombol yang diklik
            button.classList.add("bg-amber-600", "text-white");
            button.classList.remove("bg-gray-200", "text-gray-700");

            const filterStatus = button.id.replace("filter-", "");

            orderCards.forEach((card) => {
                const status = card.dataset.status;

                if (filterStatus === "semua") {
                    card.style.display = "flex";
                } else if (filterStatus === "aktif") {
                    // Tampilkan pesanan yang sedang diproses atau dikirim
                    if (
                        status === "diproses" ||
                        status === "dikirim" ||
                        status === "pending"
                    ) {
                        card.style.display = "flex";
                    } else {
                        card.style.display = "none";
                    }
                } else if (filterStatus === "selesai") {
                    // Tampilkan pesanan yang sudah selesai
                    if (status === "completed" || status === "selesai") {
                        card.style.display = "flex";
                    } else {
                        card.style.display = "none";
                    }
                }
            });
        });
    });
});
 */
