<?php
declare(strict_types=1);

namespace Aiti\ProductResponsibleUserAdminUi\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;
use Aiti\ProductResponsibleUserAdminUi\Block\Adminhtml\Form\Field\ExternalColumn;

/**
 * Class Ranges
 */
class Departments extends AbstractFieldArray
{
    /**
     * @var ExternalColumn
     */
    private $externalRenderer;

    /**
     * Prepare rendering the new field by adding all the needed columns
     */
    protected function _prepareToRender()
    {
        $this->addColumn('name', ['label' => __('Name'), 'class' => 'required-entry']);
        $this->addColumn('external', [
            'label' => __('External'),
            'renderer' => $this->getExternalRenderer()
        ]);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }

    /**
     * Prepare existing row data object
     *
     * @param DataObject $row
     * @throws LocalizedException
     */
    protected function _prepareArrayRow(DataObject $row): void
    {
        $options = [];

        $external = $row->getExternal();
        if ($external !== null) {
            $options['option_' . $this->getExternalRenderer()->calcOptionHash($external)] = 'selected="selected"';
        }

        $row->setData('option_extra_attrs', $options);
    }

    /**
     * @return ExternalColumn
     * @throws LocalizedException
     */
    private function getExternalRenderer()
    {
        if (!$this->externalRenderer) {
            $this->externalRenderer = $this->getLayout()->createBlock(
                ExternalColumn::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->externalRenderer;
    }
}
