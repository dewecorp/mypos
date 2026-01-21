<?php

function check_already_login() {
    $ci =& get_instance();
    $user_session = $ci->session->userdata('userid');
    if($user_session) {
        redirect('sale');
    }
}

function check_not_login() {
    $ci =& get_instance();
    $user_session = $ci->session->userdata('userid');
    if(!$user_session) {
        redirect('auth/login');
    }
}

function check_admin() {
    $ci =& get_instance();
    $ci->load->library('fungsi');
    if($ci->fungsi->user_login()->level != 1) {
        redirect('dashboard');
    }
}

function indo_currency($nominal) {
    $result = "RP " . number_format($nominal, 2, '.', '.') ;
    return $result;
    }

function indo_date($date) {
    $d = substr($date,8,2);
    $m = substr($date,5,2);
    $y = substr($date,0,4);
    return $d.'/'.$m.'/'.$y;
    }

function time_ago($datetime, $timezone = 'Asia/Jakarta') {
    date_default_timezone_set($timezone);
    $ts = is_numeric($datetime) ? (int)$datetime : strtotime($datetime);
    $diff = time() - $ts;
    if ($diff < 5) return 'baru saja';
    if ($diff < 60) {
        $s = $diff;
        return $s.' detik yang lalu';
    }
    $diff = floor($diff / 60);
    if ($diff < 60) {
        $m = $diff;
        return $m.' menit yang lalu';
    }
    $diff = floor($diff / 60);
    if ($diff < 24) {
        $h = $diff;
        return $h.' jam yang lalu';
    }
    $d = floor($diff / 24);
    return $d.' hari yang lalu';
}

function format_tz($datetime, $timezone = 'Asia/Jakarta', $format = 'Y-m-d H:i:s') {
    $tz = new DateTimeZone($timezone);
    if (is_numeric($datetime)) {
        $dt = new DateTime('@'.$datetime);
        $dt->setTimezone($tz);
    } else {
        $dt = new DateTime($datetime);
        $dt->setTimezone($tz);
    }
    return $dt->format($format);
}
