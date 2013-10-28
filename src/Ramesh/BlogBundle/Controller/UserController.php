<?php

namespace Ramesh\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ramesh\BlogBundle\Document\User;
use Ramesh\BlogBundle\Form\Type\UserType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

class UserController extends Controller {

    public function createAction() {
        $users = array(
            array('name' => 'Ramesh', 'email' => 'rameshk@mindfiresolutions.com', 'age' => 24),
            array('name' => 'Anoop', 'email' => 'anoopj@mindfiresolutions.com', 'age' => 25),
            array('name' => 'Ansuraj', 'email' => 'ansuraj@mindfiresolutions.com', 'age' => 24),
            array('name' => 'Abhilash', 'email' => 'abhilash@gmail.com', 'age' => 24)
        );
        $dm = $this->get('doctrine_mongodb')->getManager();
        foreach ($users as $usr) {
            $user = new User();
            $user->setName($usr['name']);
            $user->setEmail($usr['email']);
            $user->setAge($usr['age']);
            $dm->persist($user);
        }
        $dm->flush();
        return new Response(count($users) . ' users created.');
    }

    public function listUsersAction() {
        $repository = $this->get('doctrine_mongodb')->getManager()->getRepository('RameshBlogBundle:User');
        $users = $repository->findAll();
        foreach ($users as $user) {
            echo 'id: ', $user->getId();
            echo '<br/>Name: ', $user->getName();
            echo '<br/>Age: ', $user->getAge();
            echo '<br/>Group: ';
            echo is_object($group = $user->getGroup()) ? $group->getName() : '';
            echo '<br/>_____________________________________________________________________<br/>';
        }
    }

    public function showPostsAction($id) {
        $repository = $this->get('doctrine_mongodb')->getManager()->getRepository('RameshBlogBundle:User');
        $user = $repository->find($id);
        if (!$user) {
            throw $this->createNotFoundException('No user found for id ' . $id);
        }
        $posts = $user->getPosts();
        foreach ($posts as $post) {
            echo 'id: ', $post->getId();
            echo '<br/>title: ', $post->getTitle();
            echo '<br/>body: ', $post->getBody();
            echo '<br/>created: ', $post->getCreatedAt()->format('Y-m-d H:i:s');
            echo '<br/>userId: ', $post->getUser()->getId();
            echo '<br/>Username/Age: ', $post->getUser()->getName(), '/', $post->getUser()->getAge();
            echo '<br/>Email: ', $post->getUser()->getEmail();
            echo '<br/>_____________________________________________________________________<br/>';
        }
        return new Response('Showing ' . count($posts) . ' Posts of User ' . $user->getName());
    }

    public function createThruFormAction(Request $request) {
        ini_set('display_errors', 1);
        error_reporting(~0);
        $user = new User();
        $form = $this->createForm('user', $user, array('method' => 'POST'));
        $form->handleRequest($request);
        $response = new Response();
        $response->headers->set('Cache-Control', 'no-cache');
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $dm = $this->get('doctrine_mongodb')->getManager();
                $user->uploadImage();
                $user->setFavorite("Sachin Tendulkar");
                $user->setUsername($user->getEmail());
                $user->setSalt(uniqid());
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
                $user->setPassword($password);
               
                $dm->persist($user);
                $dm->flush();
                return $this->redirect($this->generateUrl('user_create_success', array('user' => $user->getId())));
            }
        }
         $content = $this->renderView('RameshBlogBundle:User:new.html.twig', array(
                'form' => $form->createView(),
        ));
        $response->headers->set('X-HT', 'sdds');
        $response->setContent($content);
        #$response->send();
        return $response;
    }
    
    

    public function createSuccessAction($user) {
        return $this->render('RameshBlogBundle:User:success.html.twig', array('user' => $user));
    }

    public function loginAction() {
        $request = $this->getRequest();
        $session = $request->getSession();
         $response = new Response();
        $response->headers->set('Cache-Control', 'no-cache');
        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
        $view = $this->renderView(
                'RameshBlogBundle:User:login.html.twig', array(
                // last username entered by the user
                'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                'error' => $error,
                )
        );
         $response->headers->set('X-HT', 'sdds');
        $response->setContent($view);
        #$response->send();
        return $response;
    }
    
    public function showMyPostsAction() {
        $user= $this->get('security.context')->getToken()->getUser();
        echo $user->getCcExp()->format('Y-m-d');
        $posts = $user->getPosts();
        foreach ($posts as $post) {
            echo 'id: ', $post->getId();
            echo '<br/>title: ', $post->getTitle();
            echo '<br/>body: ', $post->getBody();
            echo '<br/>created: ', $post->getCreatedAt()->format('Y-m-d H:i:s');
            echo '<br/>userId: ', $post->getUser()->getId();
            echo '<br/>Username/Age: ', $post->getUser()->getName(), '/', $post->getUser()->getAge();
            echo '<br/>Email: ', $post->getUser()->getEmail();
            echo '<br/>_____________________________________________________________________<br/>';
        }
        return new Response('Showing ' . count($posts) . ' Posts of User ' . ucfirst($user->getName()));
    }

}
