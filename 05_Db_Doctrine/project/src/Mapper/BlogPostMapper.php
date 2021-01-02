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

class BlogPostMapper {

    private AutoMapper $autoMapper;

    /**
     * BlogPostMapper constructor.
     *
     */
    public function __construct() {
        $this->setUp();
    }

    private function setUp(): void {
        $config = new AutoMapperConfig();
        $config->registerMapping(BlogPostModel::class, BlogPost::class)
            ->reverseMap();

        $this->autoMapper = new AutoMapper($config);
    }

    /**
     * @return AutoMapper
     */
    public function getAutoMapper(): AutoMapper {
        return $this->autoMapper;
    }

}