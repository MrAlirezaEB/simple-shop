<?php

namespace App\DataFixtures;

use App\Entity\Setting;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class SettingFixture extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $setting = new Setting();
        $setting->setWebsiteName('وبسایت فروشگاهی تستی');
        $manager->persist($setting);

        $manager->flush();
    }
}
