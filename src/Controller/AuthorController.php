<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    /**
     * @Route("/author", name="author")
     */
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    /**
     * @Route("/addAuthor")
     */
    public function addAuthorAction()
    {
        $a = new Author();
        $a->setName("T.W.");
        $m1 = new Message();
        $m1->setContents("m1");
        $m1->setAuthor($a);
        $m2 = new Message();
        $m2->setContents("m2");
        $m2->setAuthor($a);
        $em = $this->getDoctrine()->getManager();
        $em->persist($a);
        $em->persist($m1);
        $em->persist($m2);
        $em->flush();

        //return new Response ("OK".$a, Response::HTTP_OK);
        return $this->render(
            'author/add.html.twig', [
                "author" => $a,
                "messages" => [
                    "m1" => $m1,
                    "m2" => $m2
                ]
            ]);
    }



}
