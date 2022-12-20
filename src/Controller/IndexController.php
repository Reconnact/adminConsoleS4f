<?php
// src/Controller/UserController.php
namespace App\Controller;

// ...

use App\Entity\Followers;
use App\Entity\Profile;
use App\Entity\Post;
use App\Entity\Comments;


use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    #[Route('/start', name: '')]
    public function showLandingPage(ManagerRegistry $doctrine): Response{
        //Get data from database
        $users = $doctrine->getRepository(profile::class)->findAll(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        $posts = $doctrine->getRepository(post::class)->findAll(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        $comments = $doctrine->getRepository(comments::class)->findAll(\Doctrine\ORM\Query::HYDRATE_ARRAY);

        //Prepare user-table data
        $userObjects = [count($users)];
        for ($i=0; $i < count($users); $i++) { 
            $userObjects[$i] = [$users[$i]->getProfileid(), $users[$i]->getUsername(), $users[$i]->getFirstname(), $users[$i]->getLastname(), $users[$i]->getMail(), 
            self::getFollowerCount($users[$i]->getProfileid(), $doctrine), self::getFollowingCount($users[$i]->getProfileid(), $doctrine), 
            self::getPostCount($users[$i]->getProfileid(), $doctrine)];
        }
        $userData = [
        'tablename' => "Users", 
        'columnTitle' => ["Profile ID", "Usernames", "First name", "Last name", "E-Mail", "Followers", "Following", "Posts"],
        'rowData' => $userObjects,
        'edit' => "/profile/"];

        //Prepare post-table data
        $postObjects = [count($posts)];
        for ($i=0; $i < count($posts); $i++) { 
            $postObjects[$i] = [$posts[$i]->getPostid(), $posts[$i]->getTitle(),  $posts[$i]->getProfileid()->getUsername(), date_format($posts[$i]->getDate(), 'Y-m-d H:i:s')];
        }
        $postData = [
        'tablename' => "Post", 
        'columnTitle' => ["Post ID", "Post", "Username", "Date"],
        'rowData' => $postObjects,
        'edit' => "/post/"];

        //Prepare comment-table data
        $commentObjects = [count($comments)];
        for ($i=0; $i < count($comments); $i++) { 
            $commentObjects[$i] = [$comments[$i]->getCommentid(), $comments[$i]->getComment(), $comments[$i]->getProfileid()->getUsername(), $comments[$i]->getPostid()->getTitle(), date_format($comments[$i]->getCommentdate(), 'Y-m-d H:i:s')];
        }
        $commentData = [
        'tablename' => "Comments", 
        'columnTitle' => ["Comment ID", "Comment", "Username", "Post", "Date"],
        'rowData' => $commentObjects,
        'edit' => "/comment/"];

        $data = [$userData, $postData, $commentData];

        //Return the HTML-page
        return $this->render('index.html.twig', [
            'data' => $data
        ]);
    }

    //Get the amount of followers a user has
    public function getFollowerCount(int $profileID, ManagerRegistry $doctrine): int{
        $followers = $doctrine->getRepository(Followers::class)->findAll(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        $followerCount = 0;
        for ($i=0; $i < count($followers); $i++) { 
            if ($followers[$i]->getProfileid()->getProfileid() === $profileID){
                $followerCount++;
            }
        }
        return $followerCount;
    }

    //Get the amount of people who a user follows
    public function getFollowingCount(int $profileID, ManagerRegistry $doctrine): int{
        $followers = $doctrine->getRepository(Followers::class)->findAll(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        $followingCount = 0;
        for ($i=0; $i < count($followers); $i++) { 
            if ($followers[$i]->getFollowerid()->getProfileid() === $profileID){
                $followingCount++;
            }
        }
        return $followingCount;
    }

    //Get the amount of posts a user has written
    public function getPostCount(int $profileID, ManagerRegistry $doctrine): int{
        $posts = $doctrine->getRepository(Post::class)->findAll(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        $postCount = 0;
        for ($i=0; $i < count($posts); $i++) { 
            if ($posts[$i]->getProfileid()->getProfileid() === $profileID){
                $postCount++;
            }
        }
        return $postCount;
    }

}

