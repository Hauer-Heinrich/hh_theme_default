/*
 *   This content is licensed according to the W3C Software License at
 *   https://www.w3.org/Consortium/Legal/2015/copyright-software-and-document
 *
 *   Supplemental JS for the disclosure menu keyboard behavior
 *
 *   ERWEITERT um Hover-Unterstützung:
 *   - Untermenüs öffnen sich zusätzlich per Maus-Hover (pointerenter/pointerleave)
 *   - Nur für echte Maus-Zeiger aktiv (pointerType === 'mouse'), damit
 *     Touch-Geräte weiterhin sauber über Klick/Tap funktionieren
 *   - Kleine Schließ-Verzögerung (hoverCloseDelay), damit das Menü nicht
 *     sofort zuklappt, wenn man den Mauszeiger kurz verlässt
 *   - Hover schließt nicht, solange der Tastaturfokus im Untermenü liegt
 *   - Per updateHoverControls(true/false) von außen an-/abschaltbar
 *     (z. B. im mobilen Dialog deaktivieren)
 */

'use strict';

class DisclosureNav {
    constructor(domNode, options) {
        options = options || {};

        this.rootNode = domNode;
        this.controlledNodes = [];
        this.openIndex = null;
        this.useArrowKeys = true;

        /* --- NEU: Hover-Einstellungen --- */
        this.useHover =
            options.useHover !== undefined ? options.useHover : true;
        this.hoverCloseDelay =
            options.hoverCloseDelay !== undefined ? options.hoverCloseDelay : 300;
        this.hoverTimer = null;
        /* -------------------------------- */

        this.topLevelNodes = [
            ...this.rootNode.querySelectorAll(
                'a, button[aria-expanded][aria-controls]'
            ),
        ];

        this.topLevelNodes.forEach((node, index) => {
            // handle button + menu
            if (
                node.tagName.toLowerCase() === 'button' &&
                node.hasAttribute('aria-controls')
            ) {
                const menu = node.parentNode.querySelector('ul');
                if (menu) {
                    // save ref controlled menu
                    this.controlledNodes.push(menu);

                    // collapse menus
                    node.setAttribute('aria-expanded', 'false');
                    this.toggleMenu(menu, false);

                    // attach event listeners
                    menu.addEventListener('keydown', this.onMenuKeyDown.bind(this));
                    node.addEventListener('click', this.onButtonClick.bind(this));
                    node.addEventListener('keydown', this.onButtonKeyDown.bind(this));

                    /* --- NEU: Hover auf dem übergeordneten <li> ---
                     * Das <li> umfasst Link + Button + Untermenü, dadurch
                     * bleibt das Menü offen, solange sich der Zeiger
                     * irgendwo innerhalb des Menüpunkts befindet. */
                    const listItem = node.closest('li');
                    if (listItem) {
                        listItem.addEventListener(
                            'pointerenter',
                            this.onItemPointerEnter.bind(this, index)
                        );
                        listItem.addEventListener(
                            'pointerleave',
                            this.onItemPointerLeave.bind(this, index)
                        );
                    }
                    /* ----------------------------------------------- */
                }
            }
            // handle links
            else {
                this.controlledNodes.push(null);
                node.addEventListener('keydown', this.onLinkKeyDown.bind(this));
            }
        });

        this.rootNode.addEventListener('focusout', this.onBlur.bind(this));
    }

    controlFocusByKey(keyboardEvent, nodeList, currentIndex) {
        switch (keyboardEvent.key) {
            case 'ArrowUp':
            case 'ArrowLeft':
                keyboardEvent.preventDefault();
                if (currentIndex > -1) {
                var prevIndex = Math.max(0, currentIndex - 1);
                nodeList[prevIndex].focus();
                }
                break;
            case 'ArrowDown':
            case 'ArrowRight':
                keyboardEvent.preventDefault();
                if (currentIndex > -1) {
                var nextIndex = Math.min(nodeList.length - 1, currentIndex + 1);
                nodeList[nextIndex].focus();
                }
                break;
            case 'Home':
                keyboardEvent.preventDefault();
                nodeList[0].focus();
                break;
            case 'End':
                keyboardEvent.preventDefault();
                nodeList[nodeList.length - 1].focus();
                break;
        }
    }

    // public function to close open menu
    close() {
        this.toggleExpand(this.openIndex, false);
    }

