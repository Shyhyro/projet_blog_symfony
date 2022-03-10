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

    #[Route('/onePost_{id}', name: 'onepost', methods: ['GET'])]
    public function onepost(Post $post, EntityManagerInterface $em) : Response
    {
        return $this->render("./home/post.html.twig", [
            'post' => $post
        ]);
    }

    #[Route('/moderator', name: "Moderation", methods: ['GET'])]
    public function moderator() : Response
    {
        return $this->render("./moderator/moderator.html.twig", [
        ]);
    }
}