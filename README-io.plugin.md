# IO Plugin Framework

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
