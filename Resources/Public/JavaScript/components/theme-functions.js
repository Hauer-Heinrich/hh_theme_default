// Default theme functions plugin
// You can register your own functions here and call them from anywhere
// in your scripts via themeFunctions.callFunction("functionName", arg1, arg2, ...);

// Example register your own function
// No matter when the plugin was loaded – it always works!
// themeFunctions.subscribe("ready", (plugin) => {
//     console.log("ThemeFunctions is ready!", plugin);
//
//     plugin.registerFunction("sayHello", () => {
//         alert("Hello from the plugin!");
//     });
//
//     // Call directly
//     plugin.callFunction("sayHello");
//
//     // Oder Kernfunktion testen
//     // plugin.openLink("https://example.com", "_blank");
// });

(function (window) {
    const subscribers = {};
    const stickyEvents = {};

    const themeFunctions = {
        hasStarted: false,
        functions: {},

        // === PUB/SUB ===

        /**
         * Subscribe to an event. If it has already been published as a sticky event,
         * the callback is invoked immediately.
         */
        subscribe(event, callback) {
            if (!subscribers[event]) {
                subscribers[event] = [];
            }
            subscribers[event].push(callback);

            // Call up sticky event immediately, if available
            if (stickyEvents[event]) {
                callback(stickyEvents[event]);
            }
        },

        /**
         * Publishes an event. Optionally as "sticky," so that future subscribers receive it immediately.
         */
        publish(event, data, sticky = false) {
            if (sticky) {
                stickyEvents[event] = data;
            }
            if (subscribers[event]) {
                subscribers[event].forEach(callback => callback(data));
            }
        },

        // === FUNCTION REGISTRATION ===

        /**
         * Registers a user-defined function.
         */
        registerFunction(name, fn) {
            if (typeof fn === 'function') {
                this.functions[name] = fn;
            } else {
                console.warn(`Function ${name} is not a valid function.`);
            }
        },

        /**
         * Executes a registered function.
         */
        callFunction(name, ...args) {
            if (typeof this.functions[name] === 'function') {
                return this.functions[name](...args);
            } else if (typeof this[name] === 'function') {
                return this[name](...args);
            } else {
                console.warn(`Function "${name}" not found.`);
            }
        },

        // === CORE FUNCTIONS ===

        /**
         * Opens a link—either in the same tab or in a new tab.
         */
        openLink(link, target) {
            if (target === "_blank") {
                window.open(link, '_blank');
            } else {
                window.location.href = link;
            }
        },

        /**
         * Makes an entire element clickable if it contains a link.
         */
        elementClickLink(element, target) {
            if (!element) return;
            const link = element.querySelector('a');
            if (link) {
                const href = link.getAttribute('href');
                if (href) {
                    element.classList.add('cursor-pointer');
                    element.addEventListener('click', () => {
                        this.openLink(href, target);
                    });
                }
            }
        }
    };

    // Global registration
    window.themeFunctions = themeFunctions;

    // Mark plugin as started
    themeFunctions.hasStarted = true;

    // Publish "ready" event (Sticky!)
    themeFunctions.publish("ready", themeFunctions, true);

})(window);
