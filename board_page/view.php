<?php
	require_once("dbconfig.php");

	session_start();

	if(isset($_SESSION['user_id'] )) {

		$bno = $_GET['bno'];

		if(!empty($bno) && empty($_COOKIE['board_' . $bno])) {
			$sql = 'update board set b_hit = b_hit + 1 where b_no = ' . $bno;
			$result = mysqli_query($db, $sql); 
			if(empty($result)) {
?>
				<script>
					alert('오류가 발생했습니다.');
					history.back();
				</script>
<?php 
			} else {
				setcookie('board_' . $bNo, TRUE, time() + (60 * 60 * 24), '/');
			}
		}

		$sql = 'select b_title, b_content, b_date, b_hit, b_id from board where b_no = ' . $bno;
		$result = mysqli_query($db, $sql);
		$row = $result->fetch_assoc();

	}else {

			//세션 없으면 메시지 출력 후 이전화면으로

			$msg = '로그인이 필요합니다.';
?>
		<script>
			alert("<?php echo $msg?>");
			history.back();
		</script>

<?php
			exit;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Change's Board</title>
	<link rel="stylesheet" href="./css/normalize.css" />
	<link rel="stylesheet" href="./css/board.css?ver=1.01" />
</head>
<body>
	<article class="boardArticle">
		<h3>자유게시판 글쓰기</h3>
		<br>
		<div id="boardView">
			<h3 id="boardTitle"><?php echo $row['b_title']?></h3>
			<div id="boardInfo">
				<span id="boardID">작성자: <?php echo $row['b_id']?>&nbsp&nbsp</span>
				<span id="boardDate">작성일: <?php echo $row['b_date']?>&nbsp&nbsp</span>
				<span id="boardHit">조회: <?php echo $row['b_hit']?></span>
			</div>
			<br>
			<div id="boardContent"><?php echo $row['b_content']?></div>

			<div class="btnSet">
				<a href="./write.php?bno=<?php echo $bno?>"> 수정 </a>
				<a href="./delete.php?bno=<?php echo $bno?>"> 삭제 </a>
				<a href="./"> 목록 </a>
			</div>
		</div>
	</article>
</body>
</html>