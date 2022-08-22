<?php
declare(strict_types=1);

namespace Aiti\ProductResponsibleUserAdminUi\Controller\Adminhtml\ProductResponsibleUser;

use Aiti\ProductResponsibleUserAdminUi\Controller\Adminhtml\ProductResponsibleUser as User;
use Aiti\ProductResponsibleUserApi\Api\ProductResponsibleUserRepositoryInterface;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Edit extends User
{

/**
* @var
*/
    protected $productResponsibleUserRepositoryInterface;

    /**
     * Edit constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param ProductResponsibleUserRepositoryInterface $productResponsibleUserRepositoryInterface
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ProductResponsibleUserRepositoryInterface $productResponsibleUserRepositoryInterface
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->productResponsibleUserRepositoryInterface = $productResponsibleUserRepositoryInterface;
        parent::__construct($context);
    }

    /**
     * @return Redirect|ResponseInterface|ResultInterface|Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $id = (int) $this->getRequest()->getParam('id');

        $model = null;
        if ($id) {
            try {

                $model = $this->productResponsibleUserRepositoryInterface->get($id);
                if (!$model->getUserId()) {
                    $this->messageManager->addErrorMessage(__('This Productresponsibleuser no longer exists.'));
                    /** @var Redirect $resultRedirect */
                    $resultRedirect = $this->resultRedirectFactory->create();
                    return $resultRedirect->setPath('*/*/');
                }
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }

        $resultPage->getConfig()->getTitle()->prepend(__('Users'));
        $resultPage->getConfig()->getTitle()->prepend($model && $model->getId() ? __('Edit Product responsible user %1', $model->getId()) : __('New Product responsible user'));
        return $resultPage;
    }

    /**
     * @inheritDoc
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Aiti_ProductResponsibleUser::User');
    }
}

