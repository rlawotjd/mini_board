<?php

function db_conn(&$param_conn)
{
    $host = "localhost";
    $user = "root";
    $pass = "root506";
    $charset = "utf8mb4";
    $db_name="board";
    $dns = "mysql:host=".$host.";dbname=".$db_name.";charset=".$charset;
    $pdo_option = 
    array(
        PDO::ATTR_EMULATE_PREPARES      =>false
        ,PDO::ATTR_ERRMODE              => PDO::ERRMODE_EXCEPTION
        ,PDO::ATTR_DEFAULT_FETCH_MODE   =>PDO::FETCH_ASSOC
    );

    try {
        $param_conn = new PDO($dns, $user, $pass, $pdo_option);

    } catch (Exception $e) {
        $param_conn=null;
        throw new Exception($e->getMessage());
    }
}

function select_board_info_paging(&$param_arr)
{
    $sql=
        " SELECT "
        ." board_no "
        ." ,board_title "
        ." ,board_write_date "
    ." FROM "
        ." board_info "
    ." WHERE "
        ."board_del_flg = '0' "
    ." ORDER BY "
        ." board_no DESC "
    ." LIMIT :limit_count OFFSET :offset "
    ;
    
    $arr_prepare =
    array(
        ":limit_count" => $param_arr["limit_count"]
        ,":offset"      => $param_arr["offset"]
    );
    
    $conn = null;
    
    try {
        db_conn($conn);
        $stmt = $conn ->prepare($sql);
        $stmt->execute($arr_prepare);
        $result = $stmt->fetchAll();
        
        
    } catch (Exception $e) {
        return $e->getMessage();
    }
    finally{
        $conn =null;
    }
    
    return $result;
}

function select_board_info_count()
{
    $sql =
    " SELECT "
    ." COUNT(*) as cnt "
    ." FROM "
    ." board_info "
    ." where "
    ." board_del_flg = '0' "
    ;
    $arr_prepare = array(
        // ":board_del_flg" => $param_flg //이상,,,,
    );

    $conn =null;

    try {
        db_conn($conn);
        $stmt = $conn ->prepare($sql);
        $stmt->execute($arr_prepare);
        $result = $stmt->fetchAll();
        
        
    } catch (Exception $e) {
        return $e->getMessage();
    }
    finally{
        $conn =null;
    }
    
    return $result;
}
function select_board_info_allcount()
{
    $sql =
    " SELECT "
    ." COUNT(*) as cnt "
    ." FROM "
    ." board_info "
    ;
    $arr_prepare = array(
        // ":board_del_flg" => $param_flg //이상,,,,
    );

    $conn =null;

    try {
        db_conn($conn);
        $stmt = $conn ->prepare($sql);
        $stmt->execute($arr_prepare);
        $result = $stmt->fetchAll();
        
        
    } catch (Exception $e) {
        return $e->getMessage();
    }
    finally{
        $conn =null;
    }
    
    return $result;
}

function select_board_info_no(&$param_no)
{
    $sql=
    " SELECT " 
        ." board_title "
        ." ,board_contents "
        ." ,board_no "
        ." ,board_write_date " //0412 작성일 추가
    ." FROM "
        ." board_info "
    ." WHERE "
        ." board_del_flg = '0' "
        ." AND "
        ." board_no = :board_no "
        ;
    
    $arr_prepare =
    array(
        ":board_no" => $param_no
    );
    
    $conn = null;
    
    try {
        db_conn($conn);
        $stmt = $conn ->prepare($sql);
        $stmt->execute($arr_prepare);
        $result = $stmt->fetchAll();
        
        
    } catch (Exception $e) {
        return $e->getMessage();
    }
    finally{
        $conn =null;
    }
    
    return $result[0];
}

function update_board_info_no(&$param_arr)
{
    $sql=
    " UPDATE "
        ." board_info "
    ." SET "
    ." board_title =:board_title "
    ." ,board_contents= :board_contents "
    ." WHERE "
    ." board_no =:board_no "
    ;
    
    $arr_prepare =
    array(
        ":board_title" => $param_arr["board_title"]
        ,":board_contents" => $param_arr["board_contents"]
        ,":board_no" => $param_arr["board_no"]
    );
    
    $conn = null;
    
    try {
        db_conn($conn);
        $conn->beginTransaction();
        $stmt = $conn ->prepare($sql);
        $stmt->execute($arr_prepare);
        
        $result_count = $stmt->rowCount();
        $conn->commit();
        
        
        
    } catch (Exception $e) {
        $conn->rollBack();
        return $e->getMessage();
    }
    finally{
        $conn =null;
    }
    
    return $result_count;
}
function update_del_flg(&$param_arr)
{
    $sql=
    " UPDATE "
        ." board_info "
    ." SET "
    ." board_del_flg='1' "
    ." ,board_del_date=NOW() "
    ." WHERE "
    ." board_no =:board_no "
    ;
    
    $arr_prepare =
    array(
        ":board_no" => $param_arr
    );
    
    $conn = null;
    
    try {
        db_conn($conn);
        $conn->beginTransaction();
        $stmt = $conn ->prepare($sql);
        $stmt->execute($arr_prepare);
        
        $result_count = $stmt->rowCount();
        $conn->commit();
        
        
        
    } catch (Exception $e) {
        $conn->rollBack();
        return $e->getMessage();
    }
    finally{
        $conn =null;
    }
    
    return $result_count;
}

function insert_board_info(&$param_arr)
{
    $sql=
    "INSERT INTO board_info("
        ." board_title "
        ." ,board_contents "
        ." ,board_write_date "
        // ." ,board_no "   
        ." ) "
    ." VALUES( "
        ." :board_title "
        ." ,:board_contents "
        ." ,NOW() "
        // ." ,:board_no "
        ." ) "
        ;
    
    $arr_prepare =
    array(
        ":board_title"     => $param_arr["board_title"]
        ,":board_contents"  => $param_arr["board_contents"]
        // ,"board_write_date" => $param_arr["board_write_date"]
        // ,":board_no"         => $param_arr["board_no"]
    );
    
    $conn = null;
    
    try {
        db_conn($conn);
        $conn->beginTransaction();
        $stmt = $conn ->prepare($sql);
        $stmt->execute($arr_prepare);
        
        $result_count = $stmt->rowCount();
        $conn->commit();
        
        
        
    } catch (Exception $e) {
        $conn->rollBack();
        return $e->getMessage();
    }
    finally{
        $conn =null;
    }
    
    return $result_count;
}


//todo : test start

// var_dump( select_board_info_count());
// var_dump( select_board_info_allcount());

//todo : test end