<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Aiti\ProductResponsibleUserAdminUi\Controller\Adminhtml\ProductResponsibleUser;

use Aiti\ProductResponsibleUserApi\Api\Data\ProductResponsibleUserInterfaceFactory;
use Aiti\ProductResponsibleUserApi\Api\ProductResponsibleUserRepositoryInterface;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Aiti\ProductResponsibleUserAdminUi\Controller\Adminhtml\ProductResponsibleUser;


/**
 * Class Save
 * @package Aiti\ProductResponsibleUserAdminUi\Controller\Adminhtml\ProductResponsibleUser
 */
class Save extends ProductResponsibleUser
{
    /**
     * @var
     */
    protected $productResponsibleUserRepositoryInterface;

    /**
     * @var ProductResponsibleUserInterfaceFactory
     */
    protected $productResponsibleUserFactory;
    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param ProductResponsibleUserRepositoryInterface $productResponsibleUserRepositoryInterface
     * @param ProductResponsibleUserInterfaceFactory $productResponsibleUserFactory
     */
    public function __construct(
        Context $context,
        ProductResponsibleUserRepositoryInterface $productResponsibleUserRepositoryInterface,
        ProductResponsibleUserInterfaceFactory $productResponsibleUserFactory,
        DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->productResponsibleUserRepositoryInterface = $productResponsibleUserRepositoryInterface;
        $this->productResponsibleUserFactory = $productResponsibleUserFactory;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPost('general');
        if (!empty($data)) {
            $id = (int) (empty($data['user_id']) ? 0 : $data['user_id']);

            try {
                if ($id) {
                    $model = $this->productResponsibleUserRepositoryInterface->get($id);
                    if (!$model->getId() && $id) {
                        $this->messageManager->addErrorMessage(__('This user no longer exists.'));
                        return $resultRedirect->setPath('*/*/');
                    }
                } else {
                    unset($data['user_id']);
                    $model = $this->productResponsibleUserFactory->create();
                }

                $model->setData($data);
                $this->productResponsibleUserRepositoryInterface->save($model);
                $this->dataPersistor->clear('aiti_productresponsibleuser_productresponsibleuser');

                $this->messageManager->addSuccessMessage(__('User was saved.'));
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the user.'));
            }
            $this->dataPersistor->set('aiti_productresponsibleuser_productresponsibleuser', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @inheritDoc
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Aiti_ProductResponsibleUser::User_save');
    }
}
