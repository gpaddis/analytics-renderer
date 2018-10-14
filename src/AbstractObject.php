<?php

namespace Gpaddis\AnalyticsRenderer;

use Gpaddis\AnalyticsRenderer\RemovePlaceholders;

abstract class AbstractObject implements \JsonSerializable
{
    use RemovePlaceholders;
    protected $fields = [];

    /**
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function set($key, $value)
    {
        $this->fields[$key] = $value;
        return $this;
    }

    /**
     * Add a value to an array in the specified keyspace.
     *
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function add($key, $value)
    {
        $this->checkOrInitializeArray($key);
        $this->fields[$key][] = $value;
        return $this;
    }

    /**
     * @param string $key
     * @return void
     */
    protected function checkOrInitializeArray($key)
    {
        if (!isset($this->fields[$key]) || !is_array($this->fields[$key])) {
            $this->fields[$key] = [];
        }
    }

    /**
     * Wrap a variable in placeholders that will be removed after the object is
     * rendered as Json. This will allow to render javascript variables
     * for values that cannot be fetched from the backend.
     *
     * @param string $key
     * @param string $variableName
     * @return $this
     */
    public function setVariable($key, $variableName)
    {
        $this->fields[$key] = "%%$variableName%%";
        return $this;
    }

    /**
     * @return string
     */
    public function asMinifiedJson()
    {
        return $this->asJson(false);
    }

    /**
     * @return string
     */
    public function asJson($prettyPrint = true)
    {
        if ($prettyPrint) {
            $json = json_encode($this->fields, JSON_PRETTY_PRINT);
        } else {
            $json = json_encode($this->fields);
        }

        return $this->removePlaceholders($json);
    }

    /**
     * Implement the interface JsonSerializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->fields;
    }
}
