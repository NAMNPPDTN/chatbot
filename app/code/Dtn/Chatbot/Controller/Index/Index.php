<?php
namespace Dtn\Chatbot\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Response\Http;

class Index extends Action
{
    protected $chatbot;

    protected $resultPageFactory;
    protected $resultJsonFactory;
    protected $response;

    public function __construct(
        Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        Http $response
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->response = $response;
    }

    public function execute()
    {
        $htmlContent = $this->_view->getLayout()->createBlock('Magento\Framework\View\Element\Template')
            ->setTemplate('Dtn_Chatbot::index.phtml')
            ->toHtml();
        // Read HTML content from the file

        // Set HTML content as the response body
        $this->response->setBody($htmlContent);

        return $this->response;
    }
}
