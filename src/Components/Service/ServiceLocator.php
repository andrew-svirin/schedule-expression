<?php

namespace AndrewSvirin\ScheduleExpression\Components\Service;

use ReflectionClass;
use ReflectionException;
use RuntimeException;

/**
 * Container for internal services.
 * @internal
 */
class ServiceLocator
{
    /**
     * @var array
     */
    private $initializedServices = [];

    /**
     * @param class-string $class
     */
    public function get(string $class)
    {
        if (isset($this->initializedServices[$class])) {
            return $this->initializedServices[$class];
        }

        $this->initializedServices[$class] = $this->initializeService($class);

        return $this->initializedServices[$class];
    }

    /**
     * @param class-string $class
     * @return object new initialized instance
     * @throws RuntimeException
     */
    private function initializeService(string $class)
    {
        try {
            $reflectionClass = new ReflectionClass($class);

            if (null === ($constructor = $reflectionClass->getConstructor())) {
                return $reflectionClass->newInstance();
            }

            if ([] === ($params = $constructor->getParameters())) {
                return $reflectionClass->newInstance();
            }

            $newInstanceParams = [];
            foreach ($params as $param) {
                $newInstanceParams[] = null === $param->getClass() ? $param->getDefaultValue() :
                    $this->initializeService($param->getClass()->getName());
            }

            return $reflectionClass->newInstanceArgs($newInstanceParams);
        } catch (ReflectionException $reflectionException) {
            throw new RuntimeException('Can not initialize service');
        }
    }
}
