<?php
    define("DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/");
    define( "URL_DB", DOC_ROOT."mini_board\doc\src\common\db_conn.php");
    define( "URL_HEADER", DOC_ROOT."mini_board/doc/src/board_header.php");
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
        header("Location: board_detail.php?board_no=".$arr_post["board_no"]);
        exit(); //redirect이후 소스코드 실행필요없
    }

    $limit_num=5;

    $result_cnt = select_board_info_count(); //활성화된 카운트
    
    $result_allcnt = select_board_info_allcount(); //모든 카운트
    
    $max_page_num=ceil($result_cnt[0]["cnt"]/$limit_num);

    $move_list=ceil(($result_allcnt[0]["cnt"]-$result_info["board_no"])/$limit_num);

    // echo $result_info["board_no"],$result_allcnt[0]["cnt"];



    // print_r($result_info);

?>
<!DOCTYPE html>
<html lang='ko'>
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/update.css">
    <title>게시판</title>
</head>
<body>
    <div class="grid_center">
        <div></div>
        <div class='head'>
            <?include_once(URL_HEADER);?>
        </div>
        <div></div>
        <div></div>
        <form method='post' action='board_update.php' class='update_main'>
            <div class="mb-3">
                <label for="no" class="form-label">게시판 번호</label>
                <input type="text" class="form-control" id="no" placeholder="<? echo $result_info["board_no"]?>" readonly>
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">게시판 제목</label>
                <input type="text" class="form-control" id="title" placeholder="<? echo $result_info["board_title"]?>" >
            </div>
            <div class="mb-3">
                <label for="contents" class="form-label">게시판 제목</label>
                <input type="text" class="form-control" id="contents" placeholder="<? echo $result_info["board_contents"]?>" >
            </div>
            <button type='submit' class="btn btn-secondary">확인</button>
            <a href='board_detail.php?board_no=<?php echo $result_info["board_no"]?>'><input type='button' class="btn btn-secondary" value='수정취소'></input></a>
            <br>
            <br>
            <a href='board_list.php?page_num=<?php if ($result_allcnt[0]["cnt"]==$result_info["board_no"]) {echo 1;}else {echo $move_list;}?>'><input type='button' class="btn btn-secondary" value='리스트'></input></a>
        </form>
    </div>
    
</body>
</html>