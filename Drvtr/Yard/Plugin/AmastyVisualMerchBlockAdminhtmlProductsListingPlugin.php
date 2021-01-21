<?php
//
//
//namespace Drvtr\Yard\Plugin;
//
//use Amasty\VisualMerch\Block\Adminhtml\Products\Listing;
//use Magento\Eav\Model\Entity\Collection\AbstractCollection;
//use Psr\Log\LoggerInterface;
//
///**
// * Class AmastyVisualMerchBlockAdminhtmlProductsListingPlugin
// * @see \Amasty\VisualMerch\Block\Adminhtml\Products\Listing
// */
//class AmastyVisualMerchBlockAdminhtmlProductsListingPlugin
//{
//    /**
//     * @var LoggerInterface
//     */
//    private $logger;
//
//    /**
//     * ClientPlugin constructor.
//     * @param LoggerInterface $logger
//     */
//    public function __construct(
//        LoggerInterface $logger
//    ) {
//        $this->logger = $logger;
//    }
//
//    /**
//     * @see Listing::getCollection()
//     *
//     * @param Listing $subject
//     * @param AbstractCollection $result
//     * @return  AbstractCollection $result
//     */
//    public function afterGetCollection(Listing $subject, $result)
//    {
//        $this->logger->debug('[AMASTYLIST] - ' . json_encode([(string)$result->getSelect()]) );
//        return $result;
//    }
//}
