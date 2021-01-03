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

    public function toBlogPost(BlogPostModel $model): BlogPost {
        return $this->getAutoMapper()->map($model, BlogPost::class);
    }

    public function toBlogPostModel(BlogPost $entity): BlogPostModel {
        return $this->getAutoMapper()->map($entity, BlogPostModel::class);
    }

}