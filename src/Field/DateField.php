<?php

namespace Zingle\ApiResourceMapper\Field;

/**
 * Class DateField.
 */
class DateField extends AbstractField implements FieldCastsInterface
{
    const TYPE = 'date';

    /**
     * @var string
     */
    private $format = 'Y-m-d';

    /**
     * Field constructor.
     *
     * @param array $definition
     */
    public function __construct(array $definition)
    {
        if (isset($definition['format'])) {
            $this->format = $definition['format'];
        }

        parent::__construct($definition);
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @param mixed $value
     *
     * @return bool|\DateTime
     */
    public function cast($value)
    {
        $value = \DateTime::createFromFormat($this->format, $value);
        if (!$value) {
            throw new CastException(sprintf('Unable to cast "%s" with format "%s".', $value, $this->format));
        }

        return $value;
    }
}
