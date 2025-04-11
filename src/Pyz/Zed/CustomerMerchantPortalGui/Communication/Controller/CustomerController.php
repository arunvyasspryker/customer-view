<?php


namespace Pyz\Zed\CustomerMerchantPortalGui\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class CustomerController extends \Spryker\Zed\Kernel\Communication\Controller\AbstractController
{
    public function indexAction(): array
    {
        $configuration = $this->getFactory()
            ->createCustomerGuiTableConfigurationProvider()
            ->getConfiguration();
//        dd($configuration);
        return $this->viewResponse([
            'customerTableConfiguration' => $configuration,
        ]);
    }

    public function tableDataAction(Request $request): Response
    {
        return $this->getFactory()->getGuiTableHttpDataRequestExecutor()->execute(
            $request,
            $this->getFactory()->createCustomerGuiTableDataProvider(),
            $this->getFactory()->createCustomerGuiTableConfigurationProvider()->getConfiguration()
        );
    }
}
