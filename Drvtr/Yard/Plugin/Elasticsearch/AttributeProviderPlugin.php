<?php


namespace Drvtr\Yard\Plugin\Elasticsearch;


use Magento\Elasticsearch\Model\Adapter\FieldMapper\Product\AttributeProvider;

class AttributeProviderPlugin
{
    /**
     * @param AttributeProvider $subject
     * @param \Closure $proceed
     * @param $attributeCode
     * @return mixed
     */
    public function aroundGetByAttributeCode(AttributeProvider $subject, \Closure $proceed, $attributeCode)
    {
        $result = $proceed($attributeCode);

        if (isset($result['position'])) {

        }
        return $result;
    }
}
