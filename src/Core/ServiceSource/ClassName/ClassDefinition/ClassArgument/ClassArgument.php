<?php

/*
 * ClassArgument.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2024 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Core\ServiceSource\ClassName\ClassDefinition\ClassArgument;

use Kocuj\Di\Core\ServiceSource\Exception;

/**
 * @package Kocuj\Di\ServiceSource\ClassData\ClassDefinition
 */
class ClassArgument
{
    private ArgumentType $argumentType;

    private ?string $serviceId;

    /**
     * @var mixed|null
     */
    private $argumentValue;

    /**
     * @param mixed|null $argumentValue
     */
    public function __construct(ArgumentType $argumentType, ?string $serviceId = null, $argumentValue = null)
    {
        switch ($argumentType->getValue()) {
            case ArgumentType::SERVICE:
                if (is_null($serviceId)) {
                    throw new Exception('Service identifier is required');
                }

                if (!is_null($argumentValue)) {
                    throw new Exception('Argument value must be set to NULL');
                }
                break;
            case ArgumentType::VALUE:
                if (!is_null($serviceId)) {
                    throw new Exception('Service identifier must be set to NULL');
                }

                if (is_null($argumentValue)) {
                    throw new Exception('Argument value is required');
                }
                break;
        }

        $this->argumentType = $argumentType;
        $this->serviceId = $serviceId;
        $this->argumentValue = $argumentValue;
    }

    public static function createForService(string $serviceId): self {
        return new self(new ArgumentType(ArgumentType::SERVICE), $serviceId);
    }

    /**
     * @param mixed|null $argumentValue
     */
    public static function createForValue($argumentValue): self {
        return new self(new ArgumentType(ArgumentType::VALUE), null, $argumentValue);
    }

    public function getArgumentType(): ArgumentType
    {
        return $this->argumentType;
    }

    public function getServiceId(): ?string
    {
        return $this->serviceId;
    }

    /**
     * @return mixed|null
     */
    public function getArgumentValue()
    {
        return $this->argumentValue;
    }
}
