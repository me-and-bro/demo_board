<?php
	require_once("dbconfig.php");

	session_start();

	//$_POST['bno']이 있을 때만 $bno 선언
	if(isset($_POST['bno'])) {
		$bno = $_POST['bno'];
	}

	
	// bno이 없다면(글 쓰기라면) 변수 선언
	if(empty($bno)) {
		$date = date('Y-M-D H:i:s');
	}

	// 고정변수
	$bTitle = $_POST["bTitle"];
	$bContent = $_POST["bContent"];
	

	// 글 수정부
	if(isset($bno)) {

		//수정 할 글의 비밀번호가 입력된 비밀번호와 맞는지 체크 -> 세션 체크로 대체
		if(isset($_SESSION['user_id'] )) {
		
			//$user_id = $_SESSION['user_id'];
			$sql = 'update board set b_title="' . $bTitle . '", b_content="' . $bContent . '" where b_no = ' . $bno;
			$msgState = '수정';
		
		} else {

			//세션 없으면 메시지 출력 후 이전화면으로

			$msg = '세션이 없습니다.';
	?>
		<script>
			alert("<?php echo $msg?>");
			history.back();
		</script>

	<?php
			exit;
		}

	// 글 등록부
	} else {
		if(isset($_SESSION['user_id'] )) {
			$user_id = $_SESSION['user_id'];
			$sql = 'insert into board (b_title, b_content, b_date, b_id) values("' . $bTitle . '", "' . $bContent . '", sysdate(), "' . $user_id . '")';
			$msgState = '등록';

		}else {

			//세션 없으면 메시지 출력 후 이전화면으로

			$msg = '세션이 없습니다.';
	?>
		<script>
			alert("<?php echo $msg?>");
			history.back();
		</script>

	<?php
			exit;
		}

	}

	//메시지가 없다면 (오류가 없다면)
	if(empty($msg)) {
		$result = mysqli_query($db, $sql);


		if($result) { // query가 정상실행 되었다면,
			$msg = '정상적으로 글이 ' . $msgState . '되었습니다.';
			if(empty($bno)) {
				$bno = $db->insert_id;
			}

			$replaceURL = './view.php?bno=' . $bno;
		} else {
			$msg = '글을 ' . $msgState . '하지 못했습니다.';
?>
		<script>
			alert("<?php echo $msg?>");
			history.back();
		</script>
<?php
			exit;
		}
	}
?>

<script>
	alert("<?php echo $msg?>");
	location.replace("<?php echo $replaceURL?>");
</script>