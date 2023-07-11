document.addEventListener("DOMContentLoaded", function(e) {
    // Usage of the IoNav
    let ionav = new IoNav({
        // buttonTarget: document.querySelector("#header"),
        elements: ".logo, .nav-main",
        elementsNav: ".ionav-canvas .ionav-nav-main",
        linkSubmenuClickable: false,
        activeClassToggleOthers: true, // Only one active element is possible at the same time
        mqlQuery: {
            minWidth: "0px",
            maxWidth: "1280px"
        },
        debug: false
    });
});

