# Updating Minor and Major Version

## Minor Versions

Updating minor versions, with the correct setup, is pretty straight forward.
First, download the new minor Version (get.typo3.org/version/13), paste the file in your *typo3_sources* folder and unzip the file.
Navigate to your *public* folder where you created your symlinks and delete the *typo3_src*.

bash: `rm -rf typo3_src`
CMD: `remdir typo3_src`

Afterwards create a new symlink to the newly downloaded Typo3 version.

bash: `ln -s ../../typo3_sources/{typo3_version} typo3_src`  \
CMD: `mklink /d typo3_src ..\..\typo3_sources\{typo3_version}`

Login to the typo3 backend and go to the maintenance tab. Flush caches and dump autoload. Navigate to the Upgrade tab and run the Upgrade Wizard.
You might need to flush caches and dump the autoload again.
Check your frontend if everything is working.


## Major Versions

Before updating to major versions, it is recommended to update to the latest minor version, run *Analyze Database*, *Flush Caches* and *Dump Autoload* in the Maintenance Tab. Navigate to DB Check tab and run *Update reference index*.

Afterwards you can remove your old typo3_src symlink and provide a new one linking to the new major version.

Check your Extensions, upgrade them if possible / necessary, run the Upgrade Wizard again, flush caches and dump autoload, and check your frontend if everything is working.


## Updating from TYPO3 10 to TYPO3 11

When updating from TYPO3 10 to TYPO3 11, both the directory structure and several core definition files have been revised. Although TYPO3 11 still supports the old layout for backward compatibility, these legacy structures are already deprecated and will be removed in TYPO3 12.

In your server configuration (e.g., `.htaccess`, `web.config`, or a Caddyfile), set the following environment variables:
- `TYPO3_PATH_ROOT`: the path to your TYPO3 installation directory
- `TYPO3_PATH_APP`: the path to your application’s **public** folder

Example configurations are provided in:
- `Examples/dummy_.htaccess`
- `Examples/dummy_web.config`

### New Folders in the Extension Root
- **system/**
  Contains all configuration files (previously in `AdditionalConfiguration.php`)
- **sites/**
  Matches the content of the old **typo3/sites/** folder from TYPO3 10

### New **config/** Structure
When TYPO3 starts, it reads `TYPO3_PATH_ROOT` and `TYPO3_PATH_APP` and automatically generates a **config/** folder alongside your **public/** directory. Within this new **config/** folder, the former `LocalConfiguration.php` has been renamed to `settings.php` and moved into the **config/system/** subfolder.

## Renamings in TYPO3 11+

Apart from the folder structure some definitions have to be changed as well for TYPO3 to continue working.

### Changing \<INCLUDE_TYPOSCRIPT> to @import

Previously, within the Configuration folder, imports have been handled via a \<INCLUDE_TYPOSCRIPT> tag. This tag is deprecated since Typo3 11 and has been replaced by an import statment.

An example would be:
 - old: `\<INCLUDE_TYPOSCRIPT: source="FILE:EXT:hh_slider/Configuration/TsConfig/AllPage.typoscript">`

 - new: `@import 'EXT:hh_slider/Configuration/TsConfig/AllPage.typoscript'`

### Renaming TYPO3_MODE to TYPO3

Another adjustment must be done for the Entry Point Protection in php files. There TYPO3_MODE must be renamed to TYPO3.

An example would be:
 - old: `defined('TYPO3_MODE') or die()`;
 - new: `defined('TYPO3') or die()`;