    onBlur(event) {
        var menuContainsFocus = this.rootNode.contains(event.relatedTarget);
        if (!menuContainsFocus && this.openIndex !== null) {
            this.toggleExpand(this.openIndex, false);
        }
    }

    onButtonClick(event) {
        var button = event.currentTarget;
        var buttonIndex = this.topLevelNodes.indexOf(button);
        var buttonExpanded = button.getAttribute('aria-expanded') === 'true';
        this.toggleExpand(buttonIndex, !buttonExpanded);
    }

    onButtonKeyDown(event) {
        var targetButtonIndex = this.topLevelNodes.indexOf(document.activeElement);

        // close on escape
        if (event.key === 'Escape') {
            this.toggleExpand(this.openIndex, false);
        }

        // move focus into the open menu if the current menu is open
        else if (
            this.useArrowKeys &&
            this.openIndex === targetButtonIndex &&
            event.key === 'ArrowDown'
        ) {
            event.preventDefault();
            this.controlledNodes[this.openIndex].querySelector('a').focus();
        }

        // handle arrow key navigation between top-level buttons, if set
        else if (this.useArrowKeys) {
            this.controlFocusByKey(event, this.topLevelNodes, targetButtonIndex);
        }
    }

    /* --- NEU: Hover-Handler --------------------------------------- */

    onItemPointerEnter(index, event) {
        // Nur echte Maus – Touch/Pen erzeugen sonst doppelte Öffnen-Logik
        if (!this.useHover || event.pointerType !== 'mouse') {
            return;
        }

        window.clearTimeout(this.hoverTimer);

        if (this.openIndex !== index) {
            this.toggleExpand(index, true);
        }
    }

    onItemPointerLeave(index, event) {
        if (!this.useHover || event.pointerType !== 'mouse') {
            return;
        }

        window.clearTimeout(this.hoverTimer);

        this.hoverTimer = window.setTimeout(() => {
            // Nicht schließen, wenn die Tastatur gerade im Untermenü arbeitet
            var submenu = this.controlledNodes[index];
            if (submenu && submenu.contains(document.activeElement)) {
                return;
            }
            if (this.topLevelNodes[index] === document.activeElement) {
                return;
            }
            if (this.openIndex === index) {
                this.toggleExpand(index, false);
            }
        }, this.hoverCloseDelay);
    }

    /* --------------------------------------------------------------- */

    onLinkKeyDown(event) {
        var targetLinkIndex = this.topLevelNodes.indexOf(document.activeElement);

        // handle arrow key navigation between top-level buttons, if set
        if (this.useArrowKeys) {
            this.controlFocusByKey(event, this.topLevelNodes, targetLinkIndex);
        }
    }

    onMenuKeyDown(event) {
        if (this.openIndex === null) {
            return;
        }

        var menuLinks = Array.prototype.slice.call(
            this.controlledNodes[this.openIndex].querySelectorAll('a')
        );
        var currentIndex = menuLinks.indexOf(document.activeElement);

        // close on escape
        if (event.key === 'Escape') {
            this.topLevelNodes[this.openIndex].focus();
            this.toggleExpand(this.openIndex, false);
        }

        // handle arrow key navigation within menu links, if set
        else if (this.useArrowKeys) {
            this.controlFocusByKey(event, menuLinks, currentIndex);
        }
    }

    toggleExpand(index, expanded) {
        // close open menu, if applicable
        if (this.openIndex !== index) {
            this.toggleExpand(this.openIndex, false);
        }

        // handle menu at called index
        if (this.topLevelNodes[index]) {
            this.openIndex = expanded ? index : null;
            this.topLevelNodes[index].setAttribute('aria-expanded', expanded);
            this.toggleMenu(this.controlledNodes[index], expanded);
        }
    }

    toggleMenu(domNode, show) {
        if (domNode) {
            domNode.style.display = show ? 'block' : 'none';
        }
    }

    updateKeyControls(useArrowKeys) {
        this.useArrowKeys = useArrowKeys;
    }

    /* --- NEU: Hover von außen an-/abschalten (z. B. im Mobile-Dialog) --- */
    updateHoverControls(useHover) {
        this.useHover = useHover;
        if (!useHover) {
            window.clearTimeout(this.hoverTimer);
        }
    }
}

