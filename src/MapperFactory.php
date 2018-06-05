<?php

namespace Zingle\ApiResourceMapper;

use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class MapperFactory.
 */
class MapperFactory
{
    /**
     * @param ModelMetaFactory $modelMetaFactory
     * @return Mapper
     *
     */
    public function getMapper(ModelMetaFactory $modelMetaFactory)
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        return new Mapper(
            $modelMetaFactory,
            $propertyAccessor
        );
    }
}
