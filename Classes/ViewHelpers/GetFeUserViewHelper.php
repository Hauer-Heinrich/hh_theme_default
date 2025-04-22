<?php
declare(strict_types=1);

namespace {{EXTENSION_VENDOR}}\{{EXTENSION_NAMESPACE}}\ViewHelpers;

// use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use \TYPO3\CMS\Core\Context\Context;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

final class GetFeUserViewHelper extends AbstractViewHelper {

    public function initializeArguments() {
        parent::initializeArguments();
    }

    public function render(): array {
        $user = [];
        $context = GeneralUtility::makeInstance(Context::class);

        if ($context->getPropertyFromAspect('frontend.user', 'isLoggedIn')) {
            $feUserUid = $context->getPropertyFromAspect('frontend.user', 'id');
            $user = [
                'name' => $context->getPropertyFromAspect('frontend.user', 'username'),
            ];

            $fileRepository = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\FileRepository::class);
            $user['image'] = $fileRepository->findByRelation('fe_users', 'image', $feUserUid);
        }

        return $user;
    }
}
