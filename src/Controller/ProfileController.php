<?php
// src/Controller/UserController.php
namespace App\Controller;

// ...
use App\Entity\Profile;
use App\Entity\Followers;
use Doctrine\Persistence\ManagerRegistry;
use PhpParser\Node\Expr\Cast\Array_;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\Length;

class ProfileController extends AbstractController
{
    #[Route('/profile/{id}', name: 'profile_show')]
    public function show(ManagerRegistry $doctrine, int $id): Response {
        //Get User data
        $users = $doctrine->getRepository(profile::class)->findAll(\Doctrine\ORM\Query::HYDRATE_ARRAY);

        //Get User by ID
        $data = null;
        for ($i=0; $i < count($users); $i++) { 
            if ($users[$i]->getProfileid() === $id){
                $data = [
                    $users[$i]->getProfileid(), 
                    $users[$i]->getUsername(), 
                    [
                        "First Name" => $users[$i]->getFirstName(),
                        "Last Name" => $users[$i]->getLastname(),
                        "E-Mail" => $users[$i]->getMail(),
                        "Bio" => $users[$i]->getBio(),
                        "Follower" => self::getFollower($doctrine, $id),
                        "Following" => self::getFollowing($doctrine, $id)
                    ]
                ];
            }
        }

        //Check if User was found and throw exeption if not
        if ($data === null){
            return new Response("404");
        }

        //Return the HTML-page
        return $this->render('profile.html.twig', [
            'data' => $data
        ]);
    }

    public function getFollowing(ManagerRegistry $doctrine, int $id) : array{
        $followers = $doctrine->getRepository(Followers::class)->findAll(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        $followerData = [];
        for ($i=0; $i < count($followers); $i++) { 
            if ($followers[$i]->getFollowerid()->getProfileid() === $id){
                 array_push($followerData, $followers[$i]->getProfileid()->getUsername());
            }
        }
        return $followerData;
    }

    public function getFollower(ManagerRegistry $doctrine, int $id) : array{
        $followers = $doctrine->getRepository(Followers::class)->findAll(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        $followerData = [];
        for ($i=0; $i < count($followers); $i++) { 
            if ($followers[$i]->getProfileid()->getProfileid() === $id){
                 array_push($followerData, $followers[$i]->getFollowerid()->getUsername());
            }
        }
        return $followerData;
    }
}