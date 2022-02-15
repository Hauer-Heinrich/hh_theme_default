/**
 * https://blog.t3bootstrap.de/2021/08/fix-fuer-e-mail-link-probleme-ab-typo3-version-11-3-2-10-4-19-9-5-29-8-7-42-7-6-53/
 * @modified by Christian Hackl
 */
document.addEventListener("DOMContentLoaded", function() {
    let links = document.querySelectorAll('a');
    links.forEach(function(item){
        if (item.getAttribute('data-mailto-token') != null) {
            item.innerHTML = item.innerHTML.replace('@~@', '<i class="icon icon-at"></i>');
        }
    });
});
