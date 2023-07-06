<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\Bundle\Plugin\Framework\Data\Form\Element;

use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\Fieldset;

/**
 * Plugin that fixes mapping of value and label for bundle dynamic attributes
 */
class FieldsetPlugin
{
    /**
     * @var string[]
     */
    private $dynamicAttributeNames = ['sku_type', 'weight_type', 'price_type'];

    /**
     * Normalise bundle dynamic attributes values
     *
     * Normalise attribute values for bundle dynamic attributes generated by form element
     * to make it consistent across the system (dynamic => 1, fixed => 0)
     *
     * @param Fieldset $subject
     * @param AbstractElement $result
     * @return AbstractElement
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterAddField(Fieldset $subject, AbstractElement $result)
    {
        if (!in_array($result->getAttributeCode(), $this->dynamicAttributeNames)) {
            return $result;
        }

        $new = [];
        foreach ($result->getValues() as $option) {
            $option['value'] = (int)!$option['value'];
            $new[] = $option;
        }

        $result->setValues($new);
        return $result;
    }
}
