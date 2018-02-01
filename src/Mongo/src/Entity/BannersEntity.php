<?php

namespace Banners\Entity;

use Banners\Form\AddBanner;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="banners",
 * indexes={
 *     @ORM\Index(name="type", columns={"type"}),
 *     @ORM\Index(name="auth_type", columns={"type","auth"})}
 *     )
 */
class BannersEntity
{
    const DB_NAME="banners";
    protected static $listBanners=null;
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @ORM\Column(type="string", length=255) */
    protected $img;

    /** @ORM\Column(type="text") */
    protected $link;

    /** @ORM\Column(type="string", length=255) */
    protected $title;

    /** @ORM\Column(type="integer") */
    protected $weight;

    /** @ORM\Column(type="integer") */
    protected $type;

    /** @ORM\Column(type="integer") */
    protected $auth;
    
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function dataForm()
    {
        $array=[
            AddBanner::BANNER_TYPE => $this->getType(),
            AddBanner::BANNER_LINK => $this->getLink(),
            AddBanner::BANNER_IMAGE => $this->getImg(),
            AddBanner::BANNER_TITLE => $this->getTitle(),
        ];
        return $array;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $img
     */
    public function setImg($img)
    {
        $this->img = $img;
    }

    /**
     * @param mixed $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param mixed $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    /**
     * @return mixed
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     * @param mixed $auth
     */
    public function setAuth($auth)
    {
        $this->auth = $auth;
    }

}