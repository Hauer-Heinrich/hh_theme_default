# hh_theme_default (Warning: Is under heavy development!)
## do not use it now - only test and give feedback :grinning:
hh_theme_default is a TYPO3 extension / distribution.
This theme is to try out or use as a kick-start for your own theme/project - it can also be extended or overwritten (TODO: add a link for an example extension)

### Extensions
hh_theme_default is currently extended with the following extensions. Instructions on how to use them in your own application are linked below.

Extension | README
------------ | -------------
hh_slider | [https://github.com/Hauer-Heinrich/hh_slider/blob/master/README.md]
hh_seo | [https://github.com/Hauer-Heinrich/hh_seo/blob/master/README.md]

### Requirements (for Development)
1. Install NodeJS / NPM: https://docs.npmjs.com/downloading-and-installing-node-js-and-npm
2. Make sure NodeJS / NPM is up-to-date: `npm install -g npm`
3. Install gulp and gulp-cli: `npm install -g gulp-cli`

### Installation (for Development)
1. `git clone https://github.com/Hauer-Heinrich/hh_theme_default.git`
2. `cd hh_theme_default`
3. `npm install`
4. `gulp`         # This will list all available gulp commands for your theme build

### Plugins
hh_theme_default is currently extended with the following plugins. Instructions on how to use them in your own application are linked below.

Plugin | README
------------ | -------------
io.js (Slim Plugin Framework with Pub/Sub Event System) | [https://bitbucket.org/iocron/io/src/master/README.md]
baguetteBox.js (lightbox) | [https://github.com/feimosi/baguetteBox.js/blob/dev/README.md]

### Files
site_config
This theme shippes a dummy site_config - if you want to use/copy the file(s) don't forget to adjust the ID, paths and other information in it

### Installation
... like any other TYPO3 extension [extensions.typo3.org](https://extensions.typo3.org/ "TYPO3 Extension Repository")
Don't forget to include the PageTS -> backend->rootPage->site configuration->resources!

### Features
 - delivers default responsive css and FLUID files for the default FLUID content-elements (for example uses html picture tag for images)
 - comes with various viewhelpers
 - delivers example configurations and files like AdditionalConfiguration.php or site_config.yaml you can find these files at /Configuration/Typo3/
 - added a branding at the TYPO3 backend at the very top (customize this at Resources/Public/JavaScript/Backend/Bemain.js)

## IMPORTENT NOTICE
 - does not support IE 11 and below
 - copies shipped AdditionalConfiguration.php on install if no one exists! This AdditonalConfiguration includes /Configuration/Typo3/AdditionalConfiguration.php.
 - check if your server supports generation of webp format, else comment out or delete the corresponding positions at /Resources/Private/Extensions/fluid_styled_content/Partials/Media/Rendering/Image.html

## IO Plugin Framework

The main purpose of the IO Plugin Framework is to write your own Plugins as simply as possible with a slim framework and less overhead. The IO Plugin Framework has the ability to use the [MediaQueryList](https://developer.mozilla.org/en-US/docs/Web/API/MediaQueryList) in a simplistic way and has the option to use a Pub/Sub Event System (https://en.wikipedia.org/wiki/Publish%E2%80%93subscribe_pattern). The plugins are written in a object oriented way, so its extensibility isn't limited.

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

hh_theme_default uses [GULP](https://github.com/iocron/typo3-gulp-scss/ "gulp") for fast developing.
Make a change in your file and instantaneously see your updates!

Open your favorite Terminal and run these commands in the theme folder.

First Tab:
```sh
$ npm install
```

Second Tab:
```sh
$ gulp watch
```

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
