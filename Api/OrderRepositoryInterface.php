<?php

namespace Vendor\Sample\Api;

interface OrderRepositoryInterface
{
    /**
     * Get order data by ID.
     *
     * @param int $id
     * @return \Magento\Sales\Api\Data\OrderInterface
     */
    public function getById($id);
}
