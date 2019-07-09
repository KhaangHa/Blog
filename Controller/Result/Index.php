<?php
namespace Magenest\Demo\Controller\Result;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class Index extends Action
{
    protected $resultPageFactory;
    protected $_helper;
    protected $_cacheTypeList, $_cacheFrontendPool;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magenest\Demo\Helper\SetConfig $setConfig,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->_helper = $setConfig;
        $this->_cacheTypeList = $cacheTypeList;
        $this->_cacheFrontendPool = $cacheFrontendPool;
        parent::__construct($context);
    }
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        $path = 'web/cookie/cookie_lifetime';
        $data = $this->getRequest()->getPostValue();
        $cookie_lifetime = $data['demo-input'];
        $this->_helper->setConfig($path, $cookie_lifetime);

        $types = array('config','layout','block_html','collections','reflection','db_ddl','eav','config_integration','config_integration_api','full_page','translate','config_webservice');
        foreach ($types as $type) {
            $this->_cacheTypeList->cleanType($type);
        }

        return $resultRedirect->setPath('demo/index');
    }
}