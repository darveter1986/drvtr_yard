<?php


namespace Drvtr\Yard\Rest\Test\Command;

use Magento\Framework\App\Area;
use Magento\Framework\App\State;

/**
 * Class WebhookEventProcessCommand
 * @api
 */
class WebhookEventProcessCommand
{
//    /**
//     * @var \C38\FlowioCheckout\Model\WebhookEventManager
//     */
//    private $webhookEventManager;
//    /**
//     * @var State
//     */
//    private $state;
//
//
//    public function __construct(
//        \C38\FlowioCheckout\Model\WebhookEventManager $webhookEventManager,
//        State $state
//    ) {
//        $this->webhookEventManager = $webhookEventManager;
//        $this->state = $state;
//    }
//
//    /**
//     * @return string
//     */
//    public function execute()
//    {
//        $webhookEventManager = $this->webhookEventManager;
//
//        $this->state->emulateAreaCode(Area::AREA_CRONTAB, function ()
//            use ($webhookEventManager) {
//                $webhookEventManager->process();
//            }
//        );
//
//        return 'finish';
//    }
}
