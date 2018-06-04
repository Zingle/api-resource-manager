<?php

namespace Zingle\ApiResourceMapper;

/**
 * Class ModelMetaFactory.
 */
class ModelMetaFactory
{
    /**
     * @var Loader
     */
    private $loader;

    /**
     * ModelMeta constructor.
     *
     * @param Loader $loader
     */
    public function __construct(Loader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * @param string $modelClass
     *
     * @return ModelMeta
     *
     * @throws MetaException
     */
    public function getMeta($modelClass)
    {
        $definition = $this->loader->getDefinition($modelClass);
        if (!isset($definition[$modelClass])) {
            throw new MetaException(sprintf('Mapping for "%s" not found.', $modelClass));
        }

        return new ModelMeta($definition[$modelClass]);
    }
}
