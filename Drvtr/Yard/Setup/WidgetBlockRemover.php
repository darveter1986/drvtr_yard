<?php


namespace Drvtr\Yard\Setup;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Widget\Model\Widget\Instance as WidgetInstance;
use Magento\Widget\Model\Widget\InstanceFactory as WidgetInstanceFactory;
use Magento\Widget\Model\ResourceModel\Widget\Instance as InstanceResourceModel;

/**
 * Class WidgetBlockRemover patch
 */
class WidgetBlockRemover
{
    /**
     * @var WidgetInstanceFactory
     */
    private  $instanceFactory;

    /**
     * @var InstanceResourceModel
     */
    private  $resourceModel;

    /**
     * WidgetBlockRemover constructor.
     * @param WidgetInstanceFactory $instanceFactory
     * @param InstanceResourceModel $resourceModel
     */
    public function __construct(
        WidgetInstanceFactory $instanceFactory,
        InstanceResourceModel $resourceModel
    ) {
        $this->instanceFactory = $instanceFactory;
        $this->resourceModel = $resourceModel;
    }

    /**
     * Remove widget from DB content (layout_update xml etc.)
     *
     * @param string $instanceType
     * @throws NoSuchEntityException
     */
    public function remove(string $instanceType)
    {
        $widget = $this->getWidgetByInstanceType($instanceType);
        $this->resourceModel->delete($widget);
    }

    /**
     * Get widget instance by given instance Type
     *
     * @param int $instanceType
     * @return WidgetInstance
     * @throws NoSuchEntityException
     */
    private function getWidgetByInstanceType(string $instanceType): WidgetInstance
    {
        /** @var WidgetInstance $widgetInstance */
        $widgetInstance = $this->instanceFactory->create();
        $this->resourceModel->load($widgetInstance, $instanceType, 'instance_type');

        if (!$widgetInstance->getId()) {
            throw new NoSuchEntityException(
                __(
                    'No such entity with instance_id = %instance_type',
                    ['instance_type' => $instanceType]
                )
            );
        }

        return $widgetInstance;
    }
}
