<?php

namespace Railken\Unicredit\IGFS_CG_API\mpi;

use Railken\Unicredit\IGFS_CG_API\BaseIgfsCg;
use Railken\Unicredit\IGFS_CG_API\IgfsUtils;
use Railken\Unicredit\IGFS_CG_API\IgfsMissingParException;

abstract class BaseIgfsCgMpi extends BaseIgfsCg
{
    public $shopID; // chiave messaggio

    public $xid;

    public function __construct()
    {
        parent::__construct();
    }

    protected function resetFields()
    {
        parent::resetFields();
        $this->shopID = null;

        $this->xid = null;
    }

    protected function checkFields()
    {
        parent::checkFields();
        if ($this->shopID == null || "" == $this->shopID) {
            throw new IgfsMissingParException("Missing shopID");
        }
    }

    protected function buildRequest()
    {
        $request = parent::buildRequest();
        $request = $this->replaceRequest($request, "{shopID}", $this->shopID);
        return $request;
    }

    protected function getServicePort()
    {
        return "MPIGatewayPort";
    }

    protected function parseResponseMap($response)
    {
        parent::parseResponseMap($response);
        // Opzionale
        $this->xid = IgfsUtils::getValue($response, "xid");
    }
}
