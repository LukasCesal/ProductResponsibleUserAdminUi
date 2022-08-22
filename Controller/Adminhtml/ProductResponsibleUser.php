<?php
declare(strict_types=1);

namespace Aiti\ProductResponsibleUserAdminUi\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Page;


abstract class ProductResponsibleUser extends Action
{

    const ADMIN_RESOURCE = 'Magento_Catalog::inventory';
    protected $_coreRegistry;


    /**
     * Init page
     *
     * @param \Magento\Backend\Model\View\Result\Page $resultPage
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function initPage($resultPage)
    {
        $resultPage->setActiveMenu(self::ADMIN_RESOURCE)
            ->addBreadcrumb(__('Aiti'), __('Aiti'))
            ->addBreadcrumb(__('Product responsibl user'), __('Product Responsible Users'));
        return $resultPage;
    }

}

