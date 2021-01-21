<?php


namespace Drvtr\Yard\Service;


use Drvtr\Yard\Api\Tools\DumperInterface;
use Drvtr\Yard\Api\Tools\LoggerPoolInterface;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\Product;
use Magento\CatalogSearch\Model\Layer\Category\ItemCollectionProvider as ItemCollectionProvider;
//use \Magento\Catalog\Model\Layer\Category\ItemCollectionProvider as ItemCollectionProvider;
//use \Magento\Elasticsearch\Model\Layer\Category\ItemCollectionProvider as ItemCollectionProvider;

/**
 * Class ProductPositionList
 * @api
 */
class ProductPositionList
{
    /**
     * @see \Magento\Catalog\Model\Layer\ItemCollectionProviderInterface
     * @var ItemCollectionProvider
     */
    private $collectionProvider;
    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;
    /**
     * @var \Magento\ConfigurableProduct\Helper\Data
     */
    private $confProdHelper;
    /**
     * @var DumperInterface
     */
    private $dumper;
    /**
     * @var LoggerPoolInterface
     */
    private $logs;
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * ProductPositionList constructor.
     * @param ItemCollectionProvider $collectionProvider
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(
        ItemCollectionProvider $collectionProvider,
        CategoryRepositoryInterface $categoryRepository,
    \Magento\ConfigurableProduct\Helper\Data $confProdHelper,
        DumperInterface $dumper,
        LoggerPoolInterface $logs,
    ProductRepositoryInterface $productRepository
    ) {
        $this->collectionProvider = $collectionProvider;
        $this->categoryRepository = $categoryRepository;
        $this->confProdHelper = $confProdHelper;
        $this->dumper = $dumper;
        $this->logs = $logs;
        $this->productRepository = $productRepository;
    }

    /**
     *
     * @param $categoryId
     * @param $order
     * @param int $limit
     *
     * @return []
     */
    public function execute($categoryId, $order, $limit = 60)
    {
//        $this->getProductList();
//        return ['done'];

        /** @var Category $category */
        $category = $this->categoryRepository->get($categoryId);
        $collection = $this->collectionProvider->getCollection($category);
        $collection->setOrder($order, 'ASC');
        $collection->setOrder('entity_id', 'DESC');
        $collection->addAttributeToSelect('name');
        $collection->addAttributeToSelect('price');
        $collection->addFieldToFilter('type_id', 'configurable');



//        $expr = "FIELD(`e`.`entity_id`, 125509,123648,131051,133211,133137,133022,133021,126370,132215,132214,132197,132106,132105,129796,128187,124676,124668,123851,122882,122857,122846,122841,122809,122133,122124,122089,122078,122068,122064,120868,120815,118711,117964,117130,115871,115703,115602,113455,112478,109963,107642,105986,91581,85264,57311)";
//        $collection->getSelect()->order(new \Zend_Db_Expr($expr));

//        $items = $collection->toArray();

        $options = [];
        /** @var ProductInterface $item */
        foreach ($collection->getItems() as $item) {
            $allProducts = $item->getTypeInstance()->getUsedProducts($item, null);
            $options = $this->confProdHelper->getOptions($item, $allProducts);
            $item->setData('options', $options);
        }
        $items = $collection->toArray();
//        $this->dumper->dump( 'var/drvtr/%date%-ProductOptions_ON/%increment%-cat-reindx-' . $categoryId . '.json', $items, true);
        \Drvtr\Yard\Tools::dump( 'var/drvtr/%date%-Static-test2/%increment%-dump-' . $categoryId . '.json', $items, true);
        return $items;

        $items = $collection->toArray();

        //START HR
        $result = [];
        $string = str_pad('idx',4, ' ', STR_PAD_RIGHT);
        $string .= str_pad('pos',6, ' ', STR_PAD_RIGHT);
        $string .= str_pad('name',70, ' ', STR_PAD_RIGHT);
        $string .= str_pad('id',8, ' ', STR_PAD_RIGHT);
        $string .= str_pad('price',8, ' ', STR_PAD_RIGHT);
        $result[] = $string;
        //END HR

        $i = 1;
        foreach ($items as $item) {
            $string = str_pad($i++,4, ' ', STR_PAD_RIGHT);
            $string .= str_pad($item['cat_index_position'],6, ' ', STR_PAD_RIGHT);
            $string .= str_pad($item['name'],70, ' ', STR_PAD_RIGHT);
            $string .= str_pad($item['entity_id'],8, ' ', STR_PAD_RIGHT);
            $string .= round($item['price'], 2);
            $result[] = $string;
        }

        return $result;
    }

    private function getProductList()
    {
        $skus = [
            "BEYO-0SF3243-PLAMUL",
            "BEAC-BR7407S20X-SNAYEL",
            "TWEN-RQ1C037-WHIWHI",
            "BLAN-T00514-BLK",
            "TWEN-RQ1C037-BLKBLK",
            "ALOY-W2586R-BLKBLK",
            "BEAC-BR7407S20X-SNAYEL",
        ];
        $result = [];
        foreach ($skus as $sku) {
            $product = $this->productRepository->get($sku);
            $result[$sku] = $product->getProductUrl();

        }
        $this->dumper->dump( 'var/drvtr/%date%-ProductUrls/%increment%-urls-.txt', $result, true);
    }


    /**
     * @param ProductInterface|Product $product
     *
     * @return string
     */
    private function getProductName(ProductInterface $product) : string
    {
        return mb_convert_case($product->getName(), MB_CASE_TITLE, "UTF-8");
    }

}
