# HH Theme Default (Alpha)
The hh_theme_default is a TYPO3 extension/theme (starter kit) that includes a JS and CSS Bundler along with numerous helpful utilities, designed to facilitate a quick and seamless setup for your typo3 project.

### System Requirements
- PHP8.x
- Node v16+ (https://docs.npmjs.com/downloading-and-installing-node-js-and-npm)
- TYPO3 v12+ (https://docs.typo3.org/m/typo3/tutorial-getting-started/main/en-us/Installation/Install.html)

### Setup
1. Go to your typo3 ext folder, e.g.: `cd typo3conf/ext/`
2. Clone repository (replace "MY_EXTENSION_NAME"): `git clone git@github.com:Hauer-Heinrich/hh_theme_default.git MY_EXTENSION_NAME`
3. `cd MY_EXTENSION_NAME`
4. `npm install`
5. `npm run init`
6. Include the theme to your TYPO3 PageTS Configuration (PageTS->backend->rootPage->site configuration->resources)

### Usage of Build Tools
- `npm run init` (only needed on first setup)
- `npm run build` (build css, css nesting, js, sourcemaps & other files)
- `npm run watch` (build css, css nesting, js, sourcemaps & other files everytime a file changes)
- `npm run options` (show current build configuration/options)
- `npm run upgrade` (upgrade to latest build tools from the official [esbuild-template-starter](https://github.com/iocron/esbuild-template-starter) iocron repository without package.json/package-lock.json)

More informations/docs about the esbuild usage: https://github.com/iocron/esbuild-template-starter

## Folder/Logic structure
|   Info                |   Path                    |   Description
|-----------------------|---------------------------|------------------------------------------------------|
|   Classes             |   [Classes](./Classes/)   |   PHP Classes, ViewHelpers, ..
|   Configuration       |   [Configuration](./Configuration/)   |   TsConfig, TypoScript, TCA, ..
|   Examples            |   [Examples](./Examples/)   |   Examples of webserver config, site config, typo3 config, ..
|   Fluid Files         |   [Resources/Private](./Resources/Private/)   |
|   Main CSS            |   [Resources/Public/Css/main.css](./Resources/Public/Css/main.css)   |
|   Main JS             |   [Resources/Public/JavaScript/main.js](./Resources/Public/JavaScript/main.js)   |
|   Theme Images        |   [Resources/Public/Images](./Resources/Public/Images/)   |
|   Sites Configuration |   [sites](./sites/)   |

## Features
 - Delivers default responsive css and FLUID files for the default FLUID content-elements (for example uses html picture tag for images)
 - Comes with various viewhelpers
 - Delivers example configurations and files like AdditionalConfiguration.php or site_config.yaml you can find these files at /Configuration/Typo3/
 - Added a branding at the TYPO3 backend at the very top (customize this at Resources/Public/JavaScript/Backend/Bemain.js)
 - Adds "Number of columns" field to tt_address plugin
 - The theme includes the following TYPO3 Extensions:
    - [TYPO3 Extension hh_slider](https://github.com/Hauer-Heinrich/hh_slider/blob/master/README.md)
    - [TYPO3 Extension hh_seo](https://github.com/Hauer-Heinrich/hh_seo/blob/master/README.md)
 - Custom JavaScript Framework ["IO Plugin Framework"](./README-io.plugin.md) included
 - You can use CSS Nesting out-of-the-box (https://www.w3.org/TR/css-nesting-1/)
 - Use the latest JavaScript ES6 Features & More
 - Automatically generated SoureMaps for JS and CSS
 - And many more..

## Important Notice
 - A copy of AdditionalConfiguration.php is shipped on install if no one exists! This AdditonalConfiguration includes /Configuration/Typo3/AdditionalConfiguration.php
 - Check if your server supports the generation of webp format, else comment out or delete the corresponding positions at /Resources/Private/Extensions/fluid_styled_content/Partials/Media/Rendering/Image.html
