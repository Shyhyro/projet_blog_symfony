<?php

namespace App\Controller;

use App\Entity\Commentary;
use App\Entity\Post;
use App\Form\CommentaryFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/onePost_{id}', name: 'onepost')]
    public function onepost(Post $post, Request $request, EntityManagerInterface $em) : Response
    {
        $commentary = new Commentary();
        $form = $this->createForm(CommentaryFormType::class, $commentary);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentary->setUserFk($this->getUser())->setPostFk($post)->setDate(new \DateTime());
            $em->persist($commentary);
            $em->flush();
        }

        return $this->render("./home/post.html.twig", [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/moderator', name: "Moderation", methods: ['GET'])]
    public function moderator() : Response
    {
        return $this->render("./moderator/moderator.html.twig", [
        ]);
    }
}