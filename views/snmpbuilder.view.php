<?php
/**
 * @var CView $this
 * @var array $data
 */

(new CHtmlPage())
    ->addItem(
        (new CDiv())
            ->addClass('snmp-container')
            ->addStyle('height: calc(100vh - 200px); min-height: 600px; width: 100%;')
            ->addItem(
                (new CTag('iframe', true, ''))
                    ->setAttribute('src', 'modules/snmpbuilder/assets/332.html')
                    ->setAttribute('style', 'width: 100%; height: 100%; border: none;')
            )
    )
    ->show();
