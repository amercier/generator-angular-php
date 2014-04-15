<?php
error_reporting(E_ALL);
try {

    // Dependencies
    if (!file_exists($autoload = __DIR__ . '/vendor/autoload.php')) {
        throw new \Exception('Composer dependencies not installed. Run `make install --directory app/api`', 500);
    }
    require_once $autoload;


    // Slim Framework initialization
    if (!class_exists('\\Slim\\Slim')) {
        throw new \Exception(
            'Missing Slim from Composer dependencies.'
            . ' Ensure slim/slim is in composer.json and run `make update --directory app/api`',
            500
        );
    }
    $app = new \Slim\Slim();

    $app->error(function (\Exception $e) {
        $app->response->setBody(json_encode(array(
            'message' => $e->getMessage(),
            'type' => get_class($e),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'type' => get_class($e),
            'trace' => $e->getTrace(),
        )));
    });

    $app->notFound(function () use ($app) {
        $app->response->setBody(json_encode(array(
            'message' => 'Resource not found'
        )));
    });


    // Application-specific code starts here

    $app->features = array(
        'html5-boilerplate' => array(
            'name' => 'HTML5 Boilerplate',
            'description' => 'HTML5 Boilerplate is a professional front-end template'
                . ' for building fast, robust, and adaptable web apps or sites.',
        ),
        'angular' => array(
            'name' => 'Angular',
            'description' => 'AngularJS is a toolset for building the framework most'
                . ' suited to your application development.',
        ),
        'karma' => array(
            'name' => 'Karma',
            'description' => 'Spectacular Test Runner for JavaScript.',
        ),
    );

    $app->get('/api/features', function () use ($app) {
        $features = array();
        foreach ($app->features as $id => $feature) {
            $features[] = array(
                'id' => $id,
                'name' => $feature['name'],
                'href' => '/api/features/' . $id,
            );
        }
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setBody(json_encode($features));
    });

    $app->get('/api/features/:id', function ($id) use ($app) {
        if (!array_key_exists($id, $app->features)) {
            return $app->notFound();
        }
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setBody(json_encode(array_merge(
            array('id' => $id),
            $app->features[$id]
        )));
    });


    // Response

    // $app->response->headers->set('Content-Type', 'application/json');
    $app->run();

} catch (\Exception $e) {
    http_response_code($e->getCode() === 0 ? 500 : $e->getCode());
    header('Content-Type: application/json');
    echo json_encode(array(
        'message' => $e->getMessage(),
        'type' => get_class($e),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'type' => get_class($e),
        'trace' => $e->getTrace(),
    ));
}
