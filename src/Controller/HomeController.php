<?php

namespace App\Controller;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'Home', methods: ['GET'])]
    public function home(EntityManagerInterface $em) : Response
    {
        $posts = $em->getRepository(Post::class)->findAll();

        return $this->render("./home/home.html.twig", [
            'posts' => $posts
        ]);
    }

}