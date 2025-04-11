<?php

namespace Pyz\Zed\CustomerMerchantPortalGui\Communication\ConfigurationProvider;

use Generated\Shared\Transfer\GuiTableConfigurationTransfer;
use Spryker\Shared\GuiTable\Configuration\Builder\GuiTableConfigurationBuilderInterface;
use Spryker\Shared\GuiTable\GuiTableFactoryInterface;

class CustomerGuiTableConfigurationProvider
{
    public const COL_KEY_ID_CUSTOMER = 'id_customer';

    public const COL_KEY_CREATED_AT = 'created_at';

    public const COL_KEY_EMAIL = 'email';

    public const COL_KEY_FIRST_NAME = 'first_name';

    public const COL_KEY_LAST_NAME = 'last_name';

    public const COL_KEY_STATUS = 'registered';

    protected const DATA_URL = '/customer-merchant-portal-gui/customer/table-data';

    protected GuiTableFactoryInterface $guiTableFactory;

    public function __construct(GuiTableFactoryInterface $guiTableFactory)
    {
        $this->guiTableFactory = $guiTableFactory;
    }

    public function getConfiguration(): GuiTableConfigurationTransfer
    {
        $guiTableConfigurationBuilder = $this->guiTableFactory->createConfigurationBuilder();

        $guiTableConfigurationBuilder = $this->addColumns($guiTableConfigurationBuilder);

        $guiTableConfigurationBuilder
            ->setDataSourceUrl(static::DATA_URL)
            ->setDefaultPageSize(25);

        return $guiTableConfigurationBuilder->createConfiguration();
    }

    protected function addColumns(GuiTableConfigurationBuilderInterface $guiTableConfigurationBuilder
    ): GuiTableConfigurationBuilderInterface {
        $guiTableConfigurationBuilder
            ->addColumnText(static::COL_KEY_ID_CUSTOMER, 'Reference', true, false)
            ->addColumnText(static::COL_KEY_EMAIL, 'Email', true, true)
            ->addColumnText(static::COL_KEY_LAST_NAME, 'Last Name', true, true)
            ->addColumnText(static::COL_KEY_FIRST_NAME, 'First Name', true, true)
            ->addColumnText(static::COL_KEY_STATUS, 'Status', true, true);

        return $guiTableConfigurationBuilder;
    }
}
