// script.js
const btn = document.getElementById("dark-toggle"); 
const currentTheme = localStorage.getItem("theme"); 

function updateButtonText() {
    if (document.body.classList.contains("dark")) {
        btn.innerHTML = "☀️ Light Mode";
    } else {
        btn.innerHTML = "🌙 Dark Mode";
    }
}

// Cek jika user sebelumnya sudah memilih dark mode
if (currentTheme === "dark") {
    document.body.classList.add("dark");
}

btn.addEventListener("click", () => {
    document.body.classList.toggle("dark");
    let theme = document.body.classList.contains("dark") ? "dark" : "light";
    localStorage.setItem("theme", theme); 
    updateButtonText();
});