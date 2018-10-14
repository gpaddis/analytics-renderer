<?php

namespace Gpaddis\AnalyticsRenderer;

trait RemovePlaceholders
{
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
