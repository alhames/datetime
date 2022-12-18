<?php

use Alhames\DateTime\DT;

if (!function_exists('dt')) {
    /**
     * @param string|int|\DateTimeInterface|null $value
     */
    function dt($value = null): DT
    {
        if (null === $value) {
            return new DT();
        }

        if ($value instanceof DT) {
            return $value;
        }

        if ($value instanceof \DateTimeInterface) {
            return new DT($value->format('Y-m-d H:i:s.u'), $value->getTimezone());
        }

        if (is_int($value)) {
            return DT::createFromTimestamp($value);
        }

        if (!is_string($value)) {
            throw new \InvalidArgumentException('Date must be string, integer or DateTimeInterface.');
        }

        if (ctype_digit($value)) {
            return DT::createFromTimestamp((int) $value);
        }

        return new DT($value);
    }
}
