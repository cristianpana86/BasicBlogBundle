<?php

namespace CPANA\BasicBlogBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BlogControllerTest extends WebTestCase
{
    public function testBlogHome()
    {
        $client = static::createClient();
		$client->request('GET', '/blog');
		//var_dump($client->getResponse()->getContent());
		
		$crawler = $client->request('GET', '/blog');
	    $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Blog")')->count()
        );
    }
	 public function testShow()
    {
        $client = static::createClient();
		$client->request('GET', '/blog');
		//var_dump($client->getResponse()->getContent());
		
		$crawler = $client->request('GET', '/blog');
	    $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Blog")')->count()
        );
    }
}
