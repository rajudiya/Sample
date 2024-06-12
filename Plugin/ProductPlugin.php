<?php

namespace Vendor\Sample\Plugin;

class ProductPlugin
{
    // Before plugin
    public function beforeSetName(\Magento\Catalog\Model\Product $subject, $name)
    {
        // Modify the name before it is set
        $name = 'Prefix ' . $name;
        return [$name];
    }

    // After plugin
    public function afterGetName(\Magento\Catalog\Model\Product $subject, $result)
    {
        // Modify the result after it is returned
        $result = $result . ' Suffix';
        return $result;
    }

    // Around plugin
    public function aroundGetPrice(\Magento\Catalog\Model\Product $subject, callable $proceed)
    {
        // Execute code before the original method is called
        $price = $proceed(); // Call the original method
        // Execute code after the original method is called
        $price = $price + 100; // Add 10% markup
        return $price;
    }
}
