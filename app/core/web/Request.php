<?php

namespace app\core\web;

class Request
{
    /**
     * Retrieve POST parameters
     *
     * @param string|null $name
     * @return mixed
     */
    public function post(string $name = null)
    {
        if ($name === null) {
            return $_POST;
        } elseif (isset($_POST[$name])) {
            return $_POST[$name];
        }
        return null;
    }

    /**
     * Retrieve GET parameters
     *
     * @param string|null $name
     * @return mixed
     */
    public function get(string $name = null)
    {
        if ($name === null) {
            return $_GET;
        } elseif (isset($_GET[$name])) {
            return $_GET[$name];
        }
        return null;
    }
}