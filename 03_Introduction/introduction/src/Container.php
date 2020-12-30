<?php
/**
 * @author    Cesar Lopez Lerma <clopezlerma@wayfair.com>
 * @copyright 2020 Wayfair LLC - All rights reserved
 */
declare(strict_types=1);

namespace App;

use Closure;

class Container {
    private array $services = [];

    public function addService(
        string $name,
        Closure $closure
    ): void {
        $this->services[$name] = $closure; 
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

    public function getServices(): array {
        return [
            'services' => array_keys($this->services)  
        ];
    }
}

?>
