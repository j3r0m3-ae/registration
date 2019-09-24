<?php

namespace app\core\factories;

use app\core\base\BaseController;
use app\core\exception\InvalidConfigException;

class ControllerFactory
{
    /**
     * @var array
     */
    private $mapping = [];

    /**
     * ControllerFactory constructor
     *
     * @param array $controllersMapping
     * @throws InvalidConfigException
     */
    public function __construct(array $controllersMapping)
    {
        if (empty($controllersMapping)) {
            throw new InvalidConfigException('Invalid controllers factory configuration: empty configuration file');
        }
        $this->mapping = $controllersMapping;
    }

    /**
     * @param string $name
     * @return BaseController
     * @throws InvalidConfigException
     * @throws \Exception
     */
    public function factory(string $name)
    {
        if (isset($this->mapping[$name]) ) {
            if (class_exists($this->mapping[$name])) {
                return new $this->mapping[$name];
            }
            throw new \Exception("Class [".$this->mapping[$name]."] not declared");
        }
        throw new InvalidConfigException("Invalid controllers factory configuration: controller [$name] missing in configuration file");
    }
}