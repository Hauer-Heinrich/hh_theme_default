<?php
declare(strict_types=1);

namespace {{EXTENSION_VENDOR}}\{{EXTENSION_NAMESPACE}}\Domain\Model;

use \TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use \TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use \TYPO3\CMS\Extbase\Domain\Model\FileReference;
use \GeorgRinger\News\Domain\Model\News;

/**
 * This file is part of the "{{EXTENSION_KEY}}" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2026 Christian Hackl <web@hauer-heinrich.de>, www.hauer-heinrich.de
 */

class NewsTheme extends News {

    /**
     * @var ObjectStorage<FileReference>
     */
    #[Lazy]
    protected ObjectStorage $customMedia;

    /**
     * @var ObjectStorage<FileReference>
     */
    #[Lazy]
    protected ObjectStorage $customMedia2;

    public function initializeObject(): void {
        parent::initializeObject();
        $this->customMedia ??= new ObjectStorage();
        $this->customMedia2 ??= new ObjectStorage();
    }

    /**
     * @return ObjectStorage<FileReference>|null
     */
    public function getCustomMedia(): ?ObjectStorage { return $this->customMedia; }
    /**
     * @param ObjectStorage<FileReference> $file
     */
    public function setCustomMedia(ObjectStorage $file): void { $this->customMedia = $file; }
    public function addCustomMedia(FileReference $file): void {
        if ($this->getCustomMedia() === null) {
            $this->customMedia = new ObjectStorage();
        }
        $this->customMedia->attach($file);
    }



    /**
     * @return ObjectStorage<FileReference>|null
     */
    public function getCustomMedia2(): ?ObjectStorage { return $this->customMedia2; }
    /**
     * @param ObjectStorage<FileReference> $file
     */
    public function setCustomMedia2(ObjectStorage $file): void { $this->customMedia2 = $file; }
    public function addCustomMedia2(FileReference $file): void {
        if ($this->getCustomMedia2() === null) {
            $this->customMedia2 = new ObjectStorage();
        }
        $this->customMedia2->attach($file);
    }
}
