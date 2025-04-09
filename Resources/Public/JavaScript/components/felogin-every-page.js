// Example Script to show FE-Login form on every Page
(function() {
    /*** Register plugin in window object */
    this.feLogin = function() {
        let defaults = {
            "requestUrl": '//www.test-theme-default.com/frontend-login',
            "loginHtmlContainer": '.frame-type-felogin_login',
            "destinationContainer": 'main'
        };

        this.elements = [];
        this.settings = (arguments[0] && typeof arguments[0] === 'object') ? extendDefaults(defaults, arguments[0]) : defaults;

        this.init();
    }

    /*** Public Methods */
    feLogin.prototype.init = function() {
        if(checkSettings.call(this)) {
            build.call(this);
        }
    }

    feLogin.prototype.update = function(element) {
        console.log('Update plugin.');
    }

    /*** Private Methods */
    // get felogin-form from requestUrl and place it into destinationContainer
    function build(element) {
        let request = new XMLHttpRequest();
        request.open('GET', this.settings.requestUrl, true);
        request.onload = function() {
            if (request.status >= 200 && request.status < 400) {
                var resp = request.responseText;
                var parser = new DOMParser();
                var xmlDoc = parser.parseFromString(resp,"text/html");
                var feLogin = xmlDoc.querySelector(this.settings.loginHtmlContainer);
                document.querySelector(this.settings.destinationContainer).innerHTML=feLogin.innerHTML;
            } else {

            }
        };
        request.onerror = function() {};
        request.send();
    }

    function checkSettings(element) {
        if(this.settings.requestUrl.startsWith('//www.test-theme-default.com')) {
            console.group("frontend login");
            console.info("%c %s", "background-color:yellow; color: black", "SET proper request URL! ");
            console.groupEnd();
            return false;
        }

        if((this.settings.requestUrl?.trim()?.length || 0) > 0) {
            console.group("frontend login");
            console.info("%c %s", "background-color:yellow; color: black", "Request URL empty or undefined! ");
            console.groupEnd();
            return true;
        }
        return false;
    }


    function extendDefaults(defaults, properties) {
        Object.keys(properties).forEach(property => {
            if(properties.hasOwnProperty(property)) {
                defaults[property] = properties[property];
            }
        });

        return defaults;
    }
}());

// Instantiate in your main script
// feLogin = new feLogin();
