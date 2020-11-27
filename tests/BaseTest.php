<?php

namespace Vague\Hyy\Test;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use ReflectionProperty;

/**
 * Class Test
 * @package VagueSoftware\CakeTravel\Tests
 */
abstract class BaseTest extends TestCase
{
    const VALUE_ID = 1;
    const VALUE_LOCALE_ID = '1';

    /**
     * @param $class
     * @param $property
     * @return ReflectionProperty
     * @throws ReflectionException
     */
    protected function getPrivateProperty($class, $property)
    {
        $class = is_string($class) ? $class : get_class($class);
        $reflector = new \ReflectionClass($class);
        if (!$reflector->hasProperty($property) &&
            $reflector->getParentClass() &&
            $reflector->getParentClass()->hasProperty($property)
        ) {
            $reflector = $reflector->getParentClass();
        }
        $property = $reflector->getProperty($property);
        $property->setAccessible(true);

        return $property;
    }

    /**
     * @param $class
     * @param $property
     * @param $value
     * @return $this
     * @throws ReflectionException
     */
    protected function setPrivateProperty($class, $property, $value)
    {
        $property = $this->getPrivateProperty($class, $property);
        $property->setValue($class, $value);
        return $this;
    }

    /**
     * @param $className
     * @param array $methods
     * @return MockObject
     */
    protected function getClassMock($className, array $methods = [])
    {
        return $this->getMockBuilder($className)
            ->disableOriginalConstructor()
            ->setMethods($methods)
            ->getMock();
    }
}
