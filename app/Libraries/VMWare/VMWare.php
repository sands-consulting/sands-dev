<?php

namespace App\Libraries\VMWare;

class VMWare
{
    public function getVms()
    {
        $vms = [];
        app('remote')->into('vmware')->run('/bin/vim-cmd vmsvc/getallvms', function ($output) use (&$vms) {
            if(strstr($output, 'Vmid')) {
                continue;
            };
            $vm = [];
            $values = preg_split('/\s{2,}/gi');
            $vms[] = $values;
        });
        return $vms;
    }
}
