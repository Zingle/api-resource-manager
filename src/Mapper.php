<?php

namespace Zingle\ApiResourceMapper;

use Symfony\Component\PropertyAccess\Exception\InvalidArgumentException;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Zingle\ApiResourceMapper\Field\Association;
use Zingle\ApiResourceMapper\Field\FieldCastsInterface;

/**
 * Class Mapper.
 */
class Mapper
{
    /**
     * @var ModelMetaFactory
     */
    private $metaFactory;

    /**
     * @var PropertyAccessor
     */
    private $propertyAccessor;

    /**
     * Mapper constructor.
     *
     * @param ModelMetaFactory $factory
     * @param PropertyAccessor $propertyAccessor
     */
    public function __construct(ModelMetaFactory $factory, PropertyAccessor $propertyAccessor)
    {
        $this->metaFactory = $factory;
        $this->propertyAccessor = $propertyAccessor;
    }

    /**
     * @param string $model
     * @param array  $data
     *
     * @return object
     * @throws MetaException
     * @throws \TypeError
     */
    public function map($model, array $data)
    {
        $meta = $this->metaFactory->getMeta($model);

        $model = (new \ReflectionClass($model))->newInstanceWithoutConstructor();
        $reflection = new \ReflectionClass($model);

        foreach ($data as $key => $value) {
            $fieldMeta = $meta->get($key);

            if (!$fieldMeta || $value === null) {
                continue;
            }

            if ($fieldMeta instanceof Association) {
                if ($fieldMeta->isCollection()) {
                    $values = [];
                    foreach ($value as $v) {
                        $values[] = $this->map($fieldMeta->getModel(), $v);
                    }

                    $value = $values;
                } else {
                    $value = $this->map($fieldMeta->getModel(), $value);
                }
            }

            if ($fieldMeta instanceof FieldCastsInterface) {
                $value = $fieldMeta->cast($value);
            }

            try {
                if ($this->propertyAccessor->isWritable($model, $fieldMeta->getProperty())) {
                    $this->propertyAccessor->setValue($model, $fieldMeta->getProperty(), $value);
                } elseif ($reflection->hasProperty($fieldMeta->getProperty())) {
                    $reflectionProperty = $reflection->getProperty($fieldMeta->getProperty());
                    $reflectionProperty->setAccessible(true);
                    $reflectionProperty->setValue($model, $value);
                }
            } catch (InvalidArgumentException $e) {
                // ignore
            }
        }

        return $model;
    }
}
