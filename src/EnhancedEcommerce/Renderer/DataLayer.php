<?php

namespace Gpaddis\AnalyticsRenderer\EnhancedEcommerce\Renderer;

use Gpaddis\AnalyticsRenderer\RendererInterface;
use Gpaddis\AnalyticsRenderer\EnhancedEcommerce\Activity\AbstractActivity;
use Gpaddis\AnalyticsRenderer\RemovePlaceholders;

class DataLayer implements RendererInterface
{
    use RemovePlaceholders;

    protected $activity = null;

    public function render()
    {
        $wrapper = $this->getWrappedActivity();

        $json = json_encode($wrapper, JSON_PRETTY_PRINT);
        $json = $this->removePlaceholders($json);

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
     * Get the activity type loaded in the renderer.
     *
     * @return string
     */
    protected function getActivityType()
    {
        $classname = (new \ReflectionClass($this->activity))->getShortName();
        return strtolower($classname);
    }

    /**
     * Get the activity wrapped in the correct data structure according to the type.
     *
     * @return array
     */
    protected function getWrappedActivity()
    {
        $wrapper = [];

        $activityType = $this->getActivityType();
        switch ($activityType) {
            case 'checkout':
                $wrapper['event'] = $activityType;
                $wrapper['ecommerce'] = [
                    $activityType => $this->activity
                ];
                break;

            case 'click':
                $wrapper['event'] = 'productClick';
                $wrapper['ecommerce'] = [
                    $activityType => $this->activity
                ];
                break;

            case 'detail':
                $wrapper['ecommerce'] = [
                    $activityType => $this->activity
                ];
                break;

            case 'impressions':
                $wrapper['ecommerce'] = $this->activity;
                break;
        }

        return $wrapper;
    }
}
