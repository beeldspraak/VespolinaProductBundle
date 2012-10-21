<?php
/**
 * (c) 2012 Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vespolina\ProductBundle\Tests\Document;

use Vespolina\ProductBundle\Tests\Fixtures\Document\Product;
use Vespolina\ProductBundle\Document\Attribute;
use Vespolina\ProductBundle\Tests\Document\ProductTestCommon;
/**
 * @author Richard D Shank <develop@zestic.com>
 */
class ProductTest extends ProductTestCommon
{
    public function testPersistAttributes()
    {

        $product = $this->productMgr->createProduct();

        $labelAttribute = new Attribute();
        $labelAttribute->setType('label');
        $labelAttribute->setName('Joat Music');
        $product->addAttribute($labelAttribute);

        $formatAttribute = new Attribute();
        $formatAttribute->setType('format');
        $formatAttribute->setName('vinyl');
        $product->addAttribute($formatAttribute);

        $attributes = $product->getAttributes();
        $this->productMgr->updateProduct($product);

        $persistedProduct = $this->productMgr->findProductById($product->getId());
        $persistedAttributes = $persistedProduct->getAttributes();

        $this->assertSame(count($attributes), count($persistedAttributes));
        $this->assertArrayHasKey(0, $persistedAttributes);
        $this->assertArrayHasKey(1, $persistedAttributes);

        foreach ($attributes as $attribute) {
            $type = $attribute->getType();
            $persistedAttribute = $persistedProduct->getAttribute($type);
            $this->assertInstanceOf('Vespolina\ProductBundle\Model\Attribute\AttributeInterface', $persistedAttribute);
            $this->assertSame($attribute->getName(), $persistedAttribute->getName());
            $this->assertSame($attribute->getSearchTerm(), $persistedAttribute->getSearchTerm());
        }
    }
}
