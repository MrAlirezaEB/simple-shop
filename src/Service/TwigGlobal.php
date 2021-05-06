<?php
namespace App\Service;

use App\Entity\Setting;
use App\Repository\SettingRepository;

class TwigGlobal
{
    private $settings;

    public function __construct(SettingRepository $settingRepository) {
        $this->settings = $settingRepository->findAll()[0];
    }
    
    /**
     * this method gets website setting from database
     *
     * @param string $name
     * @return void
     */
    public function getSetting(string $name)
    {
        return $this->settings->get($name);
    }
}