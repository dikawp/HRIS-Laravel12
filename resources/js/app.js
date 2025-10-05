import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

document.addEventListener("alpine:init", () => {
    Alpine.data("mainState", () => ({
        // Cek preferensi tema dari localStorage saat inisialisasi
        isDarkMode: localStorage.getItem("dark") === "true",
        // State for mobile sidebar
        isSideMenuOpen: false,

        // Fungsi untuk toggle tema
        toggleTheme() {
            this.isDarkMode = !this.isDarkMode;
            // Simpan preferensi ke localStorage
            localStorage.setItem("dark", this.isDarkMode);
        },

        // Functions for mobile sidebar
        toggleSideMenu() {
            this.isSideMenuOpen = !this.isSideMenuOpen;
        },
        closeSideMenu() {
            this.isSideMenuOpen = false;
        },
    }));
});

Alpine.start();
