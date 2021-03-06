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

use Vespolina\Entity\Asset\AssetInterface;
use Vespolina\ProductBundle\Model\AssetManager as BaseAssetManager;
/**
 * @author Myke Hines <myke@webhines.com>
 */
class AssetManager extends BaseAssetManager
{
    protected $dm;
    protected $assetRepo;
    protected $assetModelClass;

    public function __construct(DocumentManager $dm, $assetModelClass )
    {
        $this->dm = $dm;
        $this->assetRepo = $this->dm->getRepository($assetModelClass);
        $this->assetModelClass = $assetModelClass;

    }

    /**
     * @inheritdoc
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->assetRepo->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @inheritdoc
     */
    public function findAssetsByType($product, $type)
    {

        $assets = $this->assetRepo->findBy( array('type' => $type, 'product' => new \MongoId($product->getId() )));
        return $assets;
    }

    /**
     * @inheritdoc
     */
    public function findAssetByType($product, $type)
    {
        $qb = $this->dm->createQueryBuilder($this->assetModelClass);

        $asset =  $qb->select()
            ->field('product')->references($product)
            ->field('type')->equals($type)
            ->getQuery()
            ->getSingleResult();
        return $asset;
    }


    /**
     * @inheritdoc
     */
    public function updateAsset(assetInterface $asset, $andFlush = true)
    {
        $this->dm->persist($asset);
        if ($andFlush) {
            $this->dm->flush();
        }
    }
}
