<?php

namespace Zingle\ApiResourceMapper\Provider;

use Zingle\ApiResourceMapper\MapperFactory;

/**
 * Class ApiResourceMapperProvider
 */
class ApiResourceMapperProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $this->register();
    }

    /**
     * {@inheritdoc}
     */
    public function register(): ApiResourceMapperProvider
    {
        $this->app->singleton('zingle.api_resource_mapper.mapper_factory', function (Container $app) {
            return new MapperFactory();
        });

        $this->app->alias('zingle.api_resource_mapper.mapper_factory', MapperFactory::class);
        return $this;
    }
}
