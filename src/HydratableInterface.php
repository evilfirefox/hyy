<?php

namespace Vague\Hyy;

/**
 * Interface HydratableInterface
 * @package Vague\Hyy
 */
interface HydratableInterface
{
    /**
     * @return array
     */
    public function toArray(): array;

    /**
     * @param array $rawData
     * @return HydratableInterface
     */
    public function fromArray(array $rawData): HydratableInterface;
}
