<?php

namespace Pyz\Zed\CustomerMerchantPortalGui\Communication\DataProvider;

use Generated\Shared\Transfer\CustomerCollectionTransfer;
use Generated\Shared\Transfer\CustomerTableCriteriaTransfer;
use Generated\Shared\Transfer\GuiTableDataRequestTransfer;
use Generated\Shared\Transfer\GuiTableDataResponseTransfer;
use Generated\Shared\Transfer\GuiTableRowDataResponseTransfer;
use Generated\Shared\Transfer\PaginationTransfer;
use Pyz\Zed\CustomerMerchantPortalGui\Communication\ConfigurationProvider\CustomerGuiTableConfigurationProvider;
use Spryker\Shared\GuiTable\DataProvider\AbstractGuiTableDataProvider;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use Spryker\Zed\Customer\Business\CustomerFacadeInterface;
use Spryker\Zed\SalesMerchantPortalGui\Dependency\Facade\SalesMerchantPortalGuiToCurrencyFacadeInterface;
use Spryker\Zed\SalesMerchantPortalGui\Dependency\Facade\SalesMerchantPortalGuiToMerchantUserFacadeInterface;
use Spryker\Zed\SalesMerchantPortalGui\Dependency\Facade\SalesMerchantPortalGuiToMoneyFacadeInterface;

class CustomerGuiTableDataProvider extends AbstractGuiTableDataProvider
{
    protected CustomerFacadeInterface $customerFacade;

    protected SalesMerchantPortalGuiToMerchantUserFacadeInterface $merchantUserFacade;

    protected SalesMerchantPortalGuiToCurrencyFacadeInterface $currencyFacade;

    protected SalesMerchantPortalGuiToMoneyFacadeInterface $moneyFacade;

    public function __construct(CustomerFacadeInterface $customerFacade)
    {
        $this->customerFacade = $customerFacade;
    }

    protected function createCriteria(GuiTableDataRequestTransfer $guiTableDataRequestTransfer): AbstractTransfer
    {
        return new CustomerTableCriteriaTransfer();
    }

    protected function fetchData(AbstractTransfer $criteriaTransfer): GuiTableDataResponseTransfer
    {
        $paginationTransfer = new PaginationTransfer();
        $pagination = $paginationTransfer
            ->setPage($criteriaTransfer->getPageOrFail())
            ->setMaxPerPage($criteriaTransfer->getPageSizeOrFail());
        $customerCollectionTransfer = (new CustomerCollectionTransfer())
            ->setPagination($pagination);

        $customerCollectionTransfer = $this->customerFacade
            ->getCustomerCollection($customerCollectionTransfer);
        /** @var GuiTableDataRequestTransfer $guiTableDataResponseTransfer */
        $guiTableDataResponseTransfer = new GuiTableDataResponseTransfer();

        foreach ($customerCollectionTransfer->getCustomers() as $customerTransfer) {
            $responseData = [
                CustomerGuiTableConfigurationProvider::COL_KEY_ID_CUSTOMER => $customerTransfer->getIdCustomer(),
                CustomerGuiTableConfigurationProvider::COL_KEY_CREATED_AT => $customerTransfer->getCreatedAt(),
                CustomerGuiTableConfigurationProvider::COL_KEY_EMAIL => $customerTransfer->getEmail(),
                CustomerGuiTableConfigurationProvider::COL_KEY_LAST_NAME => $customerTransfer->getLastName(),
                CustomerGuiTableConfigurationProvider::COL_KEY_FIRST_NAME => $customerTransfer->getFirstName(),
                CustomerGuiTableConfigurationProvider::COL_KEY_STATUS => $customerTransfer->getRegistered(
                ) ? 'Verified' : 'Unverified',
            ];

            $guiTableDataResponseTransfer->addRow(
                (new GuiTableRowDataResponseTransfer())->setResponseData($responseData)
            );
        }

        $paginationTransfer = $customerCollectionTransfer->getPaginationOrFail();

        return $guiTableDataResponseTransfer
            ->setPage($paginationTransfer->getPageOrFail())
            ->setPageSize($paginationTransfer->getMaxPerPageOrFail())
            ->setTotal($paginationTransfer->getNbResultsOrFail());
    }
}
