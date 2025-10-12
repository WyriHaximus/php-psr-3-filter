<?php

declare(strict_types=1);

namespace WyriHaximus\PSR3\Filter;

use function array_key_exists;
use function count;
use function is_array;

trait GetFieldTrait
{
    /**
     * @param array<string, mixed> $array
     * @param array<string>        $keys
     */
    final protected static function getField(array $array, array $keys): mixed
    {
        if (count($keys) === 0) {
            return null;
        }

        // This is a micro-optimization, it is fast for non-nested keys, but fails for null values
        if (count($keys) === 1 && array_key_exists($keys[0], $array)) {
            return $array[$keys[0]];
        }

        $current = $array;
        foreach ($keys as $key) {
            if (! is_array($current) || ! array_key_exists($key, $current)) {
                return null;
            }

            $current = $current[$key];
        }

        return $current;
    }
}
