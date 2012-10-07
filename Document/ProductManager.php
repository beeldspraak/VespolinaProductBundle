<?php
/**
 * (c) 2011-2012 Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vespolina\ProductBundle\Document;

use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\DependencyInjection\Container;

use Vespolina\Entity\Product\ProductInterface;
use Vespolina\Produt\Manager\ProductManager as BaseProductManager;
/**
 * @author Richard Shank <develop@zestic.com>
 */
class ProductManager extends BaseProductManager
{
    protected $dm;
    protected $merchandiseRepo;
    protected $productRepo;

    public function __construct(DocumentManager $dm, $productClass, $merchandiseClass, $identifiers, $identifierSetClass)
    {
        $this->dm = $dm;
        $this->productClass = $productClass;
        $this->merchandiseRepo = $this->dm->getRepository($merchandiseClass);
        $this->productRepo = $this->dm->getRepository($productClass);

        parent::__construct($identifiers, $identifierSetClass, $merchandiseClass);
    }

    /**
     * @inheritdoc
     */
    protected function doFindBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->productRepo->findBy($criteria, $orderBy, $limit, $offset);
    }

    protected function doFindMerchandiseBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->productRepo->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @inheritdoc
     */
    protected function doFindProductById($id)
    {
        if ($product = $this->productRepo->find($id)) {
            $rp = new \ReflectionProperty($product, 'identifierSetClass');
            $rp->setAccessible(true);
            $rp->setValue($product, $this->identifierSetClass);

            return $product;
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    protected function doFindProductByIdentifier($name, $code)
    {

    }

    /**
     * @inheritdoc
     */
    protected function doFindProductByName($name)
    {
        $products = array();
        if (!$results = $this->productRepo->findBy(array('name' => $name))) {

            return null;
        }

        $rp = new \ReflectionProperty($this->productClass, 'identifierSetClass');
        $rp->setAccessible(true);

        foreach ($results as $product) {
            $rp->setValue($product, $this->identifierSetClass);
        }

        if ($results->count() === 1) {
            $results->reset();
            return $results->getNext();
        }

        return $results;
    }

    /**
     * @inheritdoc
     */
    protected function doFindProductBySlug($slug)
    {
        if ($product = $this->productRepo->findOneBy(array('slug' => $slug))) {

            $rp = new \ReflectionProperty($product, 'identifierSetClass');
            $rp->setAccessible(true);
            $rp->setValue($product, $this->identifierSetClass);

            return $product;
        }

        return null;
    }

    protected function doGetMerchandise(array $constraints = null)
    {

    }

    protected function doUpdateProduct(ProductInterface $product, $andFlush = true)
    {
        $this->dm->persist($product);
        if ($andFlush) {
            $this->dm->flush();
        }
    }
}
