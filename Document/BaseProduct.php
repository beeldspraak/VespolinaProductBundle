<?php
/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vespolina\ProductBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Vespolina\Entity\Product\Product as AbstractProduct;

/**
 * @author Richard Shank <develop@zestic.com>
 */
abstract class BaseProduct extends AbstractProduct
{
    protected $id;

    protected $identifiers;
    protected $identifierSetClass;

    protected $createdAt;
    protected $updatedAt;

    public function __construct($identifierSetClass)
    {
        $this->attributes = array();

        $this->identifierSetClass = $identifierSetClass;
        $this->identifiers = new ArrayCollection();
        $this->assets = new ArrayCollection();
        $this->attributes = new ArrayCollection();
    }

    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function setAssets($assets)
    {
        $this->assets = $assets;
    }

    public function getAssets()
    {
        return $this->assets;
    }



}
