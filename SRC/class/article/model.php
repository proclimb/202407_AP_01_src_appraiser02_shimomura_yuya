<?php
//
//物件管理リスト
//
function fnSqlArticleList($flg, $param)
{
    switch ($flg) {
        case 0:
            $select  = "SELECT COUNT(*)";
            $order = "";
            $limit = "";
            break;
        case 1:
            $select  = "SELECT ARTICLENO, ARTICLE, ROOM, KEYPLACE, ARTICLENOTE, KEYBOX, DRAWING, SELLCHARGE";
            // 並び替えとデータ抽出数
            if ($param["orderBy"]) {
                $order = " ORDER BY " . $param["orderBy"] . " " . $param["orderTo"];
            }
            $limit = " LIMIT " . (($param["sPage"] - 1) * PAGE_MAX) . ", " . PAGE_MAX;
            break;
    }
    $from = " FROM TBLARTICLE";
    $where = " WHERE DEL = " . $param["sDel"];
    if ($param["sArticle"]) {
        $where .= " AND ARTICLE LIKE '%" . $param["sArticle"] . "%'";
    }
    if ($param["sRoom"]) {
        $where .= " AND ROOM LIKE '%" . $param["sRoom"] . "%'";
    }
    if ($param["sKeyPlace"]) {
        $where .= " AND KEYPLACE LIKE '%" . $param["sKeyPlace"] . "%'";
    }
    if ($param["sArticleNote"]) {
        $where .= " AND ARTICLENOTE LIKE '%" . $param["sArticleNote"] . "%'";
    }
    if ($param["sKeyBox"]) {
        $where .= " AND KEYBOX LIKE '%" . $param["sKeyBox"] . "%'";
    }
    if ($param["sDrawing"]) {
        $where .= " AND DRAWING LIKE '%" . $param["sDrawing"] . "%'";
    }
    if ($param["sSellCharge"]) {
        $where .= " AND SELLCHARGE LIKE '%" . $param["sSellCharge"] . "%'";
    }

    return $select . $from . $where . $order . $limit;
}

//
//物件管理情報
//
function fnSqlArticleEdit($articleNo)
{
    $select  = "SELECT ARTICLE, ROOM, KEYPLACE, ADDRESS, ARTICLENOTE, KEYBOX, DRAWING, SELLCHARGE, DEL";
    $from = " FROM TBLARTICLE";
    $where = " WHERE ARTICLENO = $articleNo";

    return $select . $from . $where;
}

//
//物件管理情報更新
//
function fnSqlArticleUpdate($param)
{
    $sql  = "UPDATE TBLARTICLE";
    $sql .= " SET ARTICLE = '" . $param["article"] . "'";
    $sql .= ",ROOM = '" . $param["room"] . "'";
    $sql .= ",KEYPLACE = '" . $param["keyPlace"] . "'";
    $sql .= ",ADDRESS = '" . $param["address"] . "'";
    $sql .= ",ARTICLENOTE = '" . $param["articleNote"] . "'";
    $sql .= ",KEYBOX = '" . $param["keyBox"] . "'";
    $sql .= ",DRAWING = '" . $param["drawing"] . "'";
    $sql .= ",SELLCHARGE = '" . $param["sellCharge"] . "'";
    $sql .= ",UPDT = CURRENT_TIMESTAMP";
    $sql .= ",DEL = '" . $param["del"] . "'";
    $sql .= " WHERE ARTICLENO = " . $param["articleNo"];

    return ($sql);
}



//
//物件管理情報登録
//
function fnSqlArticleInsert($param)
{
    $sql  = "INSERT INTO TBLARTICLE (";
    $sql .= " ARTICLENO, ARTICLE, ROOM, KEYPLACE, ADDRESS, ARTICLENOTE, KEYBOX, DUEDT, SELLCHARGE, AREA, YEARS, SELLPRICE, INTERIORPRICE, CONSTTRADER,"
        . " CONSTPRICE, CONSTADD, CONSTNOTE, PURCHASEDT, WORKSTARTDT, WORKENDDT, LINEOPENDT, LINECLOSEDT, RECEIVE, HOTWATER, SITEDT, LEAVINGFORM,"
        . " LEAVINGDT, MANAGECOMPANY, FLOORPLAN, FORMEROWNER, BROKERCHARGE, BROKERCONTACT, INTERIORCHARGE, CONSTFLG1, CONSTFLG2, CONSTFLG3, CONSTFLG4, INSDT, UPDT, DEL,"
        . " DRAWING, LINEOPENCONTACTDT, LINECLOSECONTACTDT, LINECONTACTNOTE, ELECTRICITYCHARGE, GASCHARGE, LIGHTORDER";
    $sql .= " ) VALUES ( ";
    $sql .= "'" . $param["articleNo"] . "','" . $param["article"] . "','" . $param["room"] . "','" . $param["keyPlace"] . "','" . $param["address"] . "','" . $param["articleNote"] . "','" . $param["keyBox"] . "', '','" . $param["sellCharge"] . "', '', '', '', '', '',"
        . " '', '', '', '', '', '', '', '', '', '', '', '',"
        . " '', '', '', '', '', '', '', '', '', '', ''," . "CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, 1,"
        . " '" . $param["drawing"] . "', '', '', '', '', '', '' )";

    return ($sql);
}



//
//物件管理情報削除
//
function fnSqlArticleDelete($articleNo)
{
    $sql  = "UPDATE TBLARTICLE";
    $sql .= " SET DEL = -1";
    $sql .= ",UPDT = CURRENT_TIMESTAMP";
    $sql .= " WHERE ARTICLENO = '$articleNo'";

    return ($sql);
}
