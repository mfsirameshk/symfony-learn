<?php

namespace Ramesh\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ramesh\StoreBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function addAction() {
		$category = new Category();
		$category->setName('Ramesh Design');
		$category->setDescription('Super Cool Designs');

		$em = $this->getDoctrine()->getManager();
		$em->persist($category);
		$em->flush();

		return new Response('Created category id '.$category->getId());
	}
	
	public function showAction() {
		$repository = $this->getDoctrine()->getRepository('RameshStoreBundle:Category');
		$category = $repository->find(1);
		#echo '---------------------------------------------------------------------------<br/><br/>';
		echo 'Found this by find ';
		echo $category->getId(),'-',$category->getName(),'-', $category->getDescription();
		echo '<br/><br/>---------------------------------------------------------------------------<br/><br/>';
		
		$category = $repository->findOneById(3);
		#echo '---------------------------------------------------------------------------<br/><br/>';
		echo 'Found this by findOneById ';
		echo $category->getId(),'-',$category->getName(),'-', $category->getDescription();
		echo '<br/><br/>---------------------------------------------------------------------------<br/><br/>';
		
		$category = $repository->findOneByName('Hardwares');
		#echo '---------------------------------------------------------------------------<br/><br/>';
		echo 'Found this by findOneByName ';
		echo $category->getId(),'-',$category->getName(),'-', $category->getDescription();
		echo '<br/><br/>---------------------------------------------------------------------------<br/><br/>';
		
		$categories = $repository->findAll('Hardwares');
		#echo '---------------------------------------------------------------------------<br/><br/>';
		echo 'Found this by findAll ';
		foreach($categories as $category) {
			echo $category->getId(),'-',$category->getName(),'-', $category->getDescription(), '<br/>';
		}
		echo '<br/><br/>---------------------------------------------------------------------------<br/><br/>';
		
		$categories = $repository->findBy(array('name' => 'Hardwares', 'id' => 4));
		#echo '---------------------------------------------------------------------------<br/><br/>';
		echo 'Found this by findBy Id and Name ';
		foreach($categories as $category) {
			echo $category->getId(),'-',$category->getName(),'-', $category->getDescription(), '<br/>';
		}
		echo '<br/><br/>---------------------------------------------------------------------------<br/><br/>';
		
		return $this->render(
            'RameshHelloBundle:Hello:index.html.twig',
            array('name' => 'Ramesh')
        );
	}
	
	public function updateAction($id) {	
		$em = $this->getDoctrine()->getManager();
		$category = $em->getRepository('RameshStoreBundle:Category')->find($id);

		if (!$category) {
			throw $this->createNotFoundException(
				'No category found for id '.$id
			);
		}

		$category->setDescription('Please update it');
		$em->flush();

		return $this->render(
            'RameshHelloBundle:Hello:index.html.twig',
            array('name' => $id)
        );
	}
	
	public function deleteAction($id) {	
		$em = $this->getDoctrine()->getManager();
		$category = $em->getRepository('RameshStoreBundle:Category')->find($id);

		if (!$category) {
			throw $this->createNotFoundException(
				'No category found for id '.$id
			);
		}

		$em->remove($category);
		$em->flush();

		return $this->render(
            'RameshHelloBundle:Hello:index.html.twig',
            array('name' => $id)
        );
	}
	
	public function queryAction() {
		$em = $this->getDoctrine()->getManager();
		//Normal DQL
		echo 'DQL<br/>';
		$query = $em->createQuery(
			'SELECT c
			FROM RameshStoreBundle:Category c
			WHERE c.name = :name
			ORDER BY c.name ASC'
		)->setParameter('name', 'Softwares');

		$categories = $query->getResult();
		foreach($categories as $category) {
			echo $category->getId(),'-', $category->getName(), '-', $category->getDescription(), '<br/>';
		}
		
		echo '<br/>Doctrine Query Builder<br/>';
		
		$repository = $this->getDoctrine()->getRepository('RameshStoreBundle:Category');

		$query = $repository->createQueryBuilder('c')
			->where('c.name = :name')
			->setParameter('name', 'Hardwares')
			->orderBy('c.name', 'ASC')
			->getQuery();

		$categories = $query->getResult();
		foreach($categories as $category) {
			echo $category->getId(),'-', $category->getName(), '-', $category->getDescription(), '<br/>';
		}
		return $this->render(
            'RameshHelloBundle:Hello:index.html.twig',
            array('name' => 'Query')
        );
	}
	
	public function repoAction() {
		$repository = $this->getDoctrine()->getRepository('RameshStoreBundle:Category');
		$categories = $repository->findAllOrderedByName();
		foreach($categories as $category) {
			echo $category->getId(),'-', $category->getName(), '-', $category->getDescription(), '<br/>';
		}
		return $this->render(
            'RameshHelloBundle:Hello:index.html.twig',
            array('name' => 'Repo')
        );
	}
}
