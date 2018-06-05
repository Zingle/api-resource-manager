# API Resource Mapper
The Zingle API Resource Mapper provides helpers for structuring and serializing models and collections returned by 3rd-party APIs

# Installation
Add `zingle/api-resource-mapper` to `composer.json`

# Usage
For any module requiring resource mapping, add the following to the service provider's `register` method:

```php
$abstractPrefix = "foo.bar";
$module = $this->app->make('laravel_modules.repository')->find('MyModule');
Factory::bind($this->app, $abstractPrefix, $module);
```

This will create bindings for `foo.bar.meta_loader`, `foo.bar.model_meta_factory` and `foo.bar.mapper` 
using the mappings in the `Resources/config/mapping` directory of `MyModule`