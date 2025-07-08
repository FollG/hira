<?php
var_dump(__DIR__);
if (is_file(__DIR__.'/'.$base_template.'_tpl/index.php')) {
    include_once __DIR__.'/'.$base_template.'_tpl/index.php';
} else {
    echo 'Template not found';
}