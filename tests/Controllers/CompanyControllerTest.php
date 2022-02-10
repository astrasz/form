<?php

namespace App\Tests\Controllers;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CompanyControllerTest extends WebTestCase
{
    public function testindexResponse(): void
    {

        $client = static::createClient();
        $crawler= $client->request(
            'GET', 
            '/company/'
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $client2 = static::createClient();
        $crawler2= $client2->request(
            'POST', 
            '/company/'
        );


        $this->assertFalse(200 === $client2->getResponse()->getStatusCode());
        
    }


    public function testNewContent(): void
    {
        $client = static::createClient();

        $crawler = $client->request(
            'GET',  '/company/new'
        );
        $this->assertSame(1, $crawler->filter('ul.companies')->count());

    }



    public function testAddCompany(): void
    {


        $client = static::createClient();

        $crawler = $client->request(
            'GET',
            '/company/new'
        );

        $form = $crawler->selectButton('Dodaj kolejną')->form();

        $form['user[email]'] = 'zawisza@czarny.pl';
        $form['user[pesel]'] = 22050514785;
        $form['user[firstname]'] = 'Zawisza';
        $form['user[lastname]'] = 'Czarny';
        $form['user[companies][0][nip]'] = 2563147852;
        $form['user[companies][0][name]'] = 'Stowarzyszenie Rycerzy Do Ścigania Krzyżaków';
        $form['user[companies][0][house_nr]'] = 25;
        $form['user[companies][0][postcode]'] = '22-033';
        $form['user[companies][0][place]'] = 'Kraków';
        $form['user[companies][0][phone]'] = 123654789;
        $form['user[companies][0][email]'] = 'zawisza@czarny.pl';

        $crawler = $client->submit($form);


        $this->assertStringContainsString(
    	    'Ścigania Krzyżaków',
    	    $client->getResponse()->getContent()
	);


    }


}
