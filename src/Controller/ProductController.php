<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/find", name="productById")
     * @param Request $request
     * @return Response
     */
    public function findById(Request $request)
    {
        $id = $request->query->get("id");
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);
        if($product!=null) {
            return new Response('Product with id: '.$id. ' was found:'. $product);
        } else {
            return new Response("Sorry, product with id ".$id ." was  not found :(", Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @Route("/all", name="allProducts")
     * @return Response
     */
    public function findAll()
    {
        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findAll();

            return $this->render(
                'product/findAll.html.twig', ["products" => $products]);
    }

    /**
     * @Route("/edit", name="edit")
     * @param Request $request
     * @return Response
     */
    public function editProduct(Request $request)
    {
        $id = $request->query->get("id");

        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Product::class)
            ->find($id);

        if (!$product)
        {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
        $product->setName('MEGA Keyboard!');
        $em->flush();
        return new Response ("Product with  id ".$id ." was updated. New product name is: " .$product->getName(), Response::HTTP_OK );
    }

    /**
     * @Route("/remove", name="remove")
     * @param Request $request
     * @return Response
     */
    public function removeProduct(Request $request)
    {
        $id = $request->query->get("id");

        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Product::class)
                ->find($id);

        if(!$product){
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
        $em->remove($product);
        $em->flush();

        return new Response("Product with id ".$id." has been removed from the database.");
    }
    
}