/* Initialize Disclosure Menus */
window.addEventListener('load', function() {
    var menus = document.querySelectorAll('.menu-main');
    var disclosureMenus = [];

    for (var i = 0; i < menus.length; i++) {
        disclosureMenus[i] = new DisclosureNav(menus[i], {
            useHover: true,      // Hover global an/aus
            hoverCloseDelay: 300 // ms Verzögerung beim Schließen
        });
    }

    /* NEU: Instanzen global verfügbar machen, damit z. B. mobile-menu.js
     * per onEnterMobile/onLeaveMobile den Hover deaktivieren kann. */
    window.disclosureNavs = disclosureMenus;

    // listen to arrow key checkbox
    var arrowKeySwitch = document.getElementById('arrow-behavior-switch');
    if (arrowKeySwitch) {
        arrowKeySwitch.addEventListener('change', function () {
            var checked = arrowKeySwitch.checked;
            for (var i = 0; i < disclosureMenus.length; i++) {
                disclosureMenus[i].updateKeyControls(checked);
            }
        });
    }
},false);














/*
 * MobileMenu – unabhängiges Modul für ein mobiles Off-Canvas-Menü
 *
 * Was es macht:
 *  1. Erzeugt einen Toggle-Button (Burger) und ein natives <dialog>-Element
 *     als Container ("Wrapper") für beliebige Inhalte.
 *  2. Verschiebt (sources) oder kopiert (clones) per JavaScript
 *     konfigurierbare Elemente ab einer bestimmten Bildschirmbreite
 *     (breakpoint) in den Dialog – und stellt bei größeren Viewports den
 *     Ausgangszustand exakt wieder her.
 *  3. Die Reihenfolge im Dialog lässt sich über die Option "order" für
 *     ALLE Elemente (verschobene UND kopierte) gemeinsam festlegen.
 *  4. Nutzt showModal(): Fokus-Falle, Escape-Schließen und ::backdrop
 *     liefert der Browser barrierefrei gleich mit.
 *
 * sources vs. clones:
 *  - sources: Elemente werden VERSCHOBEN. Event-Listener (z. B. der
 *    DisclosureNav) und IDs bleiben erhalten, es entstehen keine
 *    Duplikate. Richtig für interaktive Komponenten wie das Menü.
 *  - clones: Elemente werden EINMALIG KOPIERT (cloneNode), das Original
 *    bleibt an Ort und Stelle. Achtung: cloneNode kopiert KEINE
 *    Event-Listener – daher nur für statische Elemente wie Logo,
 *    Telefonnummer, Social-Icons usw. verwenden. IDs innerhalb der Kopie
 *    werden automatisch mit einem Suffix versehen (inkl. zugehöriger
 *    for-/aria-Referenzen und #-Anker), damit keine doppelten IDs im
 *    Dokument entstehen.
 *
 * Verwendung:
 *   var mobileMenu = new MobileMenu({
 *       sources: ['.menu-main', '.meta-nav'], // wird verschoben
 *       clones: ['.logo'],                    // wird einmalig kopiert
 *       order: ['.logo', '.menu-main', '.meta-nav'], // Reihenfolge im Dialog
 *       breakpoint: 1024,                     // Zahl (px) oder Media-Query-String
 *       buttonTarget: '.site-header',         // wohin der Button eingefügt wird
 *       buttonPosition: 'append',             // 'prepend' | 'append' | 'before' | 'after'
 *       onEnterMobile: function () { ... },   // optional
 *       onLeaveMobile: function () { ... }    // optional
 *   });
 */

'use strict';

