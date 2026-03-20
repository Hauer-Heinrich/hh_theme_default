(function () {

    const fallback = {
        title: document.title,
        text: "Schau dir das mal an:",
        url: window.location.href,
        shareParams: {},
        locallang: {
            shareSuccess: "Link wurde geteilt.",
            shareAborted: "Teilen abgebrochen.",
            linkCopied: "Link wurde kopiert!",
            linkCopyError: "Kopieren fehlgeschlagen."
        }
    };

    function parseConfig(element) {
        if (!element) return {};
        try {
            return JSON.parse(element.textContent);
        } catch {
            console.warn("Ungültige JSON Config");
            return {};
        }
    }

    function getGlobalConfig() {
        return parseConfig(document.getElementById("share-global-config"));
    }

    function getButtonConfig(button) {
        const id = button.getAttribute("data-share-config");
        return id ? parseConfig(document.getElementById(id)) : {};
    }

    function getDataAttributes(button) {
        const data = {};

        if (button.dataset.shareTitle) data.title = button.dataset.shareTitle;
        if (button.dataset.shareText) data.text = button.dataset.shareText;
        if (button.dataset.shareUrl) data.url = button.dataset.shareUrl;

        // JSON in data attribute
        if (button.dataset.shareParams) {
            try {
                data.shareParams = JSON.parse(button.dataset.shareParams);
            } catch {
                console.warn("Ungültige data-share-params");
            }
        }

        if (button.dataset.shareAnchor) {
            data.anchor = button.dataset.shareAnchor;
        }

        return data;
    }

    function mergeConfigs(button) {
        const globalConfig = getGlobalConfig();
        const buttonConfig = getButtonConfig(button);
        const dataAttrs = getDataAttributes(button);

        return {
            ...fallback,
            ...globalConfig,
            ...buttonConfig,
            ...dataAttrs,

            // 👇 wichtig: nested merge für params + locallang
            shareParams: {
                ...fallback.shareParams,
                ...(globalConfig.shareParams || {}),
                ...(buttonConfig.shareParams || {}),
                ...(dataAttrs.shareParams || {})
            },

            locallang: {
                ...fallback.locallang,
                ...(globalConfig.locallang || {}),
                ...(buttonConfig.locallang || {})
            }
        };
    }

    function enhanceUrl(baseUrl, config) {
        let url = new URL(baseUrl, window.location.origin);

        // Anchor
        if (config.anchor) {
            url.hash = config.anchor;
        }

        // Params
        Object.entries(config.shareParams || {}).forEach(([key, value]) => {
            url.searchParams.set(key, value);
        });

        return url.toString();
    }

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

        const config = mergeConfigs(button);

        const shareData = {
            title: config.title,
            text: config.text,
            url: enhanceUrl(config.url, config)
        };

        if (navigator.share && navigator.canShare?.(shareData)) {
            navigator.share(shareData)
                .then(() => showToast(config.locallang.shareSuccess))
                .catch(() => showToast(config.locallang.shareAborted));
        } else {
            navigator.clipboard.writeText(shareData.url)
                .then(() => showToast(config.locallang.linkCopied))
                .catch(() => showToast(config.locallang.linkCopyError));
        }
    });

})();
