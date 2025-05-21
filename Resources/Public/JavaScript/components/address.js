(function () {
    const addressListsItems = document.querySelectorAll(".tt_address_list .article");

    addressListsItems.forEach((addressListItem) => {
        const link = addressListItem.querySelector("a");
        if(link) {
            addressListItem.classList.add("cursor-pointer");
            addressListItem.addEventListener("click", function(event) {
                openLink(link.getAttribute("href"));
            });
        }
    });

    function openLink(link, target) {
        if(target === "_blank") {
            window.open(link);
        } else {
            window.location.href = link;
        }
    }
})();
