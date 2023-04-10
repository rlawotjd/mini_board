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
?>


<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>게시판</title>
</head>
<body>
    <table class='table table-striped'>
        <thead>
            <tr>    
                <th>게시글 번호</th>
                <th>게시글 제목</th>
                <th>작성일</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($result_paging as $key => $recode) {
            ?>
                <tr>
                    <td><?php echo $recode["board_no"]?></td>
                    <td><?php echo $recode["board_title"]?></td>
                    <td><?php echo $recode["board_write_date"]?></td>
                </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
    <div>
        <?php $i=1;
        while ($i <= $max_page_num) {
            ?>
                <a href='board_list.php?page_num=<?php echo $i ?>'><?php echo $i //겟방식 ?></a>
                <?php
            $i++;
        }
        ?>
    </div>
</body>
</html>