# hh_theme_default (Alpha)
hh_theme_default is a TYPO3 extension / theme (starter kit). Customize the theme as needed.

### Extensions
hh_theme_default is currently extended with the following extensions. Instructions on how to use them in your own application are linked below.

Extension | README
------------ | -------------
hh_slider | [https://github.com/Hauer-Heinrich/hh_slider/blob/master/README.md]
hh_seo | [https://github.com/Hauer-Heinrich/hh_seo/blob/master/README.md]

### Install Build Tools
1. Install NodeJS / NPM if not installed: https://docs.npmjs.com/downloading-and-installing-node-js-and-npm
2. `npm install`
3. Copy .env.example to .env: `cp .env.example .env`
4. Adjust .env file to your needs
5. `npm run init`

### Usage of Build Tools
- `npm run init` (only needed on first installation, see section "Install Build Tools")
- `npm run build` (build css, js & more once)
- `npm run watch` (build css, js & more everytime a file changes)
- `npm run options` (show current build configuration/options)

More informations/docs about the build tools: https://github.com/iocron/esbuild-template-starter

### Update Build Tools (optional)
1. `curl --remote-name-all https://raw.githubusercontent.com/iocron/esbuild-template-starter/main/{bundle.mjs,bundle.config.json.example,package.json,package-lock.json,.env.example}`
2. Compare and update your bundle.config.json according to the bundle.config.json.example if the config changes greatly (same goes for the .env file according to .env.example)

-------

### Plugins
hh_theme_default is currently extended with the following plugins. Instructions on how to use them in your own application are linked below.

Plugin | README
------------ | -------------
io.js (Slim Plugin Framework with Pub/Sub Event System) | [https://bitbucket.org/iocron/io/src/master/README.md]

### Site Config
site_config
This theme shippes a dummy site_config - if you want to use/copy the file(s) don't forget to adjust the ID, paths and other information in it

### Theme Placeholder
Extension Name | Value
------------ | -------------
{{EXTENSION_KEY}} | hh_theme_default
{{EXTENSION_NAME}} | hhthemedefault
{{EXTENSION_NAMESPACE}} | HhThemeDefault
{{EXTENSION_NAMESPACE_ES6}} | hh-theme-default
{{EXTENSION_DOMAIN_NAME}} | example
{{EXTENSION_DOMAIN_TLD}} | com

### Installation
... like any other TYPO3 extension [extensions.typo3.org](https://extensions.typo3.org/ "TYPO3 Extension Repository")
Don't forget to include the PageTS -> backend->rootPage->site configuration->resources!

### Features
 - delivers default responsive css and FLUID files for the default FLUID content-elements (for example uses html picture tag for images)
 - comes with various viewhelpers
 - delivers example configurations and files like AdditionalConfiguration.php or site_config.yaml you can find these files at /Configuration/Typo3/
 - added a branding at the TYPO3 backend at the very top (customize this at Resources/Public/JavaScript/Backend/Bemain.js)
 - adds "Number of columns" field to tt_address plugin

## IMPORTENT NOTICE
 - copies shipped AdditionalConfiguration.php on install if no one exists! This AdditonalConfiguration includes /Configuration/Typo3/AdditionalConfiguration.php.
 - check if your server supports generation of webp format, else comment out or delete the corresponding positions at /Resources/Private/Extensions/fluid_styled_content/Partials/Media/Rendering/Image.html

## Included JS Framework "IO Plugin Framework"

The main purpose of the IO Plugin Framework (https://bitbucket.org/iocron/io/src/master/) is to write your own JS Plugins as simply as possible with a slim framework and less overhead. The IO Plugin Framework has the ability to use the [MediaQueryList](https://developer.mozilla.org/en-US/docs/Web/API/MediaQueryList) in a simplistic way and has the option to use a Pub/Sub Event System (https://en.wikipedia.org/wiki/Publish%E2%80%93subscribe_pattern). The plugins are written in a object oriented way, so its extensibility isn't limited.

The IO Plugin Framework is already shipped with a io.nav.js and io.accordion.js plugin (based on the io plugin framework). If you want a custom plugin of your own, then follow the full documentation instead and have a look at the io.skeleton.js: https://bitbucket.org/iocron/io/src/master/src/js/plugins/io.skeleton.js

Instead of using a custom plugin, you can also use the framework globally. The object/class "io" is available to you from a global scope (e.g. `io.addClass("#wrapper", "my-css-class")`). In this case follow the documentation below.

#### Pub / Sub (any pub/sub event can be accessed, even from other io plugins / classes)

```
io.sub("/globalEvent/", (arg1, arg2) => { console.log("globalEvent"); });
io.pub("/globalEvent/"); // Or this.io.pub("/globalEvent/", overrideArgument...);
```

#### MQL MANAGER

// Setup a Mql Manager Subscription (sets a new mql query subscription)
// It behaves like https://developer.mozilla.org/en-US/docs/Web/API/MediaQueryList but in a much simpler way
// (Use the defaults/options config to set the mqlQuery for the mqlManager (see the defaults setting)) or use a custom one
// (You can choose any subscription path name you like (e.g. /mqlManager/, /something/) or a existing subscription)

```
let mqlQuery = { minWidth:"0px", maxWidth:"1024px" };
io.mqlManager("/mqlManager/", mqlQuery, (mql) => {
    if(mql.matches){
        console.log("IS MATCHING");
    } else {
        console.log("IS NOT MATCHING");
    }
});
```

#### Add a Subscription to a existing Mql Manager Subscription

```
io.sub("/mqlManager/", () => console.log("Will be triggered by the mql sub /mqlManager/ as well"));
io.sub("/mqlManager/somethingElse/", () => console.log("Will be triggered by the mql sub /mqlManager/ as well"));
```

#### Remove a Mql Manager Subscription


```
io.mqlManagerRemove("/mqlManager/");
```

#### Utilities

```
// Element On / Off Events
io.on(".selector", "click", () => console.log("test"));
io.off(".selector", "click");
```

#### Element Class Methods

```
io.addClass(element, "myclass");
io.addClass(element, "myclass", false); // Disable prefixing of the class name (same for all other class methods)
io.removeClass(element, "myclass");
io.toggleClass(element, "myclass");
io.hasClass(element, "myclass");
```

#### Element Methods - Append / Prepend

```
// (first argument can be a String HTML Tag, Node Element or Dom Element)
io.prependTo("div", this.body, { width:"100px" });
io.appendTo("div", this.body, { width:"100px" });
```

#### Element Methods - Element Selector, Elements ForEach, Elements Cloning

```
// (elementsSource and elementsTarget can be a String CSS Selector, Node Element or Dom Element)
io.elements(elementsSource); // OR this.elements(Node / Dom Element);
io.elementsEach(elementsSource, (el) => { console.log(el); }); // OR Node / Dom Element
io.elementsClone(elementsSource, elementsTarget); // Clone elementsSource into elementsTarget
io.elementsClone(elementsSource, elementsTarget, false); // Same as above, but without renaming the id's and classes
```

#### General Helpers

```
io.windowWidth();  // Get Window Width
io.windowHeight(); // Get Window Height
```

#### Logging

```
// (will be only triggered if this.config.debug is set to true)
io.log("title", obj);
io.logAll(); // Logs config, events, ui elements
```

### Todos

### Deprecated

### Development

Want to contribute? Great!

##### Copyright notice

This repository is part of the TYPO3 project. The TYPO3 project is
free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

The GNU General Public License can be found at
http://www.gnu.org/copyleft/gpl.html.

This repository is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

This copyright notice MUST APPEAR in all copies of the repository!

##### License
----
GNU GENERAL PUBLIC LICENSE Version 3
