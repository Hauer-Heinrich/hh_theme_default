<?php
namespace HauerHeinrich\HhThemeDefault\Backend\ToolbarItem;

// use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use \TYPO3\CMS\Backend\Backend\ToolbarItems\SystemInformationToolbarItem;

class SystemInformationToolbarItemGit {

    /**
     * extensionKey
     *
     * @var string
     */
    protected $extensionKey;

    public function __construct() {
        $this->extensionKey = 'hh_theme_default';
    }

    public function addGitInformation(SystemInformationToolbarItem $systemInformation) {
        $extensionPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($this->extensionKey);

        // get current used git branch
        $currentBranch = exec('cd '. $extensionPath . ' && git rev-parse --abbrev-ref HEAD');

        if(!empty($currentBranch)) {
            // make a padding to other information at the toolbar
            $systemInformation->addSystemInformation(
                'Theme Information:',
                ' ',
                'transparent'
            );

            // show current used git branch
            $systemInformation->addSystemInformation(
                'GIT branch',
                htmlspecialchars(trim($currentBranch)),
                'icon-git'
            );

            // get remote commit information
            $remoteCommit = '';
            exec('cd '. $extensionPath . ' && git ls-remote --refs --quiet', $remoteCommits);
            if(is_array($remoteCommits) && !empty($remoteCommits)) {
                foreach ($remoteCommits as $key => $value) {
                    if (substr($value, -strlen($currentBranch)) === $currentBranch) {
                        $remoteCommit = substr($value, 0, 7);
                    }
                }
            }

            // get current commit id
            $currentCommit = exec('cd '. $extensionPath . ' && git rev-parse --short HEAD');

            if (!empty($currentCommit) && !empty($remoteCommit)) {
                $statusCode = 'success';
                // status code for addSystemInformation(...)
                if ($remoteCommit !== $currentCommit) {
                    $statusCode = 'warning';
                }

                // show current git commit
                $systemInformation->addSystemInformation(
                    'GIT commit',
                    htmlspecialchars(trim($currentCommit)),
                    'icon-git',
                    $statusCode
                );

                // show remote git commit
                $systemInformation->addSystemInformation(
                    'GIT commit remote',
                    htmlspecialchars(trim($remoteCommit)),
                    'icon-git'
                );
            }
        }
    }
}
