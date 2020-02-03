# hh_theme_default (Warning: Is under heavy development!)
## do not use it now - only test and give feedback :)
hh_theme_default is a TYPO3 extension / distribution.
This theme is to try out or use as a kick-start for your own theme/project - it can also be extended or overwritten (TODO: add a link for an example extension)

### Extensions
hh_theme_default is currently extended with the following extensions. Instructions on how to use them in your own application are linked below.
| Extension | README |
| ------ | ------ |
| hh_slider | [https://github.com/Hauer-Heinrich/hh_slider/blob/master/README.md] |
| hh_seo | [https://github.com/Hauer-Heinrich/hh_seo/blob/master/README.md] |

### Files
site_config
This theme shippes a dummy site_config - if you want to use/copy the file(s) don't forget to adjust the ID, paths and other information in it

### Installation
... like any other TYPO3 extension [extensions.typo3.org](https://extensions.typo3.org/ "TYPO3 Extension Repository")
Don't forget to include the PageTS -> backend->rootPage->site configuration->resources!

### Features
 - delivers default responsive css and FLUID files for the default FLUID content-elements (for example uses html picture tag for images)
 - delivers example configurations and files like AdditionalConfiguration.php or site_config.yaml you can find these files at /Configuration/Typo3/

# IMPORTENT NOTICE
 - copies shipped AdditionalConfiguration.php on install if no one exists! This AdditonalConfiguration includes /Configuration/Typo3/AdditionalConfiguration.php.

### Todos

### Deprecated

### Development

Want to contribute? Great!

hh_theme_default uses Gulp for fast developing.
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
