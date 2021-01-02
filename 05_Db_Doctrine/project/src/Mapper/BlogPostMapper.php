<?php
/**
 * @author    Cesar Lopez Lerma <clopezlerma@wayfair.com>
 * @copyright 2020 Wayfair LLC - All rights reserved
 */
declare(strict_types=1);

namespace App\Mapper;

use App\Entity\BlogPost;
use App\Model\BlogPostModel;
use AutoMapperPlus\AutoMapper;
use AutoMapperPlus\Configuration\AutoMapperConfig;

class BlogPostMapper extends BaseMapper {

    protected function setUp(): void {
        $config = new AutoMapperConfig();
        $config->registerMapping(BlogPostModel::class, BlogPost::class)
            ->reverseMap();

        $this->autoMapper = new AutoMapper($config);
    }

}