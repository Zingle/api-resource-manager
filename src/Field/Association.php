<?php

namespace Zingle\ApiResourceMapper\Field;

/**
 * Class Association.
 */
class Association extends AbstractField
{
    const SINGLE_TYPE = 'single';
    const COLLECTION_TYPE = 'collection';

    /**
     * @var string
     */
    private $model;

    /**
     * @var string
     */
    private $type = self::SINGLE_TYPE;

    /**
     * Association constructor.
     *
     * @param array $definition
     */
    public function __construct(array $definition)
    {
        $this->model = $definition['model'];

        if (isset($definition['type'])) {
            $this->type = $definition['type'];
        }

        parent::__construct($definition);
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isCollection()
    {
        return self::COLLECTION_TYPE === $this->type;
    }
}
