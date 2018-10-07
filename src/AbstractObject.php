<?php

namespace Gpaddis\AnalyticsRenderer;

class AbstractObject implements \JsonSerializable
{
    protected $fields = [];
    protected $containsPlaceholders = false;

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
        $this->containsPlaceholders = true;
        return $this;
    }

    /**
     * @return string
     */
    public function renderAsMinifiedJson()
    {
        return $this->renderAsJson(false);
    }

    /**
     * @return string
     */
    public function renderAsJson($prettyPrint = true)
    {
        if ($prettyPrint) {
            $json = json_encode($this->fields, JSON_PRETTY_PRINT);
        } else {
            $json = json_encode($this->fields);
        }

        if ($this->containsPlaceholders()) {
            $json = $this->removePlaceholders($json);
        }

        return $json;
    }

    /**
     * @return boolean
     */
    protected function containsPlaceholders()
    {
        return $this->containsPlaceholders;
    }

    /**
     * @param string $json
     * @return string
     */
    protected function removePlaceholders($json)
    {
        $json = str_replace('"%%', '', $json);
        $json = str_replace('%%"', '', $json);
        return $json;
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
