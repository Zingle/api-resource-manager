<?php

namespace Zingle\ApiResourceMapper;

use Zingle\ApiResourceMapper\Field\Association;
use Zingle\ApiResourceMapper\Field\DateField;
use Zingle\ApiResourceMapper\Field\Field;

/**
 * Class ModelMeta.
 */
class ModelMeta
{
    /**
     * @var array
     */
    private $definition;

    /**
     * @var Field[]
     */
    private $fields = [];

    /**
     * @var Association[]
     */
    private $associations = [];

    /**
     * @var array
     */
    private $fieldTypes = [
        Field::TYPE => Field::class,
        DateField::TYPE => DateField::class,
    ];

    /**
     * ModelMeta constructor.
     *
     * @param array $definition
     */
    public function __construct(array $definition)
    {
        $this->definition = $definition;

        $this->map();
    }

    /**
     * @param string $fieldOrAssociation
     *
     * @return Association|Field|null
     */
    public function get($fieldOrAssociation)
    {
        if (isset($this->fields[$fieldOrAssociation])) {
            return $this->fields[$fieldOrAssociation];
        } elseif (isset($this->associations[$fieldOrAssociation])) {
            return $this->associations[$fieldOrAssociation];
        }

        return null;
    }

    /**
     * @param string $type
     * @param string $class
     *
     * @return ModelMeta
     */
    public function addFieldType($type, $class): ModelMeta
    {
        $this->fieldTypes[$type] = $class;

        return $this;
    }

    /**
     * Maps processes mapping definition into meta objects.
     */
    private function map()
    {
        if (isset($this->definition['fields'])) {
            foreach ($this->definition['fields'] as $field => $definition) {
                $this->mapField($field, $definition);
            }
        }

        if (isset($this->definition['associations'])) {
            foreach ($this->definition['associations'] as $field => $definition) {
                $this->mapAssociation($field, $definition);
            }
        }
    }

    /**
     * @param string $field
     * @param mixed  $definition
     */
    private function mapField(string $field, $definition)
    {
        if (!is_array($definition)) {
            $definition = [];
        }

        if (!isset($definition['prop'])) {
            $definition['prop'] = $field;
        }

        if (!isset($definition['type'])) {
            $definition['type'] = Field::TYPE;
        }

        $fieldClass = $this->fieldTypes[$definition['type']];
        $this->fields[$field] = new $fieldClass($definition);
    }

    /**
     * @param string $field
     * @param array  $definition
     *
     * @throws MetaException
     */
    private function mapAssociation(string $field, array $definition)
    {
        if (!isset($definition['model'])) {
            throw new MetaException('Missing required model definition');
        }

        if (!isset($definition['prop'])) {
            $definition['prop'] = $field;
        }

        $this->associations[$field] = new Association($definition);
    }
}
