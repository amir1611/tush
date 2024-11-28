<?php
function func_confirm_locaion() {
    return true;
}

function inc_init_session() {
    if(!session_id()) {
        session_start();
    }
}

function inc_print_page_head() {
    return true;
}

function func_cp($source, $prefix) {
    $destination = tempnam(sys_get_temp_dir(), $prefix);
    if (copy($source, $destination)) {
        return $destination;
    }
    return false;
}

function write_ini_file($array, $file) {
    $res = array();
    foreach($array as $key => $val) {
        if(is_array($val)) {
            $res[] = "[$key]";
            foreach($val as $skey => $sval) {
                $res[] = "$skey = ".(is_numeric($sval) ? $sval : '"'.$sval.'"');
            }
        } else {
            $res[] = "$key = ".(is_numeric($val) ? $val : '"'.$val.'"');
        }
    }
    return file_put_contents($file, implode("\r\n", $res));
}

function mask2prefix($mask) {
    $long = ip2long($mask);
    $base = ip2long('255.255.255.255');
    return 32-log(($long ^ $base)+1,2);
}