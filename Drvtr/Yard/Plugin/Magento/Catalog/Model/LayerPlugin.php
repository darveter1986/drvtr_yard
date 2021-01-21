<?php


namespace Drvtr\Yard\Plugin\Magento\Catalog\Model;


use Magento\Catalog\Model\Layer;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Framework\Api\SortOrder;
use Psr\Log\LoggerInterface;

/**
 * Class LayerPlugin
 */
class LayerPlugin
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * ClientPlugin constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }


    /**
     * Update Total Records @see Layer::getProductCollection()
     * @param Layer $layer
     * @param Collection $result
     */
    public function afterGetProductCollection(Layer $layer, $result)
    {
        $collection = $result;
//        $collection->getSize();
        return $result;
    }
}
