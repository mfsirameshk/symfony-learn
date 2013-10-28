<?php

namespace Ramesh\BlogBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DemoControllerTest extends WebTestCase {

    public function testcreateThruFormAction() {
        $client = static::createClient();

        $crawler = $client->request('GET', '/user/create_thru_form');

//        $this->assertGreaterThan(
//            0,
//            $crawler->filter('html:contains("Basic Info")')->count()
//        );
        $form = $crawler->selectButton('user[save]')->form();


// set some values
//        $form['name'] = 'Lucas';
//        $form['form_name[subject]'] = 'Hey there!';
// submit the form
        $crawler = $client->submit($form);
        $this->assertEquals(
            200, $client->getResponse()->getStatusCode()
        );
    }

}
