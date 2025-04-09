<?php

namespace HauerHeinrich\{{EXTENSION_NAMESPACE}}\Domain\Model;

use \TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use \TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use \TYPO3\CMS\Extbase\Domain\Model\FileReference;
use \GeorgRinger\News\Domain\Model\News AS originalNews;

class News extends originalNews {

    /**
     * @var ObjectStorage<FileReference>
     */
    #[Lazy]
    protected $customMedia;

    /**
     * @var ObjectStorage<FileReference>
     */
    #[Lazy]
    protected $customMedia2;

    public function __construct()
    {
        parent::__construct();
        $this->customMedia = new ObjectStorage();
        $this->customMedia2 = new ObjectStorage();
    }

    /**
     * Get the Fal media items
     *
     * @return ObjectStorage<FileReference>|null
     */
    public function getCustomMedia(): ?ObjectStorage
    {
        return $this->customMedia;
    }

    /**
     * Set Fal media relation
     *
     * @param ObjectStorage<FileReference> $customMedia
     */
    public function setCustomMedia(ObjectStorage $customMedia): void
    {
        $this->customMedia = $customMedia;
    }

    /**
     * Add a Fal media file reference
     */
    public function addCustomMedia(FileReference $customMedia): void
    {
        if ($this->getCustomMedia() === null) {
            $this->customMedia = new ObjectStorage();
        }
        $this->customMedia->attach($customMedia);
    }

    /**
     * Get the Fal media items
     *
     * @return ObjectStorage<FileReference>|null
     */
    public function getCustomMedia2(): ?ObjectStorage
    {
        return $this->customMedia2;
    }

    /**
     * Set Fal media relation
     *
     * @param ObjectStorage<FileReference> $customMedia
     */
    public function setCustomMedia2(ObjectStorage $customMedia): void
    {
        $this->customMedia2 = $customMedia;
    }

    /**
     * Add a Fal media file reference
     */
    public function addCustomMedia2(FileReference $customMedia): void
    {
        if ($this->getCustomMedia() === null) {
            $this->customMedia2 = new ObjectStorage();
        }
        $this->customMedia2->attach($customMedia);
    }
}
