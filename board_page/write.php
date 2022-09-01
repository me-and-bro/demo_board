<?php
	require_once("dbconfig.php");

	session_start();

	if(!isset($_SESSION['user_id'] )) {
			$msg = '로그인이 필요합니다.';
		?>
		<script>
			alert("<?php echo $msg?>");
			history.back();
		</script>
<?php
	}else{

		$user_id = $_SESSION['user_id'];

		if(isset($_GET['bno'])){
			$bno = $_GET['bno'];
		}

		if(isset($bno)){
			$sql = 'select b_title, b_content, b_id from board where b_no =' . $bno;
			$result = mysqli_query($db, $sql);
			$row = $result->fetch_assoc();
		}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Change's Board</title>
	<link rel="stylesheet" href="./css/normalize.css" />
	<link rel="stylesheet" href="./css/board.css?ver=1.02" />
</head>
<body>
	<article class="boardArticle">
		<h3>자유게시판 글쓰기</h3>
		<div id="boardWrite">
			<form action="./write_update.php" method="post">
				<?php
				if(isset($bno)) {
					echo '<input type="hidden" name="bno" value="' . $bno . '">';
				}
				?>
				<table id="boardWrite">
						<caption class="readHide">자유게시판 글쓰기</caption>
					<tbody>
						<tr>
							<th scope="row"><label for="bID">아이디</label></th>
							<td class="id">
								<?php
								if(isset($bno)) {
									echo $row['b_id'];
								} else { 
									echo $user_id; //<input type="text" name="bID" id="bID">
							        } ?>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="bTitle">제목</label></th>
							<td class="title">
							<input type="text" name="bTitle" id="bTitle" value="<?php echo isset($row['b_title'])?$row['b_title']:null?>">
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="bContent">내용</label></th>
							<td class="content">
							<textarea name="bContent" id="bContent" 
							<?php echo isset($row['b_content'])?$row['b_content']:null?>>
							</textarea></td>
						</tr>
					</tbody>
				</table>
				<div class="btnSet">
					<button type = "submit" class="btnSubmit btn">
						<?php echo isset($bno)?'수정':'작성'?> 
					</button>
					<a href="./index.html" class="btnList btn">목록</a>
				</div>
			</form>
		</div>
	</article>
</body>
</html>

<?php } // 세션 if else문 끝?>