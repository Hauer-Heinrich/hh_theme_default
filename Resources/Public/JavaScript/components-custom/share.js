(function () {
    const shareData = {
        title: document.title,
        text: "Schau dir das mal an:",
        url: window.location.href
    };

    const toast = document.getElementById("toast");

    function showToast(message) {
        if (!toast) return;

        toast.textContent = message;
        toast.classList.add("show");

        setTimeout(() => {
            toast.classList.remove("show");
        }, 2500);
    }

    document.addEventListener("click", function (e) {
        const button = e.target.closest(".link-share");
        if (!button) return;

        // Modern Share API
        if (navigator.share && navigator.canShare?.(shareData)) {
            navigator.share(shareData)
                .then(() => {
                    // showToast("Link wurde erfolgreich geteilt.");
                })
                .catch(() => {
                    showToast("Teilen wurde abgebrochen.");
                });
        } else {
            // Fallback: Clipboard
            navigator.clipboard.writeText(shareData.url)
                .then(() => {
                    showToast("Link wurde kopiert!");
                })
                .catch(() => {
                    showToast("Kopieren fehlgeschlagen.");
                });
        }
    });
})();
