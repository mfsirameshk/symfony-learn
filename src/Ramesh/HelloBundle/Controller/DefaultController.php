<?php

namespace Ramesh\HelloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('RameshHelloBundle:Default:index.html.twig', array('name' => $name));
    }
}
