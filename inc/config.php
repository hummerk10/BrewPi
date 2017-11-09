<?php

$mysql = array (
	'host'	=> 'tld-brewing-controller.cagl1o1xteok.us-east-1.rds.amazonaws.com',
	'user'	=> 'sec_user',
	'pass'	=> 'ye5hmt2QzqugZa94wqb7',
	'db'	=> 'TDLBrewingContoller'
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
