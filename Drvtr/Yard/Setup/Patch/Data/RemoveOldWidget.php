<?php


namespace Drvtr\Yard\Setup\Patch\Data;

use Drvtr\Yard\Setup\WidgetBlockRemover;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Psr\Log\LoggerInterface;

/**
 * Class Remove Widget service
 */
class RemoveOldWidget implements DataPatchInterface
{
    /**
     * string
     */
    const INSTANCE_TYPE = 'Vendor\Dummy\Block\Widget';

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var WidgetBlockRemover
     */
    private $widgetBlockRemover;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * RemoveStorelocatorWidget constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param WidgetBlockRemover $widgetBlockRemover
     * @param LoggerInterface $logger
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        WidgetBlockRemover $widgetBlockRemover,
        LoggerInterface $logger
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->widgetBlockRemover = $widgetBlockRemover;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function apply()
    {
        $this->moduleDataSetup->startSetup();
        try {
            $this->widgetBlockRemover->remove(self::INSTANCE_TYPE);
        } catch (NoSuchEntityException $e) {
            $this->logger->info($e->getMessage());
        }
        $this->moduleDataSetup->endSetup();
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
