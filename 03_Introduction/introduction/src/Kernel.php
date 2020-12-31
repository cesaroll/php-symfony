<?php

declare(strict_types=1);

namespace App;

use App\Format\BaseFormatInterface;
use App\Format\JSON;
use App\Format\XML;

class Kernel {

    private Container $container;

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
        $container->loadServices('App\\Controller');
    }
}

?>
