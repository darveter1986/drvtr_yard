<?php


namespace Drvtr\Yard\Scaffold\Setup\ExamplePatchData;


use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Customer\Model\Attribute\Backend\Data\Boolean;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Model\Config;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;


/**
 * Class AddCustomerAttribute
 */
class AddCustomerAttribute implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @var Config
     */
    private $eavConfig;

    /**
     * AddCustomerAttributeSkipFraudCheck constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     * @param Config $eavConfig
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory,
        Config $eavConfig
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig = $eavConfig;
    }

    /**
     * @return array|string[]
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @return array|string[]
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function apply()
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $eavSetup->addAttribute(
            CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER,
            'c38_skip_fraud_check',
            [
                'type' => 'int',
                'label' => 'Skip Fraud Check',
                'input' => 'boolean',
                'backend' => Boolean::class,
                'required' => false,
                'user_defined' => true,
                'system' => 0,
                'position' => 200,
                'used_in_forms' => ['adminhtml_customer']
            ]
        );
        $eavSetup->addAttributeToSet(
            CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER,
            CustomerMetadataInterface::ATTRIBUTE_SET_ID_CUSTOMER,
            null,
            'c38_skip_fraud_check'
        );
        $attr = $this->eavConfig->getAttribute(
            CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER,
            'c38_skip_fraud_check'
        );
        $attr->setData('used_in_forms', [
            'adminhtml_customer',
        ]);
        $attr->getResource()->save($attr);
    }
}
