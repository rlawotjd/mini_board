<?php
    define("DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/");
    define( "URL_DB", DOC_ROOT."mini_board\doc\src\common\db_conn.php");
    include_once(URL_DB);

    $arr_get=$_GET;

    $resert_del=update_del_flg($arr_get["board_no"]);

    header("Location: board_list.php");
    exit();
?>
<!-- 
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>delete</title>
</head>
<body>
    <h1>진짜로 삭제하겠습니까?</h1>
    <p>삭제를 원하시면 게시글 번호를 입력해주세요.</p>
    <label for="del_inp">삭제할 게시글 번호</label>
    <input type="text" name="user_board_no_inp" id="del_inp">
    <button type="submit">submit</button>
</body>
</html> -->