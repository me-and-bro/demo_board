<?php
	require_once("dbconfig.php");

	session_start();

	if(isset($_SESSION['user_id'] )) {

		$user_id = $_SESSION['user_id'];

		//$_POST['bno']이 있을 때만 $bno 선언
		if(isset($_POST['bno'])) {
			$bno = $_POST['bno'];
		}

		$bPassword = $_POST['bPassword'];

		$s_sql = 'select b_id from board where b_no = ' . $bno;
		$s_result = mysqli_query($db, $s_sql);
		$s_row = $s_result->fetch_assoc();

?>

		<script>
			alert("<?php echo $user_id?>");
		</script>


<?php
		

		if($s_row['b_id'] != $user_id){
			$msg = '자신이 생성한 글만 삭제할 수 있습니다.';
?>
			<script>
				alert("<?php echo $msg?>");
				history.back();
			</script>
<?php
			exit;
		}


		//글 삭제
		if(isset($bno)) {
			//삭제 할 글의 비밀번호가 입력된 비밀번호와 맞는지 체크
			$sql = 'select count(u_pw) as cnt from users, board where u_id = b_id and u_pw=password("' . $bPassword . '") and b_no = ' . $bno;
			$result = mysqli_query($db, $sql);
			$row = $result->fetch_assoc();
	
			//비밀번호가 맞다면 삭제 쿼리 작성
			if($row['cnt']) {
				$sql = 'delete from board where b_no = ' . $bno;
			//틀리다면 메시지 출력 후 이전화면으로
			} else {
				$msg = '비밀번호가 맞지 않습니다.';
?>
				<script>
					alert("<?php echo $msg?>");
					history.back();
				</script>
<?php
			exit;
			}
		}

		$result = mysqli_query($db, $sql);
	
		//쿼리가 정상 실행 됐다면,
		if($result) {
			$msg = '정상적으로 글이 삭제되었습니다.';
			$replaceURL = './';
		} else {
			$msg = '글을 삭제하지 못했습니다.';
?>
			<script>
				alert("<?php echo $msg?>");
				history.back();
			</script>
<?php
			exit;
		}


?>
		<script>
			alert("<?php echo $msg?>");
			location.replace("<?php echo $replaceURL?>");
		</script>
<?php
	}else{
		$msg = '로그인이 필요합니다.'
?>

		<script>
			alert("<?php echo $msg?>");
			history.back();
		</script>
<?php
	}
?>