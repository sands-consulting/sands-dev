<?php

namespace App\Http\Controllers;

use VMWare;

class DashboardController extends Controller
{
    public function getIps()
    {
        $arp_scan = shell_exec('sudo ' . env('ARP_SCAN_PATH', '/usr/bin/arp-scan') . ' -l -t 300');
        $arp_scan = explode("\n", $arp_scan);
        $ips = [];
        foreach ($arp_scan as $scan) {
            $matches = array();
            if (preg_match('/^([0-9\.]+)[[:space:]]+([0-9a-f:]+)[[:space:]]+(.+)$/', $scan, $matches) !== 1) {
                continue;
            }
            $ips[] = [
                'ip' => $matches[1],
                'mac' => $matches[2],
                'description' => $matches[3],
            ];
        }
        return $ips;
    }

    public function getVms()
    {
        return VMWare::getVms();
    }
    //
}
