<?php
/**
 * @author    Cesar Lopez Lerma <clopezlerma@wayfair.com>
 * @copyright 2020 Wayfair LLC - All rights reserved
 */
declare(strict_types=1);

namespace App;

use Closure;
use ReflectionClass;

class Container {
    private array $services = [];
    private array $aliases = [];

    public function addService(
        string $name,
        Closure $closure,
        ?string $alias = null
    ): void {
        $this->services[$name] = $closure; 

        if ($alias) {
            $this->addAlias($alias, $name);
        }
    }

    public function hasService(string $name): bool {
        return isset($this->services[$name]);
    }

    public function getService(string $name) {
        if (!$this->hasService($name)) {
            return null;
        }

        if ($this->services[$name] instanceof Closure) {
            $this->services[$name] = $this->services[$name]();
        }

        return $this->services[$name];
    }

    public function addAlias(string $alias, string $service): void {
       $this->aliases[$alias] = $service; 
    }

    public function hasAlias(string $alias): bool {
        return isset($this->aliases[$alias]);
    }

    public function getAlias(string $name) {
        return $this->getService($this->aliases[$name]);
    }

    public function getServices(): array {
        return [
            'services' => array_keys($this->services),
            'aliases' => $this->aliases
        ];
    }

    public function loadServices(string $namespace): void {
        $baseDir = __DIR__ . '/';
        $actualDirectory = str_replace('\\', '/', $namespace);
        $actualDirectory = $baseDir . mb_substr($actualDirectory, mb_strpos($actualDirectory, '/') + 1);
        
        $files = array_filter(scandir($actualDirectory), function($file) {
            return $file !== '.' && $file !== '..'; 
        });

        foreach ($files as $file) {
            $class = new ReflectionClass($namespace . '\\' . basename($file, '.php'));
            $serviceName = $class->getName();

            $constructor = $class->getConstructor();
            $arguments = $constructor->getParameters();

            // Parameters to inject into service constructor
            $serviceParameters = [];

            foreach ($arguments as $argument) {
                $type = (string)$argument->getType();

                if ($this->hasService($type) || $this->hasAlias($type)) {
                    $serviceParameters[] = $this->getService($type) ?? $this->getAlias($type);
                } else {
                    $serviceParameters[] = function() use ($type) {
                        return $this->getService($type) ?? $this->getAlias($type);
                    }; 
                }
            }

            $this->addService($serviceName, function () use ($serviceName, $serviceParameters) {
                foreach ($serviceParameters as $serviceParameter) {
                    if ($serviceParameter instanceof Closure) {
                        $serviceParameter = $serviceParameter();
                    }
                }
                return new $serviceName(...$serviceParameters);
            });
        }
    }
}

?>
