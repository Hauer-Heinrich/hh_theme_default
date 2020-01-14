/*
 * Werbeagentur Hauer-Heinrich GmbH
 * E-Mail: info@hauer-heinrich.de
 * Website: http://www.hauer-heinrich.de
 */

function openLink(link, target) {
    if(target === "_blank") {
        window.open = link;
    } else {
        window.location.href = link;
    }
}

function getCookie(name) {
    var dc = document.cookie;
    var prefix = name + "=";
    var begin = dc.indexOf("; " + prefix);
    if (begin == -1) {
        begin = dc.indexOf(prefix);
        if (begin != 0) return null;
    } else {
        begin += 2;
        var end = document.cookie.indexOf(";", begin);
        if (end == -1) {
            end = dc.length;
        }
    }
    // because unescape has been deprecated, replaced with decodeURI
    //return unescape(dc.substring(begin + prefix.length, end));
    return decodeURI(dc.substring(begin + prefix.length, end));
}

var beUser = getCookie("be_typo_user");

// if cookie be_typo_user dont exists
if (beUser != null) {
    // START: NoIframe
    // if this page is located in e. g. a iframe redirect the browser directly to your site!
    if(window != window.top){
        window.top.location = window.location;
    }
    // END: NoIframe
}

/**
 * Load .css files
 * @public
 * @param {String} url  the url / path to the css file
 */
function loadCSS(url) {
    var link = document.createElement("link");
    link.type = "text/css";
    link.rel = "stylesheet";
    link.href = url;
    document.getElementsByTagName("head")[0].appendChild(link);
}

/**
 * Load .js files
 * @public loadJS(source, callback)
 * @param {String} source  the url / path to the js script
 * @param {String} callback  callback function - optional
 *
 * use: loadJS("/YourPath/ToYourScript.js", function() {  });
 */
function loadJS(source, callback) {
    var script = document.createElement('script');
    var prior = document.getElementsByTagName('body')[0];
    script.async = 1;
    prior.appendChild(script);

    script.onload = script.onreadystatechange = function( _, isAbort ) {
        if(isAbort || !script.readyState || /loaded|complete/.test(script.readyState) ) {
            script.onload = script.onreadystatechange = null;
            script = undefined;

            if(!isAbort) { if(callback) callback(); }
        }
    };

    script.src = source;
}

var dictionary, set_lang;
dictionary = {
    "en-EN": {
        "_header": 'Cookies used on the website!',
        "_message": 'Cookies facilitate the provision of our services. By using our services you agree that we use cookies.',
        "_dismiss": 'I agree!',
        "_allow": 'Allow cookies',
        "_deny": 'Decline',
        "_link": 'Read more',
        "_href": '/datenschutz/',
        "_close": '&#x274c;'
    },
    "de-DE": {
        "_header": 'Diese Seite verwendet Cookies',
        "_message": 'Um unsere Seite für Sie nutzerfreundlich und funktional gestalten zu können, setzen wir für die Analyse unserer Seiten Cookies ein. Wenn Sie zustimmen, stimmen Sie der Verwendung solcher Cookies zu. Bitte besuchen Sie unsere Datenschutzerklärung um mehr zu erfahren.',
        "_dismiss": 'Einverstanden!',
        "_allow": 'Allow cookies',
        "_deny": 'Decline',
        "_link": 'Mehr Informationen',
        "_href": '/datenschutz/',
        "_close": '&#x274c;'
    }
};

/**
 * Print function
 * @public
 * @param {String} dictionary  which language are to choose
 * @param {String} name  key of the text witch should be translated
 */
function set_lang(dictionary, name) {
    var key = name;
    if (dictionary.hasOwnProperty(key)) {
        return dictionary[key];
    }
}

/**
 * Print function
 * @public
 * @param {String} name  key of the text which should be translated
 */
function change_lang(name) {
    var language = document.documentElement.lang;
    if (dictionary.hasOwnProperty(language)) {
        return set_lang(dictionary[language], name);
    } else {
        var specLang = language.toUpperCase();
        if(dictionary.hasOwnProperty(language + "-" + specLang)) {
            return set_lang(dictionary[language + "-" + specLang], name);
        }
    }
}

function elementInViewport(el) {
    var top = el.offsetTop;
    var left = el.offsetLeft;
    var width = el.offsetWidth;
    var height = el.offsetHeight;

    while(el.offsetParent) {
        el = el.offsetParent;
        top += el.offsetTop;
        left += el.offsetLeft;
    }

    return (
        top < (window.pageYOffset + window.innerHeight) &&
        left < (window.pageXOffset + window.innerWidth) &&
        (top + height) > window.pageYOffset &&
        (left + width) > window.pageXOffset
    );
}
