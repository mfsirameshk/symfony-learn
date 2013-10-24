<?php

namespace Ramesh\MyPropelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ramesh\MyPropelBundle\Model\Product;
use Ramesh\MyPropelBundle\Model\Category;
use Ramesh\MyPropelBundle\Model\ProductQuery;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('RameshMyPropelBundle:Default:index.html.twig', array('name' => $name));
    }
    
	public function createAction()
	{
		$product = new Product();
		$product->setName('GudBud');
		$product->setPrice(60);
		$product->setDescription('Mix of flavors');

		$product->save();

		return new Response('Created product id '.$product->getId());
	}
	
	public function showAction($id)
	{
		$product = ProductQuery::create()
			->findPk($id);

		if (!$product) {
			throw $this->createNotFoundException(
				'No product found for id '.$id
			);
		}
		
		echo 'Name: ', $product->getName(), '<br/>';
		echo 'Price: ', $product->getPrice(), '<br/>';
		echo 'Description: ', $product->getDescription(), '<br/>';
		echo '-----------------------------------------------------<br/>';
		return new Response('Showing product id '.$product->getId());
		
	}
	
	public function updateAction($id, $action)
	{
		$product = ProductQuery::create()
			->findPk($id);

		if (!$product) {
			throw $this->createNotFoundException(
				'No product found for id '.$id
			);
		}
		
		if($action == 'update') {
			$product->setName($product->getName().' updated');
			$product->save();
		} else {
			$product->delete();
		}
		return new Response($action);
	}
	
	public function queryAction() {
		$products = ProductQuery::create()
					->filterByPrice(array('min' => 4))
					->orderByPrice()
					->find();
		foreach($products as $product) {
			echo 'Name: ', $product->getName(), '<br/>';
			echo 'Price: ', $product->getPrice(), '<br/>';
			echo 'Description: ', $product->getDescription(), '<br/>';
			echo '-----------------------------------------------------<br/>';
		}
		return new Response('Query');
	}
	
	public function prodwithcatAction() {
	    $category = new Category();
        $category->setName('IceCreams');

        $product = new Product();
        $product->setName('ButterScotch');
        $product->setPrice(50);
        // relate this product to the category
        $product->setCategory($category);

        // save the whole
        $product->save();

        return new Response(
            'Created product id: '.$product->getId().' and category id: '.$category->getId()
        );
	}
	
	public function showProdWithCatAction() {
		$id = 4;
		$product = ProductQuery::create()
        ->joinWithCategory()
        ->findPk($id);

		$categoryName = $product->getCategory()->getName();
		$productName = $product->getName();
		$price = $product->getPrice();
		var_dump($categoryName, $productName, $price);
		return new Response('showing');
	}
}
