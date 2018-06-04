<?php

namespace Zingle\ApiResourceMapper;

use Symfony\Component\Yaml\Yaml;

/**
 * Class Loader.
 */
class Loader
{
    /**
     * @var string
     */
    private $basePath;

    /**
     * Loader constructor.
     *
     * @param string $basePath
     */
    public function __construct($basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * @param string $modelClass
     *
     * @return mixed
     *
     * @throws MetaException
     */
    public function getDefinition($modelClass)
    {
        $class = substr($modelClass, strrpos($modelClass, '\\') + 1);

        $path = sprintf('%s/%s.yml', $this->basePath, $class);
        if (!file_exists($path)) {
            throw new MetaException(sprintf('Missing definition for class "%s".', $modelClass));
        }

        return Yaml::parse(file_get_contents($path));
    }
}
