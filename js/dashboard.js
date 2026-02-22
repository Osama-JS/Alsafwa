// Dashboard Global Scripts

document.addEventListener("DOMContentLoaded", function () {
    // ── Sidebar Toggle (Mobile) ──────────────────────────────────────
    const sidebarToggle = document.getElementById("sidebarToggle");
    const sidebar = document.querySelector(".sidebar");

    if (sidebarToggle && sidebar) {
        // Create overlay for mobile
        let overlay = document.getElementById("sidebarOverlay");
        if (!overlay) {
            overlay = document.createElement("div");
            overlay.id = "sidebarOverlay";
            overlay.style.cssText = `
                display:none;position:fixed;inset:0;background:rgba(0,0,0,0.4);
                z-index:999;backdrop-filter:blur(2px);transition:opacity 0.3s;
            `;
            document.body.appendChild(overlay);
        }

        sidebarToggle.addEventListener("click", function () {
            sidebar.classList.toggle("active");
            const isOpen = sidebar.classList.contains("active");
            overlay.style.display = isOpen ? "block" : "none";
            document.body.style.overflow = isOpen ? "hidden" : "";
        });

        overlay.addEventListener("click", function () {
            sidebar.classList.remove("active");
            overlay.style.display = "none";
            document.body.style.overflow = "";
        });
    }

    // ── Bootstrap Tooltips ───────────────────────────────────────────
    var tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]'),
    );
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // ── Image Preview ────────────────────────────────────────────────
    window.previewImage = function (input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var previewElement = document.getElementById(previewId);
                if (previewElement) {
                    previewElement.src = e.target.result;
                    previewElement.style.display = "block";
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    };

    // ── Auto-hide Alerts after 5 seconds ────────────────────────────
    setTimeout(function () {
        let alerts = document.querySelectorAll(".alert-dismissible");
        alerts.forEach(function (alert) {
            let bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
});
