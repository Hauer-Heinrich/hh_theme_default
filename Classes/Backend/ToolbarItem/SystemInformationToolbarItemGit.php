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
            $currentCommit = 'error';
            $remoteCommit = 'error';
            // exec('cd '. $extensionPath . ' && git ls-remote --refs --quiet 2>&1 || echo "ERROR"', $remoteCommits);
            exec('cd ' . $extensionPath . ' git fetch');
            exec('cd ' . $extensionPath . ' && git show-ref '.$currentBranch.' 2>&1', $remoteCommits);

            $statusCode = 'danger';
            if(is_array($remoteCommits) && !empty($remoteCommits)) {
                $currentCommit = substr(explode(' ', $remoteCommits[0])[0], 0, 7);
                $remoteCommit = substr(explode(' ', $remoteCommits[1])[0], 0, 7);

                if($currentCommit === $remoteCommit) {
                    $statusCode = 'success';
                } else {
                    $statusCode = 'warning';
                }
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
