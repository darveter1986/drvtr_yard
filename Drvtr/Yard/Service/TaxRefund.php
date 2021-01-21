<?php


namespace Drvtr\Yard\Service;

use \C38\Backend\Model\OrderBatchRefund;
use \C38\Backend\Model\OrderBatchRefundFactory;

/**
 * Class TaxRefund
 */
class TaxRefund
{
    /**
     * @var \C38\Backend\Cron\OrderBatchRefundTask
     */
    private $orderBatchRefundTask;
    /**
     * @var OrderBatchRefundFactory
     */
    private $batchRefundFactory;

    /**
     * TaxRefund constructor.
     * @param \C38\Backend\Cron\OrderBatchRefundTask $orderBatchRefundTask
     */
//    public function __construct(
//        \C38\Backend\Cron\OrderBatchRefundTask $orderBatchRefundTask,
//        OrderBatchRefundFactory $batchRefundFactory
//    ) {
//        $this->orderBatchRefundTask = $orderBatchRefundTask;
//        $this->batchRefundFactory = $batchRefundFactory;
//    }

    /**
     *
     */
    public function execute($orderId, $amount)
    {
       $this->orderBatchRefundTask->execute();
//        $this->setDummy();
       return 'done';
    }

    private function setDummy()
    {
        $orders = [
//            60 => '1.3',
//            59 => '2.4',
//            43 => '1.6',
//            41 => '2.5',
//            39 => '1.3',
//            23 => '2.1',
//            22 => '1.5',
//            78 => '2.5',
//            187 => 7.35,
//            221 => 1.33,
        ];
        foreach ($orders as $id => $amount) {
            /** @var OrderBatchRefund $refund */
            $refund = $this->batchRefundFactory->create();
            $refund->setData(OrderBatchRefund::ORDER_ID, $id);
            $refund->setData(OrderBatchRefund::AMOUNT, (float) $amount);
            $refund->getResource()->save($refund);
        }
    }
}
