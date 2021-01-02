<?php
/**
 * @author    Cesar Lopez Lerma <clopezlerma@wayfair.com>
 * @copyright 2020 Wayfair LLC - All rights reserved
 */
declare(strict_types=1);

namespace App\Mapper;

use AutoMapperPlus\AutoMapper;

abstract class BaseMapper implements BaseMapperInterface {

    protected AutoMapper $autoMapper;

    public function __construct() {
        $this->setUp();
    }

    abstract protected function setUp(): void;

    public function getAutoMapper(): AutoMapper {
        return $this->autoMapper;
    }

}