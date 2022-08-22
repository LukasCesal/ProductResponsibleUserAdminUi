<?php
declare(strict_types=1);

namespace Aiti\ProductResponsibleUserAdminUi\Controller\Adminhtml\ProductResponsibleUser;

use Aiti\ProductResponsibleUserAdminUi\Controller\Adminhtml\ProductResponsibleUser as User;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Framework\Controller\ResultInterface;

class NewAction extends User
{

    protected $resultForwardFactory;

    /**
     * @param Context $context
     * @param ForwardFactory $resultForwardFactory
     */
    public function __construct(
        Context $context,
        ForwardFactory $resultForwardFactory
    ) {
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
    }

    /**
     * New action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }

    /**
     * @inheritDoc
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Aiti_ProductResponsibleUser::User');
    }
}

