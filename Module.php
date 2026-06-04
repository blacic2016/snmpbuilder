<?php
namespace Modules\SnmpBuilder;

use Zabbix\Core\CModule;
use APP;
use CMenuItem;

class Module extends CModule {
    public function init(): void {
        APP::Component()->get('menu.main')
            ->findOrAdd(_('Data collection'))
            ->getSubmenu()
            ->add((new CMenuItem(_('SNMP Builder')))->setAction('snmp.builder'));
    }
}
