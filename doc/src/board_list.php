<?php
    define("DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/");
    define( "URL_DB", DOC_ROOT."mini_board\doc\src\common\db_conn.php");
    include_once(URL_DB);
    
    $http_method = $_SERVER["REQUEST_METHOD"];

    if(array_key_exists("page_num",$_GET)){
        $page_num = $_GET["page_num"];
    }
    else{
        $page_num =1;
    }

    $limit_num = 5;

    $offset=$limit_num * ($page_num-1);
    
    $result_cnt = select_board_info_count(); //전체 카운트

    $max_page_num=ceil($result_cnt[0]["cnt"]/$limit_num);
    
    $arr_prepare=
        array(
            "limit_count" => $limit_num
            ,"offset"   => $offset
        );
    $result_paging = select_board_info_paging($arr_prepare);
    // print_r($result_cnt);
    // print_r($result_paging);
    // echo($max_page_num);
    // echo DOC_ROOT;
    // $now_page=$_GET['page_num']; //위에 페이지 넘버 있으면서 왜 새로 만드냐
    // $now_page_temp=$_GET['REQUEST_URI'];
    // $now_page= mb_substr( $now_page_temp,-1);
    // echo $now_page;
?>


<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="./css/list.css">
    <title>게시판</title>
</head>
<body>
    <div class="board_tabel">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <table class="table table-dark table-striped">
            <thead>
                <tr class='tabel_head'>    
                    <th>
                        <p>
                            게시글 번호
                        </p> 
                    </th>
                    <th>
                        <p>
                            게시글 제목
                        </p>
                    </th>
                <th>
                    <p>
                        작성일
                    </p>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($result_paging as $key => $recode) {
                    ?>
                <tr>
                    <td class="text_color"><?php echo $recode["board_no"]?></td>
                    <td class="text_color"><a href="./board_detail.php?board_no=<?php echo $recode["board_no"]?>"><?php echo $recode["board_title"]?></a></td>
                    <td class="text_color"><?php echo $recode["board_write_date"]?></td>
                </tr>
                <?php
                }
                ?>
        </tbody>
    </table>
    </div>
    <div class='botten'>
        <a class='moving_botten' href="board_list.php?page_num=1">처음으로</a>
        <?php
        if ($page_num!=1) {
        ?>
            <a class='moving_botten' href="board_list.php?page_num=<?php echo $page_num-1;?>">이전</a>
        <?php
        }
        ?>
        <?php $i=1;
        while ($i <= $max_page_num) {
            ?>
            <?php
            if ($page_num==$i) { 
                ?>
                <a 
                    href='board_list.php?page_num=<?php echo $i ?>' class ="taget_botten";>
                <?php echo $i ?>
                </a>
            <?
            }
            else {
                ?>
                <a href='board_list.php?page_num=<?php echo $i ?>' class="no_taget_botten">
                <?php echo $i ?>
                </a>
            <?
            }
            ?>
                <?php
            $i++;
        }
        ?>
        <?php 
        if ($page_num!=$max_page_num) {
        ?>
            <a class='moving_botten' href="board_list.php?page_num=<?php echo $page_num+1?>">다음</a>
        <?php
        }
        ?>
        <a class='moving_botten' href="board_list.php?page_num=<?php echo $max_page_num?>">끝으로</a>
    </div>
    <div></div>
</body>
</html>