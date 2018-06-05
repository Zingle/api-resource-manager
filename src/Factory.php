<?php
namespace Zingle\ApiResourceMapper;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\App;
use Symfony\Component\PropertyAccess\PropertyAccess;
use ZingleCom\LaravelModules\Module\ModuleInterface;

class Factory
{
    /**
     * {@inheritdoc}
     */
    public static function bind(App $app, $abstractPrefix, ModuleInterface $module)
    {
        $app->bind($abstractPrefix . '.meta_loader', function (Container $app) use ($module) {
            return new Loader($module->getExtraPath('Resources/config/mapping'));
        });

        $app->bind($abstractPrefix . '.model_meta_factory', function (Container $app) use ($abstractPrefix) {
            return new ModelMetaFactory($app->make($abstractPrefix . '.meta_loader'));
        });
        $app->bind($abstractPrefix . '.mapper', function (Container $app) use ($abstractPrefix) {
            $propertyAccessor = PropertyAccess::createPropertyAccessor();

            return new Mapper(
                $app->make($abstractPrefix . '.model_meta_factory'),
                $propertyAccessor
            );
        });
        $app->alias($abstractPrefix . '.mapper', Mapper::class);
    }
}