<?php

namespace NewsletterBundle\Tests\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
#use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class NewsletterControllerTest extends WebTestCase
{
    private $em;

    public function getFirstArticleId($client):int
    {
        $client->request(Request::METHOD_GET, '/api/articles');

        $responseContent = $client->getResponse()->getContent();
        $this->assertStatusCode(Response::HTTP_OK, $client);

        $this->assertJson($responseContent);

        $data = json_decode($responseContent, true);

        $firstArticle = array_pop($data);
        $firstArticleId = $firstArticle['id'];

        return $firstArticleId;
    }

    protected function setUp()
    {
        parent::setUp();

        self::bootKernel();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->loadFixtures(
            array(
                'NewsletterBundle\DataFixtures\ORM\LoadArticlesTestData',

            )
        );
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null;
    }

    public function testGetArticles()
    {

        $client = $this->makeClient();
        $client->request(Request::METHOD_GET, '/api/articles');

        $responseContent = $client->getResponse()->getContent();
        $this->assertStatusCode(Response::HTTP_OK, $client);

        $this->assertJson($responseContent);

        $data = json_decode($responseContent, true);

        $firstArticle = array_pop($data);

        $this->assertArrayHasKey('body', $firstArticle);
        $this->assertArrayHasKey('title', $firstArticle);
        $this->assertArrayHasKey('id', $firstArticle);

        $this->assertEquals("test body", $firstArticle['body']);
        $this->assertEquals("test title", $firstArticle['title']);

    }

    public function testPostArticleValidData()
    {
        $requestData = array(
            'body' => 'post test body',
            'title' => 'post test title',
        );

        $client = $this->makeClient();

       $client->request(
            Request::METHOD_POST,
            '/api/articles',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($requestData)
        );

        $responseContent = $client->getResponse()->getContent();

        $this->assertStatusCode(Response::HTTP_CREATED, $client);

        $this->assertJson($responseContent);

        $responseData = json_decode($responseContent, true);

        $this->assertArrayHasKey('body', $responseData);
        $this->assertArrayHasKey('title', $responseData);
        $this->assertArrayHasKey('id', $responseData);

        $this->assertEquals($requestData['body'], $responseData ['body']);
        $this->assertEquals($requestData['title'], $responseData ['title']);
    }

    public function testPostArticleInvalidData()
    {
        $requestData = array(
            'body' => 'post test body'
        );

        $client = $this->makeClient();

        $client->request(
            Request::METHOD_POST,
            '/api/articles',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($requestData)
        );

        $responseContent = $client->getResponse()->getContent();

        $this->assertStatusCode(Response::HTTP_BAD_REQUEST, $client);
        $this->assertJson($responseContent);

    }

    public function testPutArticleValidData()
    {
        $client = $this->makeClient();
        $firstArticleId = $this->getFirstArticleId($client);

        $requestData = array(
            'body' => 'post test changed',
            'title' => 'post test changed',
        );

        $client->request(
            Request::METHOD_PUT,
            '/api/articles/'.$firstArticleId,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($requestData)
        );

        $responseContent = $client->getResponse()->getContent();

        $this->assertStatusCode(Response::HTTP_OK, $client);

        $this->assertJson($responseContent);

        $responseData = json_decode($responseContent, true);

        $this->assertArrayHasKey('body', $responseData);
        $this->assertArrayHasKey('title', $responseData);
        $this->assertArrayHasKey('id', $responseData);

        $this->assertEquals($requestData['body'], $responseData ['body']);
        $this->assertEquals($requestData['title'], $responseData ['title']);
    }

    public function testPutArticleInvalidData()
    {
        $client = $this->makeClient();
        $firstArticleId = $this->getFirstArticleId($client);

        $requestData = array(
            'body' => 'post test changed'
        );

        $client->request(
            Request::METHOD_PUT,
            '/api/articles/'.$firstArticleId,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($requestData)
        );

        $responseContent = $client->getResponse()->getContent();

        $this->assertStatusCode(Response::HTTP_BAD_REQUEST, $client);

        $this->assertJson($responseContent);


    }

    public function testPutArticleNotFoundData()
    {
        $client = $this->makeClient();

        $requestData = array(
            'body' => 'post test changed',
            'title' => 'post test changed',
        );

        $client->request(
            Request::METHOD_PUT,
            '/api/articles/0',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($requestData)
        );

        $responseContent = $client->getResponse()->getContent();

        $this->assertStatusCode(Response::HTTP_NOT_FOUND, $client);
        $this->assertJson($responseContent);

    }
}


