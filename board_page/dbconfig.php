<?php

	$db = mysqli_connect("localhost", "root", "change");	
	
	if(mysqli_connect_errno()) {
		die('데이터베이스 연결에 문제가 있습니다.?> <br> <?관리자에게 문의 바랍니다.');
	}

	mysqli_select_db($db, "change_board");

	$db->set_charset("utf8");

?>