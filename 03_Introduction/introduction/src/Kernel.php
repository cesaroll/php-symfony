<?php

declare(strict_types=1);

namespace App;

use App\Format\BaseFormatInterface;
use App\Format\JSON;
use App\Format\XML;
use App\Annotations\Route;
use Doctrine\Common\Annotations\AnnotationReader;
use ReflectionClass;

class Kernel {

    private Container $container;
    private $routes = [];

    public function __construct()
    {
       $this->container = new Container(); 
    }

    public function getContainer(): Container {
        return $this->container;
    }

    public function boot() {
        $this->bootContainer($this->container); 
    }

    private function bootContainer(Container $container) {
        
        $container->addService('format.json', function() {
            return new JSON();    
        });

        $container->addService('format.xml', function() {
            return new XML();    
        });

        $container->addService('format', function() use ($container) {
            return $container->getService('format.json');
        }, BaseFormatInterface::class);

        $container->loadServices('App\\Service');

        $reader = new AnnotationReader();

        $routes = [];

        $container->loadServices(
            'App\\Controller',
            function (string $serviceName, ReflectionClass $class) use ($reader, &$routes) {
                $route = $reader->getClassAnnotation($class, Route::class);

                if (!$route) {
                    return;
                }

                $baseRoute = $route->route;

                foreach ($class->getMethods() as $method) {
                    $route = $reader->getMethodAnnotation($method, Route::class);

                    if (!$route) {
                        continue;
                    }

                    $routes[str_replace('//', '/', $baseRoute . $route->route)] = [
                        'service' => $serviceName,
                        'method' => $method->getName()  
                    ];
                } 
                
            }
        );

        $this->routes = $routes;
    }

    public function handleRequests() {
        $uri = $_SERVER['REQUEST_URI'];

        if (isset($this->routes[$uri])) {
            $route = $this->routes[$uri];
            $response = $this->container->getService($route['service'])
                                        ->{$route['method']}();
            echo $response;
            die;
        }
    }
}

?>
