<?php

namespace Pyz\Zed\CustomerMerchantPortalGui\Communication;

use Pyz\Zed\CustomerMerchantPortalGui\Communication\ConfigurationProvider\CustomerGuiTableConfigurationProvider;
use Pyz\Zed\CustomerMerchantPortalGui\Communication\DataProvider\CustomerGuiTableDataProvider;
use Pyz\Zed\CustomerMerchantPortalGui\CustomerMerchantPortalGuiDependencyProvider;
use Spryker\Shared\GuiTable\GuiTableFactoryInterface;
use Spryker\Shared\GuiTable\Http\GuiTableDataRequestExecutorInterface;
use Spryker\Zed\Customer\Business\CustomerFacadeInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

class CustomerMerchantPortalGuiCommunicationFactory extends AbstractCommunicationFactory
{
    public function createCustomerGuiTableConfigurationProvider(): CustomerGuiTableConfigurationProvider
    {
        return new CustomerGuiTableConfigurationProvider(
            $this->getGuiTableFactory()
        );
    }

    public function getGuiTableFactory(): GuiTableFactoryInterface
    {
        return $this->getProvidedDependency(CustomerMerchantPortalGuiDependencyProvider::SERVICE_GUI_TABLE_FACTORY);
    }

    public function createCustomerGuiTableDataProvider(): CustomerGuiTableDataProvider
    {
        return new CustomerGuiTableDataProvider(
            $this->getCustomerFacade()
        );
    }

    public function getCustomerFacade(): CustomerFacadeInterface
    {
        return $this->getProvidedDependency(CustomerMerchantPortalGuiDependencyProvider::FACADE_CUSTOMER);
    }

    public function getGuiTableHttpDataRequestExecutor(): GuiTableDataRequestExecutorInterface
    {
        return $this->getProvidedDependency(
            CustomerMerchantPortalGuiDependencyProvider::SERVICE_GUI_TABLE_HTTP_DATA_REQUEST_EXECUTOR
        );
    }
}
