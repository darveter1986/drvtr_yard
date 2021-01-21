<?php


namespace Drvtr\Yard\Rest\Test\Command;

use Magento\Framework\App\Area;
use Magento\Framework\App\State;

/**
 * Class TaxRefundTest
 * @api
 */
class TaxRefundTest
{
    /**
     * @var State
     */
    private $state;

    /**
     * @var \Drvtr\Yard\Service\TaxRefund
     */
    private $taxRefund;

    /**
     * TaxRefundTest constructor.
     * @param State $state
     * @param \Drvtr\Yard\Service\TaxRefund $taxRefund
     */
    public function __construct(
        State $state,
        \Drvtr\Yard\Service\TaxRefund $taxRefund
    ) {
        $this->state = $state;
        $this->taxRefund = $taxRefund;
    }

    /**
     * @api
     * @param string $orderId
     * @param string $subtotal
     *
     * @return string
     *
     * @throws \Exception
     */
    public function execute($orderId, $subtotal)
    {
        $result = $this->state->emulateAreaCode(Area::AREA_ADMINHTML, function ()
            use ($orderId, $subtotal) {
                return $this->taxRefund->execute($orderId, $subtotal);
            }
        );

        return $result;
    }
}
