<?php
require_once dirname(__FILE__) . '/../../../include/config.inc.php';

header('Content-Type: application/json');

$global_macros = [];
try {
    $global_macros_resp = API::UserMacro()->get(['globalmacro' => true, 'output' => 'extend']);
    if ($global_macros_resp) {
        foreach ($global_macros_resp as $gm) {
            $global_macros[$gm['macro']] = $gm['value'];
        }
    }
} catch (Exception $e) {}

$params = [
    'output' => ['hostid', 'host', 'name'],
    'selectInterfaces' => ['interfaceid', 'ip', 'type', 'details', 'available', 'error'],
    'selectMacros' => 'extend',
    'selectGroups' => ['name'],
    'filter' => ['status' => 0],
];

try {
    $hosts = API::Host()->get($params);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}

$hosts_output = [];
foreach ($hosts as $host) {
    $host_macros = [];
    if (isset($host['macros'])) {
        foreach ($host['macros'] as $m) {
            if (isset($m['value'])) {
                $host_macros[$m['macro']] = $m['value'];
            }
        }
    }

    foreach ($host['interfaces'] as $iface) {
        if ($iface['type'] == 2) {
            $snmp_details = $iface['details'] ?? [];
            $community = $snmp_details['community'] ?? 'public';
            
            if (preg_match('/^{\$.+}$/', $community)) {
                if (isset($host_macros[$community])) {
                    $community = $host_macros[$community];
                } elseif (isset($global_macros[$community])) {
                    $community = $global_macros[$community];
                }
            }

            $group_name = 'Zabbix Host';
            if (!empty($host['groups'])) {
                foreach ($host['groups'] as $g) {
                    if (stripos($g['name'], 'Templates') === false) {
                        $group_name = $g['name'];
                        break;
                    }
                }
            }

            $hosts_output[] = [
                'name' => $host['name'],
                'ip' => $iface['ip'],
                'version' => $snmp_details['version'] ?? '2',
                'community' => $community,
                'group' => $group_name,
                'available' => $iface['available'], 
                'error' => $iface['error']
            ];
        }
    }
}

$unique_hosts = [];
foreach ($hosts_output as $h) {
    $key = $h['ip'] . $h['community'];
    if (!isset($unique_hosts[$key])) {
        $unique_hosts[$key] = $h;
    }
}

echo json_encode(['result' => array_values($unique_hosts)]);
