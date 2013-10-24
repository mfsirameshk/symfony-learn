<?php

namespace Ramesh\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('RameshStoreBundle:Default:index.html.twig', array('name' => $name));
    }
}
