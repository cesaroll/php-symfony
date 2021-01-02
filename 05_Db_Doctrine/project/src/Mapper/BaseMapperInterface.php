<?php
/**
 * @author    Cesar Lopez Lerma <clopezlerma@wayfair.com>
 * @copyright 2020 Wayfair LLC - All rights reserved
 */
declare(strict_types=1);

namespace App\Mapper;

use AutoMapperPlus\AutoMapper;

interface BaseMapperInterface {
    public function getAutoMapper(): AutoMapper;
}