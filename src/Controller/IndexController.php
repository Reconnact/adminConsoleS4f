<?php
// src/Controller/UserController.php
namespace App\Controller;

// ...
use App\Entity\Profile;
use App\Entity\Post;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    #[Route('/start', name: '')]
    public function showLandingPage(ManagerRegistry $doctrine): Response{
        $users = $doctrine->getRepository(profile::class)->findAll(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        $posts = $doctrine->getRepository(post::class)->findAll(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        if (!$users) {
            throw $this->createNotFoundException(
                'No data found'
            );
        }
        $usernames = [count($users)];
        $postTitles = [count($posts)];
        for ($i=0; $i < count($users); $i++) { 
            $usernames[$i] = $users[$i]->getUsername();
            $postTitles[$i] = [$posts[$i]->getTitle(), $posts[$i]->getPostid()];

        }
        return $this->render('index.html.twig', [
            'usernames' => $usernames,
            'posts' => $postTitles
        ]);
    }
}