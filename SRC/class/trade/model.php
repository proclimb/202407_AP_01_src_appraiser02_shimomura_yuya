<?php

function fnSqlTradeList($flg, $param)
{
    switch ($flg) {
        case 0:
            $select = "SELECT COUNT(*)";
            $order = "";
            $limit = "";
            break;
        case 1:
            $select = "SELECT TRADENO, NAME, BRANCH, ZIP, PREFECTURE, ADDRESS1, ADDRESS2, TEL, FAX, MOBILE";
            // 並び替えとデータ抽出数
            if ($param["orderBy"]) {
                $order = " ORDER BY " . $param["orderBy"] . " " . $param["orderTo"];
            }
            $limit = " LIMIT " . (($param["sPage"] - 1) * PAGE_MAX) . ", " . PAGE_MAX;
            break;
    }
    $from = " FROM TBLTRADE";
    $where = " WHERE DEL = " . $param["sDel"];
    if ($param["sName"]) {
        $where .= " AND NAME LIKE '%" . $param["sName"] . "%'";
    }
    if ($param["sBranch"]) {
        $where .= " AND BRANCH LIKE '%" . $param["sBranch"] . "%'";
    }
    if ($param["sZip"]) {
        $where .= " AND ZIP LIKE '%" . $param["sZip"] . "%'";
    }
    if ($param["sPrefecture"]) {
        $where .= " AND PREFECTURE LIKE '%" . $param["sPrefecture"] . "%'";
    }
    if ($param["sAddress1"]) {
        $where .= " AND ADDRESS1 LIKE '%" . $param["sAddress1"] . "%'";
    }
    if ($param["sAddress2"]) {
        $where .= " AND ADDRESS2 LIKE '%" . $param["sAddress2"] . "%'";
    }
    if ($param["sTel"]) {
        $where .= " AND TEL LIKE '%" . $param["sTel"] . "%'";
    }
    if ($param["sFax"]) {
        $where .= " AND FAX LIKE '%" . $param["sFax"] . "%'";
    }
    if ($param["sMobile"]) {
        $where .= " AND MOBILE LIKE '%" . $param["sMobile"] . "%'";
    }

    return $select . $from . $where . $order . $limit;
}

function fnSqlTradeEdit($tradeNo)
{
    $select  = "SELECT NAME,NAMEFURI,BRANCH,BRANCHFURI,ZIP,PREFECTURE,ADDRESS1,ADDRESS2,TEL,FAX,MOBILE,INTERIOR,DEL";
    $from = " FROM TBLTRADE";
    $where = " WHERE TRADENO = $tradeNo";

    return $select . $from . $where;
}

//
//業者一覧情報更新
//
function fnSqlTradeUpdate($param)
{
    $sql  = "UPDATE TBLTRADE";
    $sql .= " SET NAME = '" . $param["name"] . "'";
    $sql .= ",NAMEFURI = '" . $param["nameFuri"] . "'";
    $sql .= ",BRANCH = '" . $param["branch"] . "'";
    $sql .= ",BRANCHFURI = '" . $param["branchFuri"] . "'";
    $sql .= ",ZIP = '" . $param["zip"] . "'";
    $sql .= ",PREFECTURE = '" . $param["prefecture"] . "'";
    $sql .= ",ADDRESS1 = '" . $param["address1"] . "'";
    $sql .= ",ADDRESS2 = '" . $param["address2"] . "'";
    $sql .= ",TEL = '" . $param["tel"] . "'";
    $sql .= ",FAX = '" . $param["fax"] . "'";
    $sql .= ",MOBILE = '" . $param["mobile"] . "'";
    $sql .= ",INTERIOR = '" . $param["interior"] . "'";
    $sql .= ",UPDT = CURRENT_TIMESTAMP";
    $sql .= ",DEL = '" . $param["del"] . "'";
    $sql .= " WHERE TRADENO = " . $param["tradeNo"];

    return ($sql);
}

//
//業者一覧情報登録
//
function fnSqlTradeInsert($param)
{
    $sql  = "INSERT INTO TBLTRADE(";
    $sql .= "TRADENO,NAME,NAMEFURI,BRANCH,BRANCHFURI,ZIP,PREFECTURE,ADDRESS1,ADDRESS2,TEL,FAX,MOBILE,INTERIOR,INSDT,UPDT,DEL";
    $sql .= ")VALUES(";
    $sql .= "'" . $param["tradeNo"] . "','" . $param["name"] . "','" . $param["nameFuri"] . "','" . $param["branch"] . "','" . $param["branchFuri"] . "','" . $param["zip"] . "','" . $param["prefecture"] . "','" . $param["address1"] . "','" . $param["address2"] . "','" . $param["tel"] . "','" . $param["fax"] . "','" . $param["mobile"] . "','" . $param["interior"] . "'," . "CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,1)";

    return ($sql);
}

//
//業者一覧情報削除
//
function fnSqlTradeDelete($tradeNo)
{
    $sql  = "UPDATE TBLTRADE";
    $sql .= " SET DEL = -1";
    $sql .= ",UPDT = CURRENT_TIMESTAMP";
    $sql .= " WHERE TRADENO = '$tradeNo'";

    return ($sql);
}