class MobileMenu {
    constructor(userOptions) {
        const defaults = {
            /* Elemente, die in den Dialog VERSCHOBEN werden:
             * CSS-Selektoren (String) und/oder direkte Element-Referenzen */
            sources: [],

            /* Elemente, die einmalig in den Dialog KOPIERT werden
             * (Original bleibt sichtbar an seiner Position) */
            clones: [],

            /* Reihenfolge im Dialog über sources UND clones hinweg:
             * Array aus Selektoren und/oder Element-Referenzen.
             * Nicht gelistete Elemente kommen ans Ende, in der
             * Reihenfolge ihrer Definition (erst sources, dann clones). */
            order: [],

            /* Zahl = "mobil unterhalb von X px" (z. B. 1024)
             * oder eigener Media-Query-String, z. B. '(max-width: 900px)' */
            breakpoint: 1024,

            /* Wo der Toggle-Button eingefügt wird */
            buttonTarget: 'body',
            buttonPosition: 'prepend', // 'prepend' | 'append' | 'before' | 'after'
            buttonText: 'Menü',
            buttonLabel: 'Menü öffnen',
            buttonClass: 'mobile-menu-toggle',

            /* Dialog */
            dialogId: 'mobile-dialog',
            dialogClass: 'mobile-dialog',
            dialogLabel: 'Menü',
            closeLabel: 'Menü schließen',

            /* Suffix, das IDs innerhalb von Kopien erhalten,
             * um doppelte IDs im Dokument zu vermeiden */
            cloneIdSuffix: '-mobile-copy',

            /* Hooks, z. B. um im mobilen Modus den Hover des
             * DisclosureNav zu deaktivieren */
            onEnterMobile: null,
            onLeaveMobile: null,
        };

        this.options = Object.assign({}, defaults, userOptions || {});

        this.isMobile = false;
        this.placeholders = new Map();

        /* Kombinierte, bereits sortierte Liste aller Elemente */
        this.items = this.buildItems();

        this.buildDialog();
        this.buildButton();

        /* Breakpoint überwachen */
        this.mediaQuery = window.matchMedia(
            this.buildQuery(this.options.breakpoint)
        );
        this.handleMediaChange = this.handleMediaChange.bind(this);

        if (typeof this.mediaQuery.addEventListener === 'function') {
            this.mediaQuery.addEventListener('change', this.handleMediaChange);
        } else {
            // Fallback für ältere Browser (Safari < 14)
            this.mediaQuery.addListener(this.handleMediaChange);
        }

        /* Initialen Zustand anwenden */
        this.handleMediaChange(this.mediaQuery);
    }

    /* ------------------------------------------------------------------ */
    /* Setup                                                               */
    /* ------------------------------------------------------------------ */

    resolveElements(list) {
        const elements = [];
        (list || []).forEach((entry) => {
            if (typeof entry === 'string') {
                document.querySelectorAll(entry).forEach((el) => {
                    elements.push(el);
                });
            } else if (entry instanceof Element) {
                elements.push(entry);
            }
        });
        return elements;
    }

    buildItems() {
        const items = [];

        this.resolveElements(this.options.sources).forEach((el) => {
            items.push({ el: el, mode: 'move', clone: null });
        });
        this.resolveElements(this.options.clones).forEach((el) => {
            items.push({ el: el, mode: 'clone', clone: null });
        });

        /* Position eines Elements in der order-Liste ermitteln.
         * Nicht gelistete Elemente bekommen order.length und landen
         * damit hinter allen gelisteten. */
        const order = this.options.order || [];
        const orderIndex = (item) => {
            for (var i = 0; i < order.length; i++) {
                var ref = order[i];
                if (typeof ref === 'string') {
                    if (item.el.matches(ref)) {
                        return i;
                    }
                } else if (ref === item.el) {
                    return i;
                }
            }
            return order.length;
        };

        /* Stabil sortieren: bei gleichem order-Index bleibt die
         * Definitionsreihenfolge erhalten */
        return items
            .map((item, index) => ({ item: item, index: index, key: orderIndex(item) }))
            .sort((a, b) => a.key - b.key || a.index - b.index)
            .map((wrapper) => wrapper.item);
    }

    buildQuery(breakpoint) {
        if (typeof breakpoint === 'number') {
            /* -0.02px vermeidet Überschneidung mit min-width-Queries
             * derselben Pixelzahl (Bootstrap-Konvention) */
            return '(max-width: ' + (breakpoint - 0.02) + 'px)';
        }
        return breakpoint;
    }

    buildDialog() {
        const opts = this.options;

        this.dialog = document.createElement('dialog');
        this.dialog.id = opts.dialogId;
        this.dialog.className = opts.dialogClass;
        this.dialog.setAttribute('aria-label', opts.dialogLabel);

        /* Innerer Wrapper: fängt Klicks ab, damit nur echte
         * Backdrop-Klicks den Dialog schließen (siehe CSS: min-height 100%) */
        this.inner = document.createElement('div');
        this.inner.className = opts.dialogClass + '--inner';

        /* Schließen-Button */
        this.closeButton = document.createElement('button');
        this.closeButton.type = 'button';
        this.closeButton.className = opts.dialogClass + '--close';
        this.closeButton.setAttribute('aria-label', opts.closeLabel);
        this.closeButton.innerHTML = '<span aria-hidden="true">&times;</span>';
        this.closeButton.addEventListener('click', () => this.close());

        /* Content-Container: hierhin werden die Elemente
         * verschoben bzw. kopiert */
        this.content = document.createElement('div');
        this.content.className = opts.dialogClass + '--content';

        this.inner.appendChild(this.closeButton);
        this.inner.appendChild(this.content);
        this.dialog.appendChild(this.inner);
        document.body.appendChild(this.dialog);

        /* Backdrop-Klick schließt (Klick landet nur dann direkt auf dem
         * <dialog>, wenn er außerhalb des inneren Wrappers erfolgt) */
        this.dialog.addEventListener('click', (event) => {
            if (event.target === this.dialog) {
                this.close();
            }
        });

        /* 'close' feuert bei Escape, close() und Backdrop-Klick –
         * hier zentral aufräumen */
        this.dialog.addEventListener('close', () => {
            this.button.setAttribute('aria-expanded', 'false');
            document.documentElement.classList.remove('has-open-mobile-dialog');
            this.button.focus();
        });
    }

