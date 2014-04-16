<?php

namespace Test\Functional;

use \Slim\Environment;
use \Api\Application;
use \Exception;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $_SESSION = array();
    }

    /**
     * @expectedException Exception
     */
    public function testMissingConfigurationDirectoryGeneratesException()
    {
        new Application(array(), 'missingConfigDirectory');
    }

    public function testHttpExceptionGenerates500()
    {
        $app = new Application();
        $app->get('/api/test/http-exception', function () {
            throw new Exception('HTTP exception', 406);
        });

        Environment::mock(array(
            'PATH_INFO' => '/api/test/http-exception',
        ));
        $response = $app->invoke();
        $this->assertEquals(json_encode(array(
            'status' => 406,
            'statusText' => 'Not Acceptable',
            'description' => 'HTTP exception',
        )), $response->getBody());
        $this->assertEquals(406, $response->getStatus());
    }

    public function testUndefinedExceptionGenerates500()
    {
        $app = new Application();
        $app->get('/api/test/undefined-exception', function () {
            throw new Exception('Undefined exception');
        });

        Environment::mock(array(
            'PATH_INFO' => '/api/test/undefined-exception',
        ));
        $response = $app->invoke();
        $this->assertEquals(json_encode(array(
            'status' => 500,
            'statusText' => 'Internal Server Error',
            'description' => 'Undefined exception',
        )), $response->getBody());
        $this->assertEquals(500, $response->getStatus());
    }

    public function testUnkownHttpStatusExceptionGenerates500()
    {
        $app = new Application();
        $app->get('/api/test/undefined-exception', function () {
            throw new Exception('Exception with unknown HTTP status', 999);
        });

        Environment::mock(array(
            'PATH_INFO' => '/api/test/undefined-exception',
        ));
        $response = $app->invoke();
        $this->assertEquals(json_encode(array(
            'status' => 500,
            'statusText' => 'Internal Server Error',
            'description' => 'Exception with unknown HTTP status',
        )), $response->getBody());
        $this->assertEquals(500, $response->getStatus());
    }
}
