# API Resource Mapper
The Zingle API Resource Mapper provides helpers for structuring and serializing models and collections returned by 3rd-party APIs

# Installation
Add `zingle/api-resource-mapper` to `composer.json`. Add `ApiResourceMapperProvider` to `config/app.php`

# Usage
For any module requiring resource mapping, add a mapper registration to its service provider:

```php
    private function registerMapper()
    {
        $this->app->bind('zingle.foo_module.meta_loader', function (Container $app) {
            /** @var Module $module */
            $module = $app->make('laravel_modules.repository')->find('FooModule');

            return new Loader($module->getExtraPath('Resources/config/mapping'));
        });
        $this->app->bind('zingle.foo_module.model_meta_factory', function (Container $app) {
            return new ModelMetaFactory($app->make('zingle.foo_module.meta_loader'));
        });
        $this->app->bind('zingle.foo_module.mapper', function (Container $app) {
            $propertyAccessor = PropertyAccess::createPropertyAccessor();

            return new Mapper(
                $app->make('zingle.foo_module.model_meta_factory'),
                $propertyAccessor
            );
        });
        $this->app->alias('zingle.foo_module.mapper', Mapper::class);

        return $this;
    }
```