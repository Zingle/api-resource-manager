<?php

namespace Zingle\ApiResourceMapper\Field;

/**
 * Class AbstractField.
 */
abstract class AbstractField
{
    /**
     * @var string
     */
    private $property;

    /**
     * Field constructor.
     *
     * @param array $definition
     */
    public function __construct(array $definition)
    {
        $this->property = $definition['prop'];
    }

    /**
     * @return string
     */
    public function getProperty(): string
    {
        return $this->property;
    }
}
