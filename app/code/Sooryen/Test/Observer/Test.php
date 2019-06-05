<?php
namespace Sooryen\Test\Observer;

class Test implements \Magento\Framework\Event\ObserverInterface
{
  protected $_logger;
  public function __construct(
  \Psr\Log\LoggerInterface $logger, //log injection
  array $data = []
  ) {
  $this->_logger = $logger;
     // parent::__construct($data);
  }


  public function execute(\Magento\Framework\Event\Observer $observer)
  {
     //$order= $observer->getData('order');
   //$order->doSomething();
    //order id
    $order = $observer->getEvent()->getOrder();
    $order_id = $order->getIncrementId();
    $this->_logger->info($order_id);

    $items =$order->getAllVisibleItems();
    //product ids
    $productIds = array();
    foreach($items as $item) {
      //$productIds[]= $item->getProductId();
      $this->_logger->info($item->getProductId());
    }

    //custoemr id
    $customerId = $order->getCustomerId();
    $this->_logger->info($customerId);

  }
}
