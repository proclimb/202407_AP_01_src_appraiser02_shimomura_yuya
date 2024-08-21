<?php
//
//工事管理リスト
//
function fnSqlConstList($flg, $param)
{
    switch ($flg) {
        case 0:
            $select  = "SELECT COUNT(*)";
            $order = "";
            $limit = "";
            break;
        case 1:
            $select  = "SELECT ARTICLENO, ARTICLE, ROOM, ADDRESS, CONSTTRADER, CONSTADD, RECEIVE, SELLCHARGE, INTERIORCHARGE, KEYPLACE, LIGHTORDER,"
                . "IF( INTERIORPRICE > 0, INTERIORPRICE, '' ) AS INTERIORPRICE,"
                . "IF( CONSTPRICE > 0, CONSTPRICE, '' ) AS CONSTPRICE,"
                . "IF( PURCHASEDT > '0000-00-00', DATE_FORMAT( PURCHASEDT, '%Y/%m/%d'), '' ) AS PURCHASEDT,"
                . "IF( WORKSTARTDT > '0000-00-00', DATE_FORMAT( WORKSTARTDT, '%Y/%m/%d'), '' ) AS WORKSTARTDT,"
                . "IF( WORKENDDT > '0000-00-00', DATE_FORMAT( WORKENDDT, '%Y/%m/%d'), '' ) AS WORKENDDT,"
                . "IF( LINEOPENDT > '0000-00-00', DATE_FORMAT( LINEOPENDT, '%Y/%m/%d'), '' ) AS LINEOPENDT,"
                . "IF( LINECLOSEDT > '0000-00-00',DATE_FORMAT( LINECLOSEDT,'%Y/%m/%d'),'') AS LINECLOSEDT,"
                . "IF( SITEDT > '0000-00-00', DATE_FORMAT( SITEDT,'%Y/%m/%d'), '' ) AS SITEDT,"
                . "IF( LINEOPENCONTACTDT > '0000-00-00', DATE_FORMAT( LINEOPENCONTACTDT, '%Y/%m/%d'), '' ) AS LINEOPENCONTACTDT,"
                . "IF( LINECLOSECONTACTDT > '0000-00-00',DATE_FORMAT( LINECLOSECONTACTDT,'%Y/%m/%d'),'') AS LINECLOSECONTACTDT";
            if ($param["orderBy"]) {
                $order = " ORDER BY " . $param["orderBy"] . " " . $param["orderTo"];
            }
            $limit = " LIMIT " . (($param["sPage"] - 1) * PAGE_MAX) . ", " . PAGE_MAX;
            break;
    }

    $from = " FROM TBLARTICLE";
    $where = " WHERE DEL = " . $param["sDel"];

    // 各項目の検索条件の抽出
    if ($param["sArticle"]) {
        $where .= " AND ARTICLE LIKE '%" . $param["sArticle"] . "%'";
    }
    if ($param["sRoom"]) {
        $where .= " AND ROOM LIKE '%" . $param["sRoom"] . "%'";
    }
    if ($param["sAddress"]) {
        $where .= " AND ADDRESS LIKE '%" . $param["sAddress"] . "%'";
    }
    if ($param["sConstTrader"]) {
        $where .= " AND CONSTTRADER LIKE '%" . $param["sConstTrader"] . "%'";
    }
    if ($param["sConstFlg1"] || $param["sConstFlg2"] || $param["sConstFlg3"] || $param["sConstFlg4"]) {
        $where .= " AND (";
        $tmp = "";
        if ($param["sConstFlg1"]) {
            $where .= "CONSTFLG1 = 1";
            $tmp = " OR ";
        }
        if ($param["sConstFlg2"]) {
            $where .= $tmp . "CONSTFLG2 = 1";
            $tmp = " OR ";
        }
        if ($param["sConstFlg3"]) {
            $where .= $tmp . "CONSTFLG3 = 1";
            $tmp = " OR ";
        }
        if ($param["sConstFlg4"]) {
            $where .= $tmp . "CONSTFLG4 = 1";
        }
        $where .= ")";
    }
    if ($param["sInteriorCharge"]) {
        $where .= " AND INTERIORCHARGE LIKE '%" . $param["sInteriorCharge"] . "%'";
    }
    return $select . $from . $where . $order . $limit;
}

