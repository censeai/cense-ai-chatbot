<?php
namespace Censeaiinc\Cense\Controller\Index;

class Save extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;
    protected $resultFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\ResultFactory $resultFactory,
        \Magento\Framework\View\Result\PageFactory $pageFactory)
    {
        $this->_pageFactory = $pageFactory;
        $this->resultFactory = $resultFactory;
        return parent::__construct($context);
    }

    public function execute()
    {

       $productId = $this->getRequest()->getParam('s_id');
       $product_ids = explode(',', $productId );
       $count       = count( $product_ids );
       $number      = 0;
       if(count($product_ids)>0)
       {
        
    
        foreach ( $product_ids as $product_id ) {
            $obj = \Magento\Framework\App\ObjectManager::getInstance();
            
            $product = $obj->create('\Magento\Catalog\Model\Product')->load($product_id);

            $cart = $obj->create('Magento\Checkout\Model\Cart');    
            $params = array();      
            $options = array();
            $params['qty'] = 1;
            $params['product'] = $product_id;
        
            $cart->addProduct($product_id, $params);
            $cart->save();
        }
        $resultPage = $this->_pageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Cense'));
        $block = $resultPage->getLayout()
                ->createBlock('Censeaiinc\Cense\Block\Customerinfo')
                ->setTemplate('Censeaiinc_Cense::info.phtml')
                ->toHtml();
        $this->getResponse()->setBody($block);

    }

}
}