<?php

namespace App\Entity;

use App\Repository\SettingRepository;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SettingRepository::class)
 */
class Setting
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $website_name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $logo;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
     private $createdAt;

     /**
      * @Gedmo\Timestampable(on="update")
      * @ORM\Column(type="datetime")
      */
     private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWebsiteName(): ?string
    {
        return $this->website_name;
    }

    public function setWebsiteName(string $website_name): self
    {
        $this->website_name = $website_name;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }
 
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    //extra getter for all
    public function get(string $name)
    {
        return $this->$name;
    }
}
