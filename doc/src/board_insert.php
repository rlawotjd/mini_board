<?php
    define("DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/");
    define( "URL_DB", DOC_ROOT."mini_board\doc\src\common\db_conn.php");
    define( "URL_HEADER", DOC_ROOT."mini_board/doc/src/board_header.php");
    include_once(URL_DB);

    $http_method = $_SERVER["REQUEST_METHOD"];

    if($http_method === "POST"){
        $post_arr = $_POST;
        
        $reseult_cnt = insert_board_info($post_arr);

        header( "Location: board_list.php" );
        exit();

    }

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/update.css">
    <title>게시글 작성</title>
</head>
<body>
<body>
    <div class="grid_center">
        <div></div>
        <div>
            <?include_once(URL_HEADER);?>
        </div>
        <div></div>
        <div></div>
        <form method='post' action='board_insert.php' class='update_main'>
            <div class="form-floating mb-3">
            <br>
            </div>
                <div class="mb-3">
                    <label for="title" class="form-label">게시글 제목</label>
                    <input type="text" class="form-control" id="title" placeholder="게시글 제목">
                </div>
            <br>
                <div class="mb-3">
                    <label for="contents" class="form-label">게시글 내용</label>
                    <input type="text" class="form-control" id="contents" placeholder="게시글 내용">
                </div>
            <br>
            <button type='submit' class="btn btn-secondary">확인</button>

            <a href='board_list.php'><input type='button' class="btn btn-secondary" value='취소'></input></a>
        </form>
    </div>
</body>
</html>