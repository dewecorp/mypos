<?php
session_start();
$_SESSION['probe'] = 'ok_'.time();
echo 'sessid='.session_id();