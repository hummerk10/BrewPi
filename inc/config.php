<?php

$mysql = array (
	'host'	=> 'localhost',
	'user'	=> 'root',
	'pass'	=> 'mjwin101',
	'db'	=> 'Brewing'
);

$tbl_name="User"; // Table name

$required_user = array (
	'user_page'
);

$required_admin = array (
	'admin/main',
	'admin/users',
	'admin/del_user',
	'admin/reg_user',
	'admin/create_class',
	'admin/del_class'

);
