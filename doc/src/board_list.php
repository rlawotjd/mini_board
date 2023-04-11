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
    $now_page_temp=$_SERVER['REQUEST_URI'];
    $now_page= mb_substr( $now_page_temp,-1);
    // echo $now_page;
?>


<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="./css/test.css">
    <title>게시판</title>
</head>
<body>
    <div class="board_tabel">

        <table class='table table-striped'>
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
                    <td><?php echo $recode["board_no"]?></td>
                    <td><a href="./board_update.php?board_no=<?php echo $recode["board_no"]?>"><?php echo $recode["board_title"]?></a></td>
                    <td><?php echo $recode["board_write_date"]?></td>
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
        if ($now_page!=1) {
        ?>
            <a class='moving_botten' href="board_list.php?page_num=<?php echo $now_page-1?>">이전</a>
        <?php
        }
        ?>
        <?php $i=1;
        while ($i <= $max_page_num) {
            ?>
            <?php
            if ($now_page==$i) { 
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
        if ($now_page!=$max_page_num) {
        ?>
            <a class='moving_botten' href="board_list.php?page_num=<?php echo $now_page+1?>">다음</a>
        <?php
        }
        ?>
        <a class='moving_botten' href="board_list.php?page_num=<?php echo $max_page_num?>">끝으로</a>
    </div>
</body>
</html>