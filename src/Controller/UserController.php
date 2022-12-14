<?php
// src/Controller/UserController.php
namespace App\Controller;

// ...
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\Length;

class UserController extends AbstractController
{
    #[Route('/user', name: 'create_user')]
    public function createProduct(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $user = new User();
        $user->setName('Reconnact');
        $user->setPassword('test');
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($user);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$user->getId());
    }

    #[Route('/user/{id}', name: 'user_show')]
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $users = $doctrine->getRepository(user::class)->findAll(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        if (!$users) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }
        $response = " ";
        for ($i=0; $i < count($users); $i++) { 
            $response .= $users[$i]->getName();
        }


        return new Response($response);
    }
}