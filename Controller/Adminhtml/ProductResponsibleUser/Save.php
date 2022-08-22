<?php
declare(strict_types=1);

namespace Aiti\ProductResponsibleUserAdminUi\Controller\Adminhtml\ProductResponsibleUser;

use Aiti\ProductResponsibleUserApi\Api\Data\ProductResponsibleUserInterfaceFactory;
use Aiti\ProductResponsibleUserApi\Api\ProductResponsibleUserRepositoryInterface;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Aiti\ProductResponsibleUserAdminUi\Controller\Adminhtml\User;

class Save extends \Magento\Backend\App\Action
{

    protected $dataPersistor;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('user_id');

            $model = $this->_objectManager->create(\Aiti\ProductResponsibleUser\Model\ProductResponsibleUser::class)->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Productresponsibleuser no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Productresponsibleuser.'));
                $this->dataPersistor->clear('aiti_productresponsibleuseradminui_productresponsibleuser');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Productresponsibleuser.'));
            }

            $this->dataPersistor->set('aiti_productresponsibleuseradminui_productresponsibleuser', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('productresponsibleuser_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}

