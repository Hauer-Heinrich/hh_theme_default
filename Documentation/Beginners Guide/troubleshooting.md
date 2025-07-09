# Troubleshooting and Tips

Here are some of the common problems encountered. Before trying anything else: Flush your caches and dump the php autoload in the backend. It might have been just that.

## Lost Install Tool Password

If the install tool password has been lost, you can set a new one.
- create a file named "ENABLE_INSTALL_TOOL" in your *config* folder.
- visit {your_domain}/typo3/install.php
- enter a new install tool password
- copy the generated hash and replace the old install tool password
- the old hash is most likely found in the *config/system/settings.php* file

## Lost Backend User Access

It is possible to log into the install tool and create a new User. With this User it is possible to log into the Backend and set a new password for the old user where the password has been lost.

- create a file named "ENABLE_INSTALL_TOOL" in your *config* folder.
- visit {your_domain}/typo3/install.php
- enter the install tool password
- create a new backend user, choose the option "Add as system maintainer"
- login and reset your old password
- login with you old account and delete the temporary user
- delete the file "ENABLE_INSTALL_TOOL"

## Cannot find TypoScript / PageTS (BE)

Did you install the default theme extension?

- in the typo3 backend navigate to extension
- check if the default theme is installed

## DBAL Error

Your Database connection might not be correctly setup. Check you *config/system/settings.php* or *env/typo3_conf.php* file if you entered the correct connection data.

## ImageMagick

If you experience trouble with ImageMagick you might want to check to access rights of your web-server user (IIS user for windows or wwwdata for Linux).
The user needs access to all subfolders of *public*. Another common error is the path provided in your settings.php. The path should point to the installation of e.g., ImageMagick.
```php
 'GFX' =>  [
    'processor' => 'ImageMagick',
    'im_path' => 'C:\\Program Files\\ImageMagick-7.0.8-Q16\\',
    'processor_path' => 'C:\\Program Files\\ImageMagick-7.0.8-Q16\\',
    'processor_path_lzw' => 'C:\\Program Files\\ImageMagick-7.0.8-Q16\\'
    ]
```

