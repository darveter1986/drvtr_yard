<?php


namespace Drvtr\Yard\Plugin;

use Drvtr\Yard\Api\Tools\DumperInterface;
use Magento\Catalog\Block\Product\ListProduct;
use Magento\Eav\Model\Entity\Collection\AbstractCollection;
use Psr\Log\LoggerInterface;

/**
 * Class ListProductPlugin
 * @see \Magento\Catalog\Block\Product\ListProduct
 */
class CatalogBlockProductListProductPlugin
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var DumperInterface
     */
    private $dumper;

    /**
     * ClientPlugin constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(
        LoggerInterface $logger,
        DumperInterface $dumper
    ) {
        $this->logger = $logger;
        $this->dumper = $dumper;
    }

    /**
     * @see ListProduct::getLoadedProductCollection()
     *
     * @param ListProduct $subject
     * @param AbstractCollection $result
     * @return  AbstractCollection $result
     */
    public function afterGetLoadedProductCollection(ListProduct $subject, $result)
    {
        $this->dumper->dump(
            '/var/dev/%date%-layer-issue/%increment%-product-collection-select.sql',
            (string) $result->getSelect(),
            true
        );
        return $result;
    }

    /**
     * @param ListProduct $subject
     * @param string $result
     * @return string
     */
    public function afterToHtml(ListProduct $subject, $result)
    {
//        $this->dumper->dump(
//            '/var/drvtr/%date%-ProductListBlock/%increment%-block.html',
//            (string) $result,
//            false
//        );
        return $result;
    }
}
