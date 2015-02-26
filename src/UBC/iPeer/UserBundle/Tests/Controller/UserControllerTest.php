<?php

namespace UBC\iPeer\UserBundle\Tests\Controller;


use Liip\FunctionalTestBundle\Test\WebTestCase;
use UBC\iPeer\UserBundle\DataFixtures\ORM\LoadUserData;

class UserControllerTest extends WebTestCase
{

    public function setUp(){
        $this->client = static::createClient();
    }

    protected function assertJsonResponse($response, $statusCode = 200) {
        $this->assertEquals(
            $statusCode, $response->getStatusCode(),
            $response->getContent()
        );
        $this->assertTrue(
            $response->headers->contains('Content-Type', 'application/json'),
            $response->headers
        );
    }

    public function testIndexActionEmpty() {
        $this->loadFixtures(array());
        $route =  $this->getUrl('user');
        $this->client->request('GET', $route, array('ACCEPT' => 'application/json'));
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response);

        $this->assertCount(0, json_decode($response->getContent(), true)["users"]);

    }

    public function testIndexAction() {
        $fixtures = array('UBC\iPeer\UserBundle\DataFixtures\ORM\LoadUserData');
        $this->loadFixtures($fixtures);

        $route =  $this->getUrl('user');
        $this->client->request('GET', $route, array('ACCEPT' => 'application/json'));
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response);

        $this->assertCount(3, json_decode($response->getContent(), true)["users"]);
    }

    public function testCreateAction() {
        $this->loadFixtures(array());

        $route =  $this->getUrl('user');

        $this->client->request('POST', $route, array('ACCEPT' => 'application/json'), array(), array(),
            '{"first_name": "Test User", "last_name": "Action Test", "email": "testcreateaction@ipeer.ubc"}');
        $response = $this->client->getResponse();
        $this->assertJsonResponse($response);
        $data = json_decode($response->getContent(), true)['user'];
        $this->assertEquals(1, $data['id']);
        $this->assertEquals("Test User", $data['first_name']);
        $this->assertEquals("Action Test", $data['last_name']);
        $this->assertEquals("testcreateaction@ipeer.ubc", $data['email']);

        $this->client->request('POST', $route, array('ACCEPT' => 'application/json'), array(), array(),
            '{"first_name": "Test2", "last_name": "ActionTwo", "email": "testcreateaction2@ipeer.ubc"}');
        $response = $this->client->getResponse();
        $this->assertJsonResponse($response);
        $data = json_decode($response->getContent(), true)['user'];
        $this->assertEquals(2, $data['id']);
        $this->assertEquals("Test2", $data['first_name']);
        $this->assertEquals("ActionTwo", $data['last_name']);
        $this->assertEquals("testcreateaction2@ipeer.ubc", $data['email']);


        $route =  $this->getUrl('user');
        $this->client->request('GET', $route, array('ACCEPT' => 'application/json'));
        $response = $this->client->getResponse();
        $this->assertJsonResponse($response);
        $this->assertCount(2, json_decode($response->getContent(), true)["users"]);
    }

    public function testShowAction() {
        $fixtures = array('UBC\iPeer\UserBundle\DataFixtures\ORM\LoadUserData');
        $this->loadFixtures($fixtures);


        for($i = 1; $i <= count(LoadUserData::$users); $i++) {
            $route =  $this->getUrl('user_show', array('id' => $i));
            $this->client->request('GET', $route, array('ACCEPT' => 'application/json'));
            $response = $this->client->getResponse();
            $this->assertJsonResponse($response);

            $data = json_decode($response->getContent(), true)['user'];
            $this->assertEquals(LoadUserData::$users[$i-1]->getFirstName(), $data['first_name']);
            $this->assertEquals(LoadUserData::$users[$i-1]->getLastName(), $data['last_name']);
            $this->assertEquals(LoadUserData::$users[$i-1]->getEmail(), $data['email']);
        }
    }

    public function testUpdateAction() {
        $fixtures = array('UBC\iPeer\UserBundle\DataFixtures\ORM\LoadUserData');
        $this->loadFixtures($fixtures);

        $route =  $this->getUrl('user_update', array('id' => 1));
        $this->client->request('POST', $route, array('ACCEPT' => 'application/json'), array(), array(),
            '{"id": 1, "first_name": "Test User", "last_name": "Action Test", "email": "testcreateaction@ipeer.ubc"}');
        $this->client->request('POST', $route, array('ACCEPT' => 'application/json'), array(), array(),
            '{"id": 2, "first_name": "Test2", "last_name": "ActionTwo", "email": "testcreateaction2@ipeer.ubc"}');
        $this->client->request('POST', $route, array('ACCEPT' => 'application/json'), array(), array(),
            '{"id": 3, "first_name": "Test3", "last_name": "ActionThree", "email": "testcreateaction3@ipeer.ubc"}');

        $route =  $this->getUrl('user');
        $this->client->request('GET', $route, array('ACCEPT' => 'application/json'));
        $response = $this->client->getResponse();
        $this->assertJsonResponse($response);
        $data = json_decode($response->getContent(), true)["users"];
        $this->assertCount(3, $data);


    }

    public function testDeleteAction() {

    }

}
