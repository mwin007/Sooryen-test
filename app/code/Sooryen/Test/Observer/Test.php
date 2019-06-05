<?php
namespace Sooryen\Test\Observer;

class Test implements \Magento\Framework\Event\ObserverInterface
{
  protected $_logger;
  protected $_testFactory;
  public function __construct(
  \Psr\Log\LoggerInterface $logger, //log injection
  \Sooryen\Test\Model\TestFactory $testFactory,
  array $data = []
  ) {
  $this->_logger = $logger;
  $this->_testFactory = $testFactory;
  //parent::__construct($data);
  }


  public function execute(\Magento\Framework\Event\Observer $observer)
  {

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

    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    $product = $objectManager->create('Magento\Catalog\Model\Product')->load($item->getProductId());
    $productId = $item->getProductId();
    $this->_logger->info($product->getName()); //Get Product Name
    $this->_logger->info($product->getSku()); //Get Product Name

    //custoemr id
    $customerId = $order->getCustomerId();
    $this->_logger->info($customerId);

    $customerRepository = $objectManager->create(\Magento\Customer\Api\CustomerRepositoryInterface::class);
    $customer = $customerRepository->getById($customerId);
    if($customer->getId()){
        $this->_logger->info($customer->getFirstname());
        $this->_logger->info($customer->getLastname());
        $customerFirst = $customer->getFirstname();
        $customerLast = $customer->getLastname();
    }

    $test = $this->_testFactory->create();
    $test->setOrderId($order_id);
    $test->setCustomerId($customerId);
    $test->save();

    /*
    foreach($items as $item) {
      $productId = $item->getProductId();
      $product = $objectManager->create('Magento\Catalog\Model\Product')->load($productId);
      $productName = $product->getName();
      $test->setProductName($productName);
      $test->setOrderId($order_id);
      $test->setCustomerId($customerId);
      $test->setFirstName($customerFirst);
      $test->setLastName($customerLast);

    }
    */


  }
}


