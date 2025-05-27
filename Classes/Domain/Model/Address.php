<?php
namespace HauerHeinrich\HhThemeDefault\Domain\Model;

// use \FriendsOfTYPO3\TtAddress\Domain\Model\Address;
use \HauerHeinrich\HhTtAddressPlaces\Domain\Model\Place;

class Address extends Place {

    public string $themeSkills = '' {
        get {
            return $this->themeSkills;
        }
        set(string $value) {
            $this->themeSkills = $value;
        }
    }
}
