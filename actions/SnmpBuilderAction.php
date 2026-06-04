<?php
namespace Modules\SnmpBuilder\Actions;

use CController;
use CControllerResponseData;

class SnmpBuilderAction extends CController {

    public function init(): void {
        ini_set('display_errors', '1');
        error_reporting(E_ALL);
        if (method_exists($this, 'disableCsrfValidation')) {
            $this->disableCsrfValidation();
        } else if (method_exists($this, 'disableSIDValidation')) {
            $this->disableSIDValidation();
        }
    }

    protected function checkInput(): bool {
        return true;
    }

    protected function checkPermissions(): bool {
        return true;
    }

    protected function doAction(): void {
        $data = [];
        
        $response = new CControllerResponseData($data);
        $this->setResponse($response);
    }
}
