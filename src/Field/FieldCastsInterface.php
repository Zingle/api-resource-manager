<?php

namespace Zingle\ApiResourceMapper\Field;

/**
 * Interface FieldCastsInterface.
 */
interface FieldCastsInterface
{
    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function cast($value);
}