    buildButton() {
        const opts = this.options;

        this.button = document.createElement('button');
        this.button.type = 'button';
        this.button.className = opts.buttonClass;
        this.button.setAttribute('aria-expanded', 'false');
        this.button.setAttribute('aria-controls', opts.dialogId);
        this.button.setAttribute('aria-haspopup', 'dialog');
        this.button.setAttribute('aria-label', opts.buttonLabel);
        this.button.hidden = true; // erst im mobilen Modus sichtbar
        this.button.innerHTML =
            '<span class="' + opts.buttonClass + '--icon" aria-hidden="true">' +
            '<span></span><span></span><span></span>' +
            '</span>' +
            '<span class="' + opts.buttonClass + '--text">' +
            opts.buttonText +
            '</span>';

        this.button.addEventListener('click', () => {
            if (this.dialog.open) {
                this.close();
            } else {
                this.open();
            }
        });

        const target =
            typeof opts.buttonTarget === 'string'
                ? document.querySelector(opts.buttonTarget)
                : opts.buttonTarget;

        if (!target) {
            document.body.prepend(this.button);
            return;
        }

        switch (opts.buttonPosition) {
            case 'append':
                target.append(this.button);
                break;
            case 'before':
                target.before(this.button);
                break;
            case 'after':
                target.after(this.button);
                break;
            case 'prepend':
            default:
                target.prepend(this.button);
        }
    }

    /* ------------------------------------------------------------------ */
    /* Kopien erzeugen (einmalig) und IDs entschärfen                      */
    /* ------------------------------------------------------------------ */

    createClone(el) {
        const clone = el.cloneNode(true);
        this.sanitizeIds(clone);
        return clone;
    }

    /* Versieht alle IDs innerhalb der Kopie mit einem Suffix und zieht
     * interne Referenzen (for, aria-*, #-Anker) mit, damit keine
     * doppelten IDs im Dokument entstehen. */
    sanitizeIds(root) {
        const suffix = this.options.cloneIdSuffix;
        const idMap = {};

        const nodesWithId = [];
        if (root.id) {
            nodesWithId.push(root);
        }
        root.querySelectorAll('[id]').forEach((node) => {
            nodesWithId.push(node);
        });

        nodesWithId.forEach((node) => {
            idMap[node.id] = node.id + suffix;
            node.id = node.id + suffix;
        });

        const refAttrs = [
            'for',
            'aria-controls',
            'aria-labelledby',
            'aria-describedby',
            'aria-owns',
            'aria-activedescendant',
        ];

        refAttrs.forEach((attr) => {
            const targets = [];
            if (root.hasAttribute(attr)) {
                targets.push(root);
            }
            root.querySelectorAll('[' + attr + ']').forEach((node) => {
                targets.push(node);
            });

            targets.forEach((node) => {
                const value = node
                    .getAttribute(attr)
                    .split(/\s+/)
                    .map((token) => idMap[token] || token)
                    .join(' ');
                node.setAttribute(attr, value);
            });
        });

        /* Anker-Links auf interne IDs innerhalb der Kopie */
        root.querySelectorAll('a[href^="#"]').forEach((anchor) => {
            const targetId = anchor.getAttribute('href').slice(1);
            if (idMap[targetId]) {
                anchor.setAttribute('href', '#' + idMap[targetId]);
            }
        });
    }

    /* ------------------------------------------------------------------ */
    /* Breakpoint-Logik: Elemente verschieben/kopieren & zurückstellen     */
    /* ------------------------------------------------------------------ */

