<?php
    define("DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/");
    define( "URL_DB", DOC_ROOT."mini_board\doc\src\common\db_conn.php");
    define( "URL_HEADER", DOC_ROOT."mini_board/doc/src/board_header.php");
    include_once(URL_DB);

    $arr_get=$_GET;
    $result_info = select_board_info_no($arr_get["board_no"]);

    
    $limit_num=5;

    $result_all_cnt = select_board_info_allcount(); //전체 카운트

    $max_page_num=ceil($result_all_cnt[0]["cnt"]/$limit_num);

    // echo ceil($result_info["board_no"]/$limit_num)
    ?>

    <!DOCTYPE html>
    <html lang="ko">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./css/detail.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
        <title>detail</title>
    </head>
    <body>
        <div class=grid_center>
            <div></div>
            <div calss='head'>
            <?include_once(URL_HEADER);?>
            </div>
            <div></div>
            <div></div>
            <div class=detail_main>
                <p>게시글 번호 : <?echo $result_info["board_no"]?></p>
                <p>게시글 작성일 : <?echo $result_info["board_write_date"]?></p>
                <p>게시글 제목 : <?echo $result_info["board_title"]?></p>
                <p>게시글 내용 : <?echo $result_info["board_contents"]?></p>
                <a href="board_update.php?board_no=<?php echo $result_info["board_no"]?>">
                    <button type="button" class="btn btn-secondary">수정</button>
                </a>
                <a href="board_delete.php?board_no=<?php echo $result_info["board_no"]?>">
                    <button type="button" class="btn btn-secondary">삭제</button>
                </a>
                <br>
                <br>
                <a href='board_list.php?page_num=<?php echo ceil(($result_all_cnt[0]["cnt"]-$result_info["board_no"]+1)/$limit_num)?>'><input type='button' class="btn btn-secondary" value='리스트'></input></a>
            </div>
        </div>
    </body>
    </html>