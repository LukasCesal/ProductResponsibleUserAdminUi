<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Aiti\ProductResponsibleUserAdminUi\Ui\DataProvider;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\ReportingInterface;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider;
use Aiti\ProductResponsibleUserApi\Api\ProductResponsibleUserRepositoryInterface;
use Aiti\ProductResponsibleUserApi\Api\Data\ProductResponsibleUserInterface;
use Magento\Ui\DataProvider\SearchResultFactory;


class ProductResponsibleUserDataProvider extends DataProvider
{
    private $productResponsibleUserRepository;
    private $searchResultFactory;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        ReportingInterface $reporting,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        RequestInterface $request,
        FilterBuilder $filterBuilder,
        SearchResultFactory $searchResultFactory,
        ProductResponsibleUserRepositoryInterface $productResponsibleUserRepository,
        array $meta = [],
        array $data = []
    ) {

        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $reporting,
            $searchCriteriaBuilder,
            $request,
            $filterBuilder,
            $meta,
            $data
        );

        $this->productResponsibleUserRepository = $productResponsibleUserRepository;
        $this->searchResultFactory = $searchResultFactory;
    }

       /* public function getData()
    {
        return parent::getData();
    }*/

    public function getSearchResult()
    {
        $searchCriteria = $this->getSearchCriteria();
        $result = $this->productResponsibleUserRepository->getList($searchCriteria);

        return $this->searchResultFactory->create(
            $result->getItems(),
            $result->getTotalCount(),
            $searchCriteria,
            ProductResponsibleUserInterface::USER_ID
        );
    }
}
