<?php

namespace Zingle\ApiResourceMapper\Provider;

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
        return $this;
    }
}
