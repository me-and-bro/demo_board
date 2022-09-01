<?php

	require_once("dbconfig.php");

	session_start();

	if(isset($_POST["login_submit"]) && isset($_POST["login_id"]) && isset($_POST["login_pw"])){
		$user_id = $_POST["login_id"]; // 유저가 입력한 아이디
		$user_pw = $_POST["login_pw"]; // 유저가 입력한 비밀번호

		if($_POST["login_id"] = ""){
			?> 	<script>
					alert('아이디를 입력하세요.');
					history.back();
				</script>	<?php
		}
			
		if($_POST["login_pw"] = ""){
			?> 	<script>
					alert('패스워드를 입력하세요.');
					history.back();
				</script>	<?php
		}

	$sql = 'select count(*) as cnt from users where u_id = "' . $user_id . '" and u_pw = password("'. $user_pw .'")';

	$result = mysqli_query($db, $sql);

	}
	
	if(!$result){
		echo "Query Error!";

	}else{
		
		if($result == 0){
			?>
			<script>
				alert("존재하지 않는 id 혹은 pw 입니다");
				history.back();
			</script>

			<?php
		}else{
			$_SESSION['user_id'] = $user_id;
?>
			<script>
				location.href = "./index.html";
			</script>
<?php
		}
	}

?>