<?php

namespace Ramesh\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ramesh\StoreBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function addAction() {
		$products = array(
			array('name' => 'Samsung Galaxy s3', 'price' => 20000, 'description' => 'Best SmartPhone ever', 'category' => 'Hardwares'),
			array('name' => 'Avast Antivirus', 'price' => 1300, 'description' => 'Best Antivirus ever', 'category' => 'Softwares'),
			array('name' => '4 Pics 1 Word', 'price' => 0, 'description' => 'Best Game ever', 'category' => 'Softwares'),
			array('name' => 'iPad Case', 'price' => 1400, 'description' => 'Best case ever for ipad', 'category' => 'Hardwares'),
		);
		$em = $this->getDoctrine()->getManager();
		foreach($products as $prod) {
			$product = new Product();
			$product->setName($prod['name']);
			$product->setPrice($prod['price']);
			$product->setDescription($prod['description']);
			$category = $this->getDoctrine()->getRepository('RameshStoreBundle:Category')->findOneByName($prod['category']);
			$product->setCategory($category);
			$em->persist($product);
		}
		$em->flush();

		return new Response('Done');
	}
	
	public function showAction() {
		$repository = $this->getDoctrine()->getRepository('RameshStoreBundle:Product');
		$products = $repository->findAll();
		foreach($products as $product) {
			echo 'Name: ', $product->getName(), '<br/>';
			echo 'Price: ', $product->getPrice(), '<br/>';
			echo 'Description: ', $product->getDescription(), '<br/>';
			echo 'Category: ', $product->getCategory()->getName(), '<br/>';
			echo '-----------------------------------------------------<br/>';
		}
		return new Response('Done');
	}
	
	public function joinAction() {
		$repository = $this->getDoctrine()->getRepository('RameshStoreBundle:Product');
		$products = $repository->findJoinedToCategory();
		foreach($products as $product) {
			echo 'Name: ', $product->getName(), '<br/>';
			echo 'Price: ', $product->getPrice(), '<br/>';
			echo 'Description: ', $product->getDescription(), '<br/>';
			echo 'Category: ', $product->getCategory()->getName(), '<br/>';
			echo '-----------------------------------------------------<br/>';
		}
		return new Response('Done');
	}
}
