<?php

namespace Ramesh\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ramesh\BlogBundle\Document\User;
use Ramesh\BlogBundle\Document\Post;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller {

    public function createAction() {
        $now = date('Y-m-d H:i:s');
        /* $posts = array(
          array('title' => 'Ramesh Post1', 'body' => 'India Won!!!!!!!', 'created_at' => $now, 'by' => 'rameshk@mindfiresolutions.com'),
          array('title' => 'Anoop Post2', 'body' => 'Narendra Modi Won', 'created_at' => $now, 'by' => 'anoopj@mindfiresolutions.com'),
          array('title' => 'Abhilash Post3', 'body' => 'Yo Yo Honey Singh', 'created_at' => $now, 'by' => 'abhilash@gmail.com'),
          array('title' => 'Ramesh Post4', 'body' => 'India Won Again!!!!!!!', 'created_at' => $now, 'by' => 'rameshk@mindfiresolutions.com'),
          array('title' => 'Ansuraj Post5', 'body' => 'Anugular JS !! :)', 'created_at' => $now, 'by' => 'ansuraj@mindfiresolutions.com'),
          ); */
        $posts = array(
            array('title' => 'Ramesh Post6', 'body' => 'India Won!!!!!!!Today', 'created_at' => $now, 'by' => 'rameshk@mindfiresolutions.com'),
            array('title' => 'Anoop Post7', 'body' => 'Narendra Modi Won Today', 'created_at' => $now, 'by' => 'anoopj@mindfiresolutions.com'),
            array('title' => 'Abhilash Post8', 'body' => 'Yo Yo Honey Singh Today', 'created_at' => $now, 'by' => 'abhilash@gmail.com'),
            array('title' => 'Ramesh Post9', 'body' => 'India Won Again!!!!!!! Today', 'created_at' => $now, 'by' => 'rameshk@mindfiresolutions.com'),
            array('title' => 'Ansuraj Post10', 'body' => 'Anugular JS !! :) Today', 'created_at' => $now, 'by' => 'ansuraj@mindfiresolutions.com'),
        );
        $dm = $this->get('doctrine_mongodb')->getManager();
        $userRepo = $this->get('doctrine_mongodb')->getRepository('RameshBlogBundle:User');
        foreach ($posts as $pst) {
            $post = new Post();
            $post->setTitle($pst['title']);
            $post->setBody($pst['body']);
            //$post->setCreatedAt($pst['created_at']);
            $post->setUser($userRepo->findOneByEmail($pst['by']));
            $dm->persist($post);
        }
        $dm->flush();
        return new Response(count($posts) . ' posts created.');
    }

    public function showAllAction() {
        $repository = $this->get('doctrine_mongodb')->getManager()->getRepository('RameshBlogBundle:Post');
        $posts = $repository->findAll();
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
        return new Response('Showing ' . count($posts) . ' Posts.');
    }

    public function showNPostsAction($n) {
        $repository = $this->get('doctrine_mongodb')->getManager()->getRepository('RameshBlogBundle:Post');
        $n = empty($n) ? 5 : $n;
        $posts = $repository->getNPosts($n);
        $count = count($posts);
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
        return new Response("Showing $n Posts.");
    }

    public function translateAction() {
        #$translated = $this->get('translator')->trans('Symfony2 is great');
        $name = 'Ramesh';
        $translated = $this->get('translator')->trans(
            'Hello %name%', array('%name%' => $name)
        );
        /* $translated = $this->get('translator')->transChoice(
          'There is %count% apple|There are %count% apples', 10, array('%count%' => 5)
          ); */
        /* $translated = $this->get('translator')->transChoice(
          '{0} There are no apples|{1} There is one apple|]1,19] There are %count% apples|[20,Inf] There are many apples', 100, array('%count%' => 100)
          ); */
        return new Response($translated);
    }

}
