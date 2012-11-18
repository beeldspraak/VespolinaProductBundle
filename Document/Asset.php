<?php
/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vespolina\ProductBundle\Document;

use Vespolina\Entity\Asset\Asset as AbstractAsset;
use Vespolina\Entity\Asset\AssetInterface;
/**
 * @author Myke Hines <myke@webhines.com>
 */
class Asset extends AbstractAsset implements AssetInterface
{
    protected $id;
}
