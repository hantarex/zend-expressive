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
 * @ORM\Document()
 */
class Products
{
    /** @Id(strategy="NONE", type="string") */
    private $id;
}