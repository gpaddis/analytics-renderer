<?php

namespace Gpaddis\AnalyticsRenderer;

trait RemovePlaceholders
{
    protected $containsPlaceholders = false;

    /**
     * Check recursively whether the parent or any of its child objects contain placeholders.
     *
     * @return boolean
     */
    public function containsPlaceholders()
    {
        if ($this->containsPlaceholders) {
            return true;
        }

        foreach ($this->fields as $field) {
            if ($field instanceof self && $field->containsPlaceholders()) {
                return true;
            }
        }

        return false;
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
}
