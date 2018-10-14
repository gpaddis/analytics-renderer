<?php

namespace Gpaddis\AnalyticsRenderer\EnhancedEcommerce\Renderer;

use Gpaddis\AnalyticsRenderer\RendererInterface;
use Gpaddis\AnalyticsRenderer\EnhancedEcommerce\Activity\AbstractActivity;

class DataLayer implements RendererInterface
{
    protected $activity = null;

    public function render()
    {
        $activityType = $this->getActivityType();
        $wrapper = [
            'event' => $activityType,
            'ecommerce' => [
                $activityType => $this->activity
            ]
        ];

        $json = json_encode($wrapper, JSON_PRETTY_PRINT);
        return "dataLayer.push({$json});";
    }

    /**
     * Load an instance of the activity to render.
     *
     * @param AbstractActivity $activity
     * @return void
     */
    public function load(AbstractActivity $activity)
    {
        $this->activity = $activity;
        return $this;
    }

    /**
     * Get the activity type loaded in the object.
     *
     * @return string
     */
    protected function getActivityType()
    {
        $classname = (new \ReflectionClass($this->activity))->getShortName();
        return strtolower($classname);
    }
}
