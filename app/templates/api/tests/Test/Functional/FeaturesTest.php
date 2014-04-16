<?php

namespace Test\Functional;

use \Slim\Environment;
use \Api\Application;

class FeaturesTest extends \PHPUnit_Framework_TestCase
{
    protected $app;

    public function setUp()
    {
        $_SESSION = array();
        $this->app = new Application();
    }

    public function testIndex()
    {
        Environment::mock(array(
            'PATH_INFO' => '/api/features',
        ));

        $expected = array();
        foreach ($this->app->config['features'] as $id => $feature) {
            $expected[] = array(
                'id' => $id,
                'name' => $feature['name'],
                'href' => './api/features/' . $id,
            );
        }

        $response = $this->app->invoke();
        $this->assertEquals(json_encode($expected), $response->getBody());
        $this->assertEquals(200, $response->getStatus());
    }

    public function testGet()
    {
        $this->assertNotEquals(0, count($this->app->config['features']));
        foreach ($this->app->config['features'] as $id => $feature) {
            $app = new Application();
            Environment::mock(array(
                'PATH_INFO' => '/api/features/' . $id,
            ));
            $response = $app->invoke();
            $this->assertEquals(
                json_encode(array_merge(array('id' => $id), $feature, array('href' => './api/features/' . $id))),
                $response->getBody()
            );
            $this->assertEquals(200, $response->getStatus());
        }
    }

    public function testUnknownFeatureGets404()
    {
        Environment::mock(array(
            'PATH_INFO' => '/api/features/unknown',
        ));
        $response = $this->app->invoke();
        $this->assertEquals(json_encode(array(
            "status" => 404,
            "statusText" => "Not Found",
            "description" => "Resource /api/features/unknown using GET method does not exist.",
        )), $response->getBody());
        $this->assertEquals(404, $response->getStatus());
    }
}
