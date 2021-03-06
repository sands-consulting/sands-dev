<?php

namespace App\Libraries\VMWare;

class VMWare
{
    public function getVms()
    {
        $vms = [];
        app('remote')->into('vmware')->run('/bin/vim-cmd vmsvc/getallvms', function ($output) use (&$vms) {
            $outputs = explode("\n", $output);
            foreach ($outputs as $output) {
                if (strstr($output, 'Vmid')) {
                    continue;
                };
                $vm = [];
                $values = preg_split('/\s{2,}/', $output);
                if (count($values) > 3) {
                    $str = '';
                    app('remote')->into('vmware')->run('/bin/vim-cmd vmsvc/get.guest ' . $values[0], function ($output) use (&$str) {
                        $str = $str . $output;
                    });
                    $str = substr($str, 39, -1);
                    $str = preg_replace("/= \(.+\)/", "= ", $str);
                    $str = preg_replace("/\(vim.+\)/", "", $str);
                    $str = str_replace('<unset>', 'null', $str);
                    $str = preg_replace("/\s+=\s+/", ':', $str);
                    $parts = explode("\n", $str);
                    $parts = array_map(function ($part) {
                        $str = trim($part);
                        if ($str != '{' && $str != '}' && $str != '},' && $str != '[' && $str != ']' && $str != '],') {
                            $pos = strpos($str, ':');
                            $str = str_replace("\\", "\\\\", $str);
                            if ($pos !== false) {
                                $key = substr($str, 0, $pos);
                                $value = substr($str, $pos);
                                $str = '"' . $key . '"' . $value;
                                $count = substr_count($str, '"');
                                if (substr($str, 0, 2) == '""') {
                                    $str = substr(str_replace('":', ":", $str), 1);
                                }
                            }
                        }
                        return $str;
                    }, $parts);
                    $str = implode("\n", $parts);
                    $str = str_replace(',}', '}', $str);
                    $str = str_replace(',]', ']', $str);
                    $str = str_replace(',""', ',"', $str);
                    $str = str_replace(",\n}", "\n}", $str);
                    $data = json_decode($str);
                    if(is_object($data)) {
                        $data->id = $values[0];
                        $data->annotations = $values[5];
                    } else {
                        $data = (object)[];
                        $data->id = $values[0];
                        $data->annotations = '';
                        $data->guestState = 'API Error';
                    }
                    $vms[] = $data;
                }
            };
        });
        return $vms;
    }
}
