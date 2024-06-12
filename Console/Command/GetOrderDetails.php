<?php

namespace Vendor\Sample\Console\Command;

use Magento\Framework\App\State;
use Magento\Sales\Model\Order;
use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetOrderDetails extends Command
{
    const CUSTOMER_ID_ARGUMENT = 'customer_id';

    protected $order;
    protected $customerFactory;
    protected $appState;

    public function __construct(
        Order $order,
        CustomerFactory $customerFactory,
        State $appState
    ) {
        $this->order = $order;
        $this->customerFactory = $customerFactory;
        $this->appState = $appState;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('order:details')
            ->setDescription('Get order details by customer ID')
            ->addArgument(
                self::CUSTOMER_ID_ARGUMENT,
                InputArgument::REQUIRED,
                'Customer ID'
            );
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->appState->setAreaCode('frontend');

        $customerId = $input->getArgument(self::CUSTOMER_ID_ARGUMENT);
        $customer = $this->customerFactory->create()->load($customerId);

        if (!$customer->getId()) {
            $output->writeln("<error>Customer with ID $customerId does not exist.</error>");
            return Cli::RETURN_FAILURE;
        }

        $orders = $this->order->getCollection()->addFieldToFilter('customer_id', $customerId);

        if ($orders->getSize() == 0) {
            $output->writeln("<info>No orders found for customer with ID $customerId.</info>");
            return Cli::RETURN_SUCCESS;
        }

        foreach ($orders as $order) {
            $output->writeln("Order ID: " . $order->getId());
            $output->writeln("Order Total: " . $order->getGrandTotal());
            $output->writeln("Order Status: " . $order->getStatus());
            $output->writeln("Order Created At: " . $order->getCreatedAt());
            $output->writeln("---");
        }

        return Cli::RETURN_SUCCESS;
    }
}
