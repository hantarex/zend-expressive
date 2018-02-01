<?php
/**
 * Created by PhpStorm.
 * User: ashikov
 * Date: 31.01.2018
 * Time: 16:26
 */

namespace Mongo\Entity;


use Doctrine\ODM\MongoDB\Mapping\Annotations as ORM;


/**
 * @ORM\Document(collection="products")
 */
class Products
{
    /** @ORM\Id(strategy="NONE", type="string") */
    private $id;
    
    /** @ORM\Field(type="string") */
    private $brand;

    /** @ORM\Field(type="string", name="color_name") */
    private $color;
}