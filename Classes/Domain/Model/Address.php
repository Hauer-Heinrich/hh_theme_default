<?php
namespace {{EXTENSION_VENDOR}}\{{EXTENSION_NAMESPACE}}\Domain\Model;

// use \FriendsOfTYPO3\TtAddress\Domain\Model\Address;
use \HauerHeinrich\HhTtAddressPlaces\Domain\Model\Place;

class Address extends Place {

    private string $themeSkills = '';

    public function getThemeSkills(): string {
        return $this->themeSkills;
    }

    public function setThemeSkills(string $value): void {
        $this->themeSkills = $value;
    }
}
