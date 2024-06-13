<?php

namespace Vendor\Sample\Model;

use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface as MagentoOrderRepositoryInterface;
use Vendor\Sample\Api\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    /**
     * @var MagentoOrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * OrderRepository constructor.
     *
     * @param MagentoOrderRepositoryInterface $orderRepository
     */
    public function __construct(
        MagentoOrderRepositoryInterface $orderRepository
    ) {
        $this->orderRepository = $orderRepository;
    }

    /**
     * Get order data by ID.
     *
     * @param int $id
     * @return OrderInterface
     */
    public function getById($id)
    {
        return $this->orderRepository->get($id);
    }
}
