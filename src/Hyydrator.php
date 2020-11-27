<?php

namespace Vague\Hyy;

/**
 * Class Hyydrator
 * @package Vague\Hyy
 */
class Hyydrator
{
    const REGEX_FIELD_NAME = '/([^_]+)_(.+)/i';
    const CONFIG_RELATION_TYPE = 'type';
    const CONFIG_RELATION_CLASS = 'class';
    const TYPE_MULTIPLE = 0;
    const TYPE_SINGLE = 1;
    const GETTERS = [
        self::TYPE_MULTIPLE => 'get%ss',
        self::TYPE_SINGLE => 'get%s',
    ];
    const SETTERS = [
        self::TYPE_MULTIPLE => 'set%ss',
        self::TYPE_SINGLE => 'set%s',
    ];

    /**
     * @param array $rawData
     * @param HydratableInterface $base
     * @param array $configuration
     * @return array
     */
    public function hydrate(array $rawData, HydratableInterface $base, array $configuration): array
    {
        $baseClass = get_class($base);

        $result = [];
        foreach ($rawData as $row) {
            $nativeRow = [];
            $relationsRow = [];
            foreach ($row as $key => $value) {
                if (preg_match(self::REGEX_FIELD_NAME, $key, $m)
                    && array_key_exists($m[1], $configuration)
                ) {
                    $relationsRow[$m[1]][$m[2]] = $value;
                    continue;
                }
                $nativeRow[$key] = $value;
            }

            $hash = md5(implode('', $nativeRow));
            if (!array_key_exists($hash, $result)) {
                $result[$hash] = (new $baseClass)->fromArray($nativeRow);
            }
            $base = $result[$hash];

            foreach ($relationsRow as $key => $value) {
                if ($this->checkEmpty($value)) {
                    continue;
                }

                $hash = md5($key . implode('', $value));

                if (!is_array($configuration[$key])) {
                    $configuration[$key] = [
                        self::CONFIG_RELATION_TYPE => self::TYPE_MULTIPLE,
                        self::CONFIG_RELATION_CLASS => $configuration[$key],
                    ];
                }

                $setMethodName = sprintf(self::SETTERS[$configuration[$key][self::CONFIG_RELATION_TYPE]], ucfirst($key));
                $getMethodName = sprintf(self::GETTERS[$configuration[$key][self::CONFIG_RELATION_TYPE]], ucfirst($key));

                $relationClass = $configuration[$key][self::CONFIG_RELATION_CLASS];

                if ($configuration[$key][self::CONFIG_RELATION_TYPE] === self::TYPE_MULTIPLE) {
                    $existing = call_user_func([$base, $getMethodName]);
                    if (!array_key_exists($hash, $existing)) {
                        $base->$setMethodName(array_merge($existing, [$hash => (new $relationClass)->fromArray($value),]));
                    }
                }

                if ($configuration[$key][self::CONFIG_RELATION_TYPE] === self::TYPE_SINGLE) {
                    $base->$setMethodName((new $relationClass)->fromArray($value));
                }
            }
        }

        return $result;
    }

    /**
     * @param array $data
     * @return bool
     */
    private function checkEmpty(array $data): bool
    {
        foreach ($data as $item) {
            if ($item !== null) {
                return false;
            }
        }

        return true;
    }
}
