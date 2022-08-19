<?php
declare(strict_types=1);

namespace Aiti\ProductResponsibleUserAdminUi\Controller\Adminhtml\ProductResponsibleUser;

class Delete extends \Aiti\ProductResponsibleUserAdminUi\Controller\Adminhtml\ProductResponsibleUser
{

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('productresponsibleuser_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->_objectManager->create(\Aiti\ProductResponsibleUserAdminUi\Model\ProductResponsibleUser::class);
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Productresponsibleuser.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['productresponsibleuser_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Productresponsibleuser to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}

