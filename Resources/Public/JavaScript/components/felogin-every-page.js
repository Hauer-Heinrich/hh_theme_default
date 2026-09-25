/**
 * feLogin - blendet das TYPO3-felogin-Formular auf jeder Seite ein.
 *
 * Konfiguration erwartet einen JSON-Block im HTML:
 *
 *   <script type="application/json" id="theme-config-felogin">
 *   {"PAGE_URL_WITH_FELOGIN": "https://domain.tld/login"}
 *   </script>
 *
 * Verwendung:
 *
 *   new FeLogin().init();
 *   new FeLogin({ destinationContainer: '#sidebar', replace: true }).init();
 */
;(function () {
    'use strict';

    var CONFIG_ID = 'theme-config-felogin';
    var LOG_PREFIX = '[feLogin]';

    /**
     * Liest den JSON-Konfigurationsblock aus dem DOM.
     * Gibt null zurueck, wenn er fehlt oder ungueltig ist.
     */
    function readConfig() {
        var el = document.getElementById(CONFIG_ID);

        if (!el) {
            console.warn(
                LOG_PREFIX + ' Kein Konfigurationsblock #' + CONFIG_ID + ' gefunden. ' +
                'Erwartet wird ein <script type="application/json"> mit PAGE_URL_WITH_FELOGIN.'
            );
            return null;
        }

        try {
            return JSON.parse(el.textContent);
        } catch (err) {
            console.warn(LOG_PREFIX + ' Konfigurationsblock ist kein gueltiges JSON:', err);
            return null;
        }
    }

    // Einmalig beim Laden lesen - ausserhalb jedes Blocks, damit alle
    // Methoden darauf zugreifen koennen.
    var config = readConfig();

    function FeLogin(options) {
        var defaults = {
            // URL der Seite, die das felogin-Plugin enthaelt
            requestUrl: config ? config.PAGE_URL_WITH_FELOGIN : '',
            // Selektor des Formulars innerhalb der geladenen Seite
            loginHtmlContainer: '.frame-type-felogin_login',
            // Wohin das Formular in der aktuellen Seite soll
            destinationContainer: 'main',
            // false = anhaengen, true = Inhalt des Ziels ersetzen
            replace: false
        };

        this.settings = Object.assign({}, defaults, options || {});
    }

    /**
     * Prueft die Konfiguration und laedt das Formular.
     */
    FeLogin.prototype.init = function () {
        if (!this.validate()) {
            return Promise.resolve(false);
        }
        return this.build();
    };

    /**
     * Gibt true zurueck, wenn geladen werden kann.
     */
    FeLogin.prototype.validate = function () {
        var url = (this.settings.requestUrl || '').trim();

        if (url === '') {
            console.warn(
                LOG_PREFIX + ' requestUrl ist leer. Entweder fehlt PAGE_URL_WITH_FELOGIN ' +
                'in der Konfiguration, oder sie wurde nicht als Option uebergeben.'
            );
            return false;
        }

        if (!document.querySelector(this.settings.destinationContainer)) {
            console.warn(
                LOG_PREFIX + ' Zielcontainer "' + this.settings.destinationContainer +
                '" existiert auf dieser Seite nicht.'
            );
            return false;
        }

        return true;
    };

    /**
     * Holt die Seite, schneidet das Formular heraus und haengt es ein.
     */
    FeLogin.prototype.build = function () {
        var self = this;

        return fetch(this.settings.requestUrl, {
            // Cookies mitschicken, damit das RequestToken zur Session passt
            credentials: 'same-origin',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
            .then(function (response) {
                if (!response.ok) {
                    throw new Error('HTTP ' + response.status + ' ' + response.statusText);
                }
                return response.text();
            })
            .then(function (html) {
                var doc = new DOMParser().parseFromString(html, 'text/html');
                var source = doc.querySelector(self.settings.loginHtmlContainer);

                if (!source) {
                    console.warn(
                        LOG_PREFIX + ' Selektor "' + self.settings.loginHtmlContainer +
                        '" wurde in der geladenen Seite nicht gefunden.'
                    );
                    return false;
                }

                var target = document.querySelector(self.settings.destinationContainer);

                // Knoten gehoert einem fremden Document - importieren statt
                // direkt anhaengen.
                var imported = document.importNode(source, true);

                if (self.settings.replace) {
                    target.replaceChildren(imported);
                } else {
                    target.appendChild(imported);
                }

                target.dispatchEvent(new CustomEvent('felogin:loaded', {
                    bubbles: true,
                    detail: { element: imported }
                }));

                return true;
            })
            .catch(function (err) {
                console.warn(LOG_PREFIX + ' Formular konnte nicht geladen werden:', err);
                return false;
            });
    };

    window.FeLogin = FeLogin;
}());
