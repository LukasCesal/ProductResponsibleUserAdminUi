<?php
declare(strict_types=1);

namespace Aiti\ProductResponsibleUserAdminUi\Controller\Adminhtml\ProductResponsibleUser;

class Edit extends \Aiti\ProductResponsibleUserAdminUi\Controller\Adminhtml\ProductResponsibleUser
{

    protected $resultPageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('productresponsibleuser_id');
        $model = $this->_objectManager->create(\Aiti\ProductResponsibleUserAdminUi\Model\ProductResponsibleUser::class);
        
        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Productresponsibleuser no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->_coreRegistry->register('aiti_productresponsibleuseradminui_productresponsibleuser', $model);
        
        // 3. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Productresponsibleuser') : __('New Productresponsibleuser'),
            $id ? __('Edit Productresponsibleuser') : __('New Productresponsibleuser')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Productresponsibleusers'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? __('Edit Productresponsibleuser %1', $model->getId()) : __('New Productresponsibleuser'));
        return $resultPage;
    }
}

