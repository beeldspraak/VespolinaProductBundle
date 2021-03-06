<?php
/**
 * (c) 2011-2012 Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\ProductBundle\Tests\Model;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

use Vespolina\ProductBundle\Model\Product;
use Vespolina\ProductBundle\Model\Identifier\ProductIdentifierSet;
use Vespolina\ProductBundle\Tests\ProductTestCommon;

/**
 * @author Richard D Shank <develop@zestic.com>
 */
class ProductManagerTest extends ProductTestCommon
{
    protected $mgr;
    protected $product;

    protected function setUp()
    {
        $this->mgr = $this->createProductManager();
    }

    public function testAddProductHandler()
    {
        $handler = $this->createProductHandler('test');
        $this->mgr->addProductHandler($handler);

        $this->assertSame($handler, $this->mgr->getProductHandler('test'), 'a handler should be returned by type');
        $this->assertTrue(is_array($this->mgr->getProductHandlers()));
        $this->assertContains($handler, $this->mgr->getProductHandlers(), 'return all of the handlers');

        $handler2 = $this->createProductHandler('test2');
        $this->mgr->addProductHandler($handler2);
        $this->assertContains($handler2, $this->mgr->getProductHandlers(), 'return all of the handlers');
        $this->assertCount(2, $this->mgr->getProductHandlers());

        $this->mgr->removeProductHandler('test2');
        $this->assertCount(1, $this->mgr->getProductHandlers(), 'there should now only be one handler');

        $this->mgr->removeProductHandler('test');
        $this->assertEmpty($this->mgr->getProductHandlers(), 'there should be no handlers after test has been removed');
    }

    public function testCreateProduct()
    {
        $handler = $this->createProductHandler('test');
        $this->mgr->addProductHandler($handler);

        $this->assertInstanceOf('Vespolina\Entity\ProductInterface', $this->mgr->createProduct('test'));

        // todo: this should be through a handler also, but for now, it is using the legacy method of creating a class
        $pc = new \ReflectionProperty($this->mgr, 'productClass');
        $pc->setAccessible(true);
        $pc->setValue($this->mgr, 'Vespolina\ProductBundle\Tests\Fixtures\Model\Product');

        $this->assertInstanceOf('Vespolina\Entity\ProductInterface', $this->mgr->createProduct('default'));
        $this->assertInstanceOf('Vespolina\Entity\ProductInterface', $this->mgr->createProduct());
    }

    public function testSearchForProductByIdentifier()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );

        // search by identifier should return a product set up with the specific information for that identifier
        // full results flag returns the full data set for the product
    }

    public function testCreateIdentifierSet()
    {
        $this->markTestIncomplete(
            'Behavior has changed, needs refactoring.'
        );

        $mgr = $this->createProductManager('Vespolina\ProductBundle\Model\Identifier\IdIdentifier');
        $this->assertInstanceOf(
            'Vespolina\ProductBundle\Model\Identifier\ProductIdentifierSet',
            $mgr->createIdentifierSet($this->createIdentifierNode('noset')),
            'using an instance of the primary identifier as a parameter should create a new PrimaryIdentifierSet'
        );
    }

    public function testCreateOption()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );

        $mgr = $this->createProductManager('Vespolina\ProductBundle\Model\Identifier\Identifier');

        $option = $mgr->createOption('CoLoR', 'BlAcK');

        $this->assertInstanceOf(
            'Vespolina\ProductBundle\Model\Option\OptionInterface',
            $option,
            'an Option instance should be created'
        );

        $this->assertEquals(
            'CoLoR',
            $option->getType(),
            'make sure the type of the option is stored correctly'
        );

        $this->assertEquals(
            'BlAcK',
            $option->getValue(),
            'make sure the value of the option is stored correctly'
        );
    }

    public function testAddAttributeToProduct()
    {
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );

        $label = $this->createAttribute('label', 'Joat Music');

        $this->mgr->addAttributeToProduct($label, $this->product);
        $this->assertEquals(1, $this->product->getAttributes()->count(), 'make sure the attribute has been added');
    }

    public function testGetImageManager()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
        $mgr = $this->createProductManager($mediaManager);

        $this->assertSame($mediaManager, $mgr->getMediaManager());

        $this->setExpectedException('Symfony\Component\Config\Definition\Exception\InvalidConfigurationException');
        $mgr = $this->createProductManager('Vespolina\ProductBundle\Model\Identifier\IdIdentifier');
        $mgr->getMediaManager();
    }

    public function testSearchForProductByAttribute()
    {
        // search by identifier should return a product set up with the specific information for that identifier
        // full results flag returns the full data set for the product
    }

    public function testSearchForProductByAttributeType()
    {
        // search by identifier should return a product set up with the specific information for that identifier
        // full results flag returns the full data set for the product
    }

    protected function createProductManager()
    {
        $mgr = $this->getMockBuilder('Vespolina\ProductBundle\Model\ProductManager')
            ->setMethods(array(
                '__construct',
                'findBy',
                'findProductById',
                'findProductByIdentifier',
                'getPrimaryIdentifier',
                'getIdentifierSetClass',
                'getOptionClass',
                'updateProduct'
            ))
             ->disableOriginalConstructor()
             ->getMock();
        $mgr->expects($this->any())
             ->method('getIdentifierSetClass')
             ->will($this->returnValue('Vespolina\ProductBundle\Document\ProductIdentifierSet'));
        $mgr->expects($this->any())
             ->method('getOptionClass')
             ->will($this->returnValue('Vespolina\ProductBundle\Document\Option'));
        return $mgr;
    }
}
