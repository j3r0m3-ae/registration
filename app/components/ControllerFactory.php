<?php

namespace app\components;

use app\components\base\BaseController;

class ControllerFactory
{
    /**
     * @var array
     */
    private $mapping = [];

    /**
     * @param array $controllersMapping
     */
    public function __construct(array $controllersMapping)
    {
        $this->mapping = $controllersMapping;
    }

    /**
     * @param string $name
     * @return BaseController|null
     */
    public function factory(string $name)
    {
        if (isset($this->mapping[$name]) && class_exists($this->mapping[$name])) {
            return new $this->mapping[$name];
        }

        return null;
    }
}