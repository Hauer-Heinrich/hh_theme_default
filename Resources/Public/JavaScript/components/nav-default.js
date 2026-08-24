document.addEventListener("DOMContentLoaded", function(e) {
    var menuItems = document.querySelectorAll('li.has--children');

    Array.prototype.forEach.call(menuItems, function(el, i) {
        el.addEventListener("mouseover", function(event) {
            this.className = "has--children open";
            clearTimeout(timer);
        });
        el.addEventListener("mouseout", function(event) {
            timer = setTimeout(function(event) {
                document.querySelector(".has--children.open").className = "has--children";
            }, 1000);
        });
    });

    Array.prototype.forEach.call(menuItems, function(el, i) {
        el.querySelector('a').addEventListener("click",  function(event) {
            event.preventDefault();

            if (this.parentNode.className == "has--children") {
                this.parentNode.className = "has--children open";
                this.setAttribute('aria-expanded', "true");
            } else {
                this.parentNode.className = "has--children";
                this.setAttribute('aria-expanded', "false");
            }

            return false;
        });
    });
});
