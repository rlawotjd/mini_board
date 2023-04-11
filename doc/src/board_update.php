<?php
    define("DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/");
    define( "URL_DB", DOC_ROOT."mini_board\doc\src\common\db_conn.php");
    include_once(URL_DB);

    $http_method = $_SERVER["REQUEST_METHOD"];

    if ($http_method==="GET") {
        $board_no=1;
        if(array_key_exists("board_no",$_GET)){
            $board_no = $_GET["board_no"];
        }
        $result_info=select_board_info_no($board_no);
    }
    else{
        $arr_post =$_POST;
        $arr_info =
            array(
                "board_title" => $arr_post["board_title"]
                ,"board_contents" => $arr_post["board_contents"]
                ,"board_no" => $arr_post["board_no"]
            );

        $result_cnt = update_board_info_no($arr_info);

        $result_info=select_board_info_no($arr_post["board_no"]);
    }

    $limit_num=5;

    $result_all_cnt = select_board_info_count(); //전체 카운트

    $max_page_num=ceil($result_all_cnt[0]["cnt"]/$limit_num);

    echo ceil($result_info["board_no"]/$limit_num)

    // print_r($result_info);
?>
<!DOCTYPE html>
<html lang='ko'>
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>게시판</title>
</head>
<body>
    <form method='post' action='board_update.php'>

        <label for="no">게시글 번호 : </label>
        <input type='text' name='board_no' id='no' value='<? echo $result_info["board_no"]?>' readonly>
        <br>
        <label for='title'>게시글 제목 : </label>
        <input type='text' name='board_title' id='title' value='<? echo $result_info["board_title"]?>'>
        <br>
        <label for='content'>게시글 내용 : </label>
        <input type='text' name='board_contents' id='content' value='<? echo $result_info["board_contents"]?>'>
        <br>
        <button type='submit'>수정</button>
        <a href='board_list.php?page_num=<?php echo ceil(($result_all_cnt[0]["cnt"]-$result_info["board_no"]+1)/$limit_num)?>'><input type='button' value='리스트'></input></a>
    </form>
</body>
</html>