//
//工事管理情報
//
function fnSqlConstEdit($articleNo)
{
    $select  = "SELECT ARTICLE, ROOM, ADDRESS, YEARS,"
        . "CONSTTRADER, CONSTADD, CONSTNOTE, RECEIVE, HOTWATER,"
        . "KEYPLACE, MANAGECOMPANY, FLOORPLAN, FORMEROWNER, BROKERCHARGE, BROKERCONTACT, INTERIORCHARGE,"
        . "SELLCHARGE, CONSTFLG1, CONSTFLG2, CONSTFLG3, CONSTFLG4, LEAVINGFORM,"
        . "ELECTRICITYCHARGE, GASCHARGE, LIGHTORDER, LINECONTACTNOTE,"
        . "IF( AREA > 0, AREA, '' ) AS AREA,"
        . "IF( SELLPRICE > 0, SELLPRICE, '' ) AS SELLPRICE,"
        . "IF( INTERIORPRICE > 0, INTERIORPRICE, '' ) AS INTERIORPRICE,"
        . "IF( CONSTPRICE > 0, CONSTPRICE, '') AS CONSTPRICE,"
        . "IF( SITEDT > '0000-00-00', SITEDT, '' ) AS SITEDT,"
        . "IF( LEAVINGDT > '0000-00-00', DATE_FORMAT( LEAVINGDT, '%Y/%m/%d'), '' ) AS LEAVINGDT,"
        . "IF( PURCHASEDT > '0000-00-00', DATE_FORMAT( PURCHASEDT, '%Y/%m/%d'), '' ) AS PURCHASEDT,"
        . "IF( WORKSTARTDT > '0000-00-00', DATE_FORMAT( WORKSTARTDT, '%Y/%m/%d'), '' ) AS WORKSTARTDT,"
        . "IF( WORKENDDT > '0000-00-00', DATE_FORMAT( WORKENDDT, '%Y/%m/%d'), '' ) AS WORKENDDT,"
        . "IF( LINEOPENDT > '0000-00-00', DATE_FORMAT( LINEOPENDT, '%Y/%m/%d'), '' ) AS LINEOPENDT,"
        . "IF( LINECLOSEDT > '0000-00-00', DATE_FORMAT( LINECLOSEDT, '%Y/%m/%d'), '' ) AS LINECLOSEDT,"
        . "IF( LINEOPENCONTACTDT > '0000-00-00', DATE_FORMAT( LINEOPENCONTACTDT, '%Y/%m/%d'), '' ) AS LINEOPENCONTACTDT,"
        . "IF( LINECLOSECONTACTDT > '0000-00-00', DATE_FORMAT( LINECLOSECONTACTDT, '%Y/%m/%d'), '' ) AS LINECLOSECONTACTDT";
    $from = " FROM TBLARTICLE";
    $where = " WHERE ARTICLENO = $articleNo";

    return $select . $from . $where;
}

//
//工事管理情報更新
//
function fnSqlConstUpdate($param)
{
    $sql  = "UPDATE TBLARTICLE";
    $sql .= " SET AREA = '" . $param["area"] . "'";
    $sql .= ",YEARS = '" . $param["years"] . "'";
    $sql .= ",SELLPRICE = '" . $param["sellPrice"] . "'";
    $sql .= ",INTERIORPRICE = '" . $param["interiorPrice"] . "'";
    $sql .= ",CONSTTRADER = '" . $param["constTrader"] . "'";
    $sql .= ",CONSTPRICE = '" . $param["constPrice"] . "'";
    $sql .= ",CONSTADD = '" . $param["constAdd"] . "'";
    $sql .= ",CONSTNOTE = '" . $param["constNote"] . "'";
    $sql .= ",PURCHASEDT = '" . $param["purchaseDT"] . "'";
    $sql .= ",WORKSTARTDT = '" . $param["workStartDT"] . "'";
    $sql .= ",WORKENDDT = '" . $param["workEndDT"] . "'";
    $sql .= ",LINEOPENDT = '" . $param["lineOpenDT"] . "'";
    $sql .= ",LINECLOSEDT = '" . $param["lineCloseDT"] . "'";
    $sql .= ",RECEIVE = '" . $param["receive"] . "'";
    $sql .= ",HOTWATER = '" . $param["hotWater"] . "'";
    $sql .= ",SITEDT = '" . $param["siteDT"] . "'";
    $sql .= ",LEAVINGFORM = '" . $param["leavingForm"] . "'";
    $sql .= ",LEAVINGDT = '" . $param["leavingDT"] . "'";
    $sql .= ",MANAGECOMPANY = '" . $param["manageCompany"] . "'";
    $sql .= ",FLOORPLAN = '" . $param["floorPlan"] . "'";
    $sql .= ",FORMEROWNER = '" . $param["formerOwner"] . "'";
    $sql .= ",BROKERCHARGE = '" . $param["brokerCharge"] . "'";
    $sql .= ",BROKERCONTACT = '" . $param["brokerContact"] . "'";
    $sql .= ",INTERIORCHARGE = '" . $param["interiorCharge"] . "'";
    $sql .= ",CONSTFLG1 = '" . $param["constFlg1"] . "'";
    $sql .= ",CONSTFLG2 = '" . $param["constFlg2"] . "'";
    $sql .= ",CONSTFLG3 = '" . $param["constFlg3"] . "'";
    $sql .= ",CONSTFLG4 = '" . $param["constFlg4"] . "'";
    $sql .= ",UPDT = CURRENT_TIMESTAMP";
    $sql .= ",LINEOPENCONTACTDT = '" . $param["lineOpenContactDT"] . "'";
    $sql .= ",LINECLOSECONTACTDT = '" . $param["lineCloseContactDT"] . "'";
    $sql .= ",LINECONTACTNOTE = '" . $param["lineContactnote"] . "'";
    $sql .= ",ELECTRICITYCHARGE = '" . $param["electricityCharge"] . "'";
    $sql .= ",GASCHARGE = '" . $param["gasCharge"] . "'";
    $sql .= ",LIGHTORDER = '" . $param["lightOrder"] . "'";
    $sql .= " WHERE ARTICLENO = " . $param["articleNo"];

    return ($sql);
}
