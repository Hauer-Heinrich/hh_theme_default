<?php
defined('TYPO3_MODE') || die();

call_user_func(function() {
    $extensionKey = 'hh_theme_default';

    // Disable language copy for auto translated content
    $TCA['tt_content']['columns']['header']['l10n_mode'] = '';
    $TCA['tt_content']['columns']['bodytext']['l10n_mode'] = '';
});
