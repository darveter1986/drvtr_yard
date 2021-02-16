<?php


namespace Drvtr\Yard\Rest\Test\Command;

use Magento\Framework\App\Area;
use Magento\Framework\App\State;

/**
 * Class InformationTest
 * @api
 */
class InformationTest
{
    /**
     * @var State
     */
    private $state;
    /**
     * @var \Drvtr\Weather\Cron\WeatherDataUpdater
     */
    private $weatherDataUpdater;


    /**
     * productPositionTest constructor.
     * @param State $state
     */
    public function __construct(
        State $state,
        \Drvtr\Weather\Cron\WeatherDataUpdater $weatherDataUpdater
    ) {
        $this->state = $state;
        $this->weatherDataUpdater = $weatherDataUpdater;
    }

    /**
     * @api
     * @return []
     *
     * @throws \Exception
     */
    public function execute()
    {
        $e = 1;
        $result = $this->state->emulateAreaCode(Area::AREA_FRONTEND, function ()
            use ($e) {
                $this->weatherDataUpdater->update();
                return ['ok'];
            }
        );

        return $result;
    }
}
