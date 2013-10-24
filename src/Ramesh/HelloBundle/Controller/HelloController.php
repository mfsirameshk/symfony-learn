<?php

namespace Ramesh\HelloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;


class HelloController extends Controller {
	
	public function indexAction($name) {
			
			return $this->render(
            'RameshHelloBundle:Hello:index.html.twig',
            array('name' => $name)
        );
	}
	
	public function paramCheckAction($last_name, $first_name, $color) {
		var_dump($first_name, $last_name, $color);
		return new Response('In Param Check');
	}
	
	public function requestCheckAction() {
		//check redirection
		$url = $this->generateUrl('hello', array('name' => 'Ramesh'));		
		//return $this->redirect($url);
		
		// check forwarding
		$response = $this->forward('RameshHelloBundle:Hello:index', array(
        'name'  => "Kedlaya"
		));
		return $response;
	}
	
	public function sessionCheckAction() {
		$session = $this->getRequest()->getSession();
		$session->set('name', 'Ramesh');
		echo '<pre>';print_r($_SESSION);
		$name = $session->get('name');
		$foo = $session->get('foo', 'Noooooooooooooooooooooo');
		return new Response($name.' '.$foo);
	}
	
	public function getPostCheckAction($_route, $_controller, $_format = 'html') {
		$request = $this->getRequest();
		var_dump($request->isXmlHttpRequest());
		var_dump($request->query->get('name'));
		var_dump($_route);
		var_dump($_controller);
		return new Response('Done');
	}
	
	public function twigTestAction() {
		$posts = array(array('title' => 'PHP', 'body' => 'I\'m a PHP developer'), array('title' =>'jQuery', 'body' => 'jquery makes javascript easy'));
		return $this->render(
			'RameshHelloBundle:Hello:twigtest.html.twig',
			array('posts' => $posts)
		);
	}
}
