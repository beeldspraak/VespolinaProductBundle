<?php

namespace Vespolina\ProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function detailAction($slug)
    {
        $productManager = $this->container->get('vespolina.product_manager');

        $product = $productManager->findMerchandiseBySlug($slug);

        return $this->render('VespolinaProductBundle:Default:detail.html.twig', array('product' => $product));
    }

}
