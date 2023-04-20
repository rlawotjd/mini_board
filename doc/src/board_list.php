<?php
    define("DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/mini_board/doc/src/");
    define( "URL_DB", DOC_ROOT."common/db_conn.php");
    define( "URL_HEADER", DOC_ROOT."board_header.php");
    include_once(URL_DB);
    
    $http_method = $_SERVER["REQUEST_METHOD"];

    if(array_key_exists("page_num",$_GET)){
        $page_num = $_GET["page_num"];
    }
    else{
        $page_num =1;
    }

    $limit_num = 5;
    $limit_butten =5;
    $min_butten=ceil($page_num-($limit_butten/2));
    $max_butten=floor($page_num+($limit_butten/2));
    
    $offset=$limit_num * ($page_num-1);
    
    $result_cnt = select_board_info_count(); //활성화된 전체 카운트
    
    $max_page_num=ceil($result_cnt[0]["cnt"]/$limit_num);
    $end_butten_page=$max_page_num-$limit_butten;
    
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
            <div class='button_move'>
            <?include_once(URL_HEADER);?>
            <a href="./board_insert.php"><button type="button" class='moving_botten'>게시글 작성</button></a>
        </div>
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
        <?php
            if ($page_num<=$limit_butten) {
                for ($i=1; $i <= $limit_butten; $i++) { 
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
                }
            }
            elseif($end_butten_page<=$page_num && $page_num<=$max_page_num){
                for ($i=$end_butten_page; $i <= $max_page_num; $i++) { 
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
                }
            }
            elseif ($page_num>$limit_butten && $page_num<=$max_page_num) {
                for ($i=$min_butten; $i <= $max_butten; $i++) { 
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
                }
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