<?php
namespace Modules\SnmpBuilder\Actions;

use CController;
use CControllerResponseData;

class SnmpBuilderAction extends CController {

    public function init(): void {
        $this->disableCsrfValidation();
    }

    protected function checkInput(): bool {
        return true;
    }

    protected function checkPermissions(): bool {
        return $this->getUserType() >= USER_TYPE_ZABBIX_USER;
    }

    protected function doAction(): void {
        $data = [];
        
        $response = new CControllerResponseData($data);
        $response->setTitle(_('SNMP Builder'));
        $this->setResponse($response);
    }
}
