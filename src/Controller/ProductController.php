<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
//    /**
//     * @Route("/product", name="product")
//     */
//    public function index(): Response
//    {
//        return $this->render('product/index.html.twig', [
//            'controller_name' => 'ProductController',
//        ]);
//    }

    /**
     * @Route("/product", name="product")
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = new Product();
        $product->setName('Keyboard');
        $product->setPrice(1999);
        $entityManager->persist($product);
        $entityManager->flush();
        return new Response('Saved new product ' . $product);
    }
}
