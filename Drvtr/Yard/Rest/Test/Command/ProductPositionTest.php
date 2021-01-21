<?php


namespace Drvtr\Yard\Rest\Test\Command;

use Magento\Framework\App\Area;
use Magento\Framework\App\State;

/**
 * Class ProductPositionTest
 * @api
 */
class ProductPositionTest
{
    /**
     * @var State
     */
    private $state;

    /**
     * @var \Drvtr\Yard\Service\ProductPositionList
     */
    private $productPosition;

    /**
     * productPositionTest constructor.
     * @param State $state
     * @param \Drvtr\Yard\Service\ProductPositionList $productPosition
     */
    public function __construct(
        State $state,
        \Drvtr\Yard\Service\ProductPositionList $productPosition
    ) {
        $this->state = $state;
        $this->productPosition = $productPosition;
    }

    /**
     * @api
     * @param string $categoryId
     * @param string $order
     *
     * @return []
     *
     * @throws \Exception
     */
    public function execute($categoryId, $order)
    {
        $result = $this->state->emulateAreaCode(Area::AREA_FRONTEND, function ()
            use ($categoryId, $order) {
                return $this->productPosition->execute($categoryId, $order);
            }
        );

        return $result;
    }
}