    handleMediaChange(event) {
        if (event.matches) {
            this.enterMobile();
        } else {
            this.leaveMobile();
        }
    }

    enterMobile() {
        if (this.isMobile) {
            return;
        }
        this.isMobile = true;

        /* this.items ist bereits nach "order" sortiert – einfaches
         * appendChild in dieser Reihenfolge ergibt die Ziel-Reihenfolge */
        this.items.forEach((item) => {
            if (item.mode === 'move') {
                /* Platzhalter merkt sich die exakte Ursprungsposition */
                const placeholder = document.createComment(
                    'mobile-menu-placeholder'
                );
                item.el.parentNode.insertBefore(placeholder, item.el);
                this.placeholders.set(item.el, placeholder);
                this.content.appendChild(item.el);
            } else {
                /* Kopie wird nur beim ersten Mal erzeugt ("einmalig")
                 * und danach wiederverwendet */
                if (!item.clone) {
                    item.clone = this.createClone(item.el);
                }
                this.content.appendChild(item.clone);
            }
        });

        this.button.hidden = false;

        if (typeof this.options.onEnterMobile === 'function') {
            this.options.onEnterMobile(this);
        }
    }

    leaveMobile() {
        if (!this.isMobile) {
            return;
        }
        this.isMobile = false;

        if (this.dialog.open) {
            this.dialog.close();
        }

        this.items.forEach((item) => {
            if (item.mode === 'move') {
                const placeholder = this.placeholders.get(item.el);
                if (placeholder && placeholder.parentNode) {
                    placeholder.parentNode.replaceChild(item.el, placeholder);
                }
            } else if (item.clone) {
                /* Kopie aus dem Dialog nehmen, damit der Inhalt im
                 * Desktop-DOM nicht doppelt existiert; die Referenz
                 * bleibt erhalten und wird beim nächsten Wechsel
                 * wiederverwendet */
                item.clone.remove();
            }
        });
        this.placeholders.clear();

        this.button.hidden = true;

        if (typeof this.options.onLeaveMobile === 'function') {
            this.options.onLeaveMobile(this);
        }
    }

    /* ------------------------------------------------------------------ */
    /* Öffnen / Schließen                                                  */
    /* ------------------------------------------------------------------ */

    open() {
        if (this.dialog.open) {
            return;
        }
        this.dialog.showModal();
        this.button.setAttribute('aria-expanded', 'true');
        /* Hintergrund-Scrollen sperren (siehe CSS) */
        document.documentElement.classList.add('has-open-mobile-dialog');
    }

    close() {
        if (this.dialog.open) {
            this.dialog.close();
        }
    }

    /* Alles zurückbauen, falls nötig (z. B. in SPAs) */
    destroy() {
        if (typeof this.mediaQuery.removeEventListener === 'function') {
            this.mediaQuery.removeEventListener('change', this.handleMediaChange);
        } else {
            this.mediaQuery.removeListener(this.handleMediaChange);
        }
        this.leaveMobile();
        this.button.remove();
        this.dialog.remove();
    }
}










/*
 * Initialisierung des mobilen Menüs.
 * disclosure-nav.js initialisiert sich selbst (window load) und legt
 * seine Instanzen in window.disclosureNavs ab – dieser Listener ist
 * danach registriert und läuft daher nach ihm.
 */
window.addEventListener('load', function () {
    window.mobileMenu = new MobileMenu({
        sources: ['.menu-main'],   // wird VERSCHOBEN (Listener bleiben erhalten)
        clones: ['.header-logo'],         // wird einmalig KOPIERT (Original bleibt im Header)
        order: ['.header-logo', '.menu-main'], // Reihenfolge im Dialog (über beide Gruppen hinweg)
        breakpoint: 1024,          // mobil unterhalb von 1024 px
        buttonTarget: '.header-logo',
        buttonPosition: 'after',
        buttonText: 'Menü',
        buttonLabel: 'Menü Öffnen',
        dialogLabel: 'Hauptmenü',

        /*
         * Im Dialog ist Hover unerwünscht → abschalten,
         * beim Zurückwechseln wieder aktivieren.
         */
        onEnterMobile: function () {
            (window.disclosureNavs || []).forEach(function (nav) {
                nav.updateHoverControls(false);
                nav.close();
            });
        },
        onLeaveMobile: function () {
            (window.disclosureNavs || []).forEach(function (nav) {
                nav.updateHoverControls(true);
                nav.close();
            });
        }
    });
});
