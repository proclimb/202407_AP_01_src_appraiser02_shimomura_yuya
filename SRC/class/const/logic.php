<?php
//
//工事管理画面
//
function subConst()
{
    $param = getConstParam();
    if ($param["sDel"] == '') {
        $param["sDel"] = 1;
    }

    if (!$param["sPage"]) {
        $param["sPage"] = 1;
    }

    if (!$param["orderBy"]) {
        $param["orderBy"] = 'ARTICLENO';
        $param["orderTo"] = 'DESC';
    }

    subMenu();
    subConstView($param);
}

//
//工事管理編集画面
//
function subConstEdit()
{
    $param = getConstParam();

    $param["articleNo"] = $_REQUEST['articleNo'];

    if (!$_REQUEST['article']) {
        $sql = fnSqlConstEdit($param["articleNo"]);
        $res = mysqli_query($param["conn"], $sql);
        $row  = mysqli_fetch_array($res);

        $param["article"]      = htmlspecialchars($row["ARTICLE"]);
        $param["room"]         = htmlspecialchars($row["ROOM"]);
        $param["address"]        = htmlspecialchars($row["ADDRESS"]);
        $param["area"]           = htmlspecialchars($row["AREA"]);
        $param["years"]          = htmlspecialchars($row["YEARS"]);
        $param["sellPrice"]      = htmlspecialchars($row["SELLPRICE"]);
        $param["interiorPrice"]  = htmlspecialchars($row["INTERIORPRICE"]);
        $param["constTrader"]    = htmlspecialchars($row["CONSTTRADER"]);
        $param["constPrice"]     = htmlspecialchars($row["CONSTPRICE"]);
        $param["constAdd"]       = htmlspecialchars($row["CONSTADD"]);
        $param["constNote"]      = htmlspecialchars($row["CONSTNOTE"]);
        $param["purchaseDT"]     = htmlspecialchars($row["PURCHASEDT"]);
        $param["workStartDT"]    = htmlspecialchars($row["WORKSTARTDT"]);
        $param["workEndDT"]      = htmlspecialchars($row["WORKENDDT"]);
        $param["lineOpenDT"]     = htmlspecialchars($row["LINEOPENDT"]);
        $param["lineCloseDT"]    = htmlspecialchars($row["LINECLOSEDT"]);
        $param["receive"]        = htmlspecialchars($row["RECEIVE"]);
        $param["hotWater"]       = htmlspecialchars($row["HOTWATER"]);
        $param["siteDT"]         = htmlspecialchars($row["SITEDT"]);
        $param["leavingForm"]    = htmlspecialchars($row["LEAVINGFORM"]);
        $param["leavingDT"]      = htmlspecialchars($row["LEAVINGDT"]);
        $param["keyPlace"]       = htmlspecialchars($row["KEYPLACE"]);
        $param["manageCompany"]  = htmlspecialchars($row["MANAGECOMPANY"]);
        $param["floorPlan"]      = htmlspecialchars($row["FLOORPLAN"]);
        $param["formerOwner"]    = htmlspecialchars($row["FORMEROWNER"]);
        $param["brokerCharge"]   = htmlspecialchars($row["BROKERCHARGE"]);
        $param["brokerContact"]  = htmlspecialchars($row["BROKERCONTACT"]);
        $param["interiorCharge"] = htmlspecialchars($row["INTERIORCHARGE"]);
        $param["sellCharge"]     = htmlspecialchars($row["SELLCHARGE"]);
        $param["constFlg1"]      = htmlspecialchars($row["CONSTFLG1"]);
        $param["constFlg2"]      = htmlspecialchars($row["CONSTFLG2"]);
        $param["constFlg3"]      = htmlspecialchars($row["CONSTFLG3"]);
        $param["constFlg4"]      = htmlspecialchars($row["CONSTFLG4"]);
        $param["lineOpenContactDT"] = htmlspecialchars($row["LINEOPENCONTACTDT"]);
        $param["lineCloseContactDT"] = htmlspecialchars($row["LINECLOSECONTACTDT"]);
        $param["lineContactNote"] = htmlspecialchars($row["LINECONTACTNOTE"]);
        $param["electricityCharge"] = htmlspecialchars($row["ELECTRICITYCHARGE"]);
        $param["gasCharge"]      = htmlspecialchars($row["GASCHARGE"]);
        $param["lightOrder"]     = htmlspecialchars($row["LIGHTORDER"]);

        $param["siteDate"]   = fnToFormYMD($param["siteDT"]);
        $param["siteHour"]   = fnToFormH($param["siteDT"]);
        $param["siteMinute"] = fnToFormM($param["siteDT"]);
    }

    subMenu();
    subConstEditView($param);
}

//
//工事管理編集完了処理
//
function subConstEditComplete()
{
    $param = getConstParam();

    $param["articleNo"]      = mysqli_real_escape_string($param["conn"], $_REQUEST['articleNo']);
    $param["area"]           = mysqli_real_escape_string($param["conn"], $_REQUEST['area']);
    $param["years"]          = mysqli_real_escape_string($param["conn"], $_REQUEST['years']);
    $param["sellPrice"]      = mysqli_real_escape_string($param["conn"], $_REQUEST['sellPrice']);
    $param["interiorPrice"]  = mysqli_real_escape_string($param["conn"], $_REQUEST['interiorPrice']);
    $param["constTrader"]    = mysqli_real_escape_string($param["conn"], $_REQUEST['constTrader']);
    $param["constPrice"]     = mysqli_real_escape_string($param["conn"], $_REQUEST['constPrice']);
    $param["constAdd"]       = mysqli_real_escape_string($param["conn"], $_REQUEST['constAdd']);
    $param["constNote"]      = mysqli_real_escape_string($param["conn"], $_REQUEST['constNote']);
    $param["purchaseDT"]     = mysqli_real_escape_string($param["conn"], $_REQUEST['purchaseDT']);
    $param["workStartDT"]    = mysqli_real_escape_string($param["conn"], $_REQUEST['workStartDT']);
    $param["workEndDT"]      = mysqli_real_escape_string($param["conn"], $_REQUEST['workEndDT']);
    $param["lineOpenDT"]     = mysqli_real_escape_string($param["conn"], $_REQUEST['lineOpenDT']);
    $param["lineCloseDT"]    = mysqli_real_escape_string($param["conn"], $_REQUEST['lineCloseDT']);
    $param["receive"]        = mysqli_real_escape_string($param["conn"], $_REQUEST['receive']);
    $param["hotWater"]       = mysqli_real_escape_string($param["conn"], $_REQUEST['hotWater']);
    $param["siteDate"]       = mysqli_real_escape_string($param["conn"], $_REQUEST['siteDate']);
    $param["siteHour"]       = mysqli_real_escape_string($param["conn"], $_REQUEST['siteHour']);
    $param["siteMinute"]     = mysqli_real_escape_string($param["conn"], $_REQUEST['siteMinute']);
    $param["siteDT"]         = mysqli_real_escape_string($param["conn"], fnToSqlYMDHM($siteDate, $siteHour, $siteMinute));
    $param["leavingForm"]    = mysqli_real_escape_string($param["conn"], $_REQUEST['leavingForm']);
    $param["leavingDT"]      = mysqli_real_escape_string($param["conn"], $_REQUEST['leavingDT']);
    $param["manageCompany"]  = mysqli_real_escape_string($param["conn"], $_REQUEST['manageCompany']);
    $param["floorPlan"]      = mysqli_real_escape_string($param["conn"], $_REQUEST['floorPlan']);
    $param["formerOwner"]    = mysqli_real_escape_string($param["conn"], $_REQUEST['formerOwner']);
    $param["brokerCharge"]   = mysqli_real_escape_string($param["conn"], $_REQUEST['brokerCharge']);
    $param["brokerContact"]  = mysqli_real_escape_string($param["conn"], $_REQUEST['brokerContact']);
    $param["interiorCharge"] = mysqli_real_escape_string($param["conn"], $_REQUEST['interiorCharge']);
    $param["constFlg1"]      = mysqli_real_escape_string($param["conn"], $_REQUEST['constFlg1']);
    $param["constFlg2"]      = mysqli_real_escape_string($param["conn"], $_REQUEST['constFlg2']);
    $param["constFlg3"]      = mysqli_real_escape_string($param["conn"], $_REQUEST['constFlg3']);
    $param["constFlg4"]      = mysqli_real_escape_string($param["conn"], $_REQUEST['constFlg4']);
    $param["lineOpenContactDT"] = mysqli_real_escape_string($param["conn"], $_REQUEST["lineOpenContactDT"]);
    $param["lineCloseContactDT"] = mysqli_real_escape_string($param["conn"], $_REQUEST["lineCloseContactDT"]);
    $param["lineContactNode"] = mysqli_real_escape_string($param["conn"], $_REQUEST["lineContactNote"]);
    $param["electricityCharge"] = mysqli_real_escape_string($param["conn"], $_REQUEST["electricityCharge"]);
    $param["gasCharge"]      = mysqli_real_escape_string($param["conn"], $_REQUEST["gasCharge"]);
    $param["lightOrder"]     = mysqli_real_escape_string($param["conn"], $_REQUEST["lightOrder"]);

    $sql = fnSqlConstUpdate($param);
    $res = mysqli_query($param["conn"], $sql);

    $_REQUEST['act'] = 'constSearch';
    subConst();
}


function getConstParam()
{
    $param = array();

    $param["conn"] = fnDbConnect();

    $param["sDel"]            = htmlspecialchars($_REQUEST['sDel']);
    $param["sArticle"]        = htmlspecialchars($_REQUEST['sArticle']);
    $param["sConstTrader"]    = htmlspecialchars($_REQUEST['sConstTrader']);
    $param["sConstFlg1"]      = htmlspecialchars($_REQUEST['sConstFlg1']);
    $param["sConstFlg2"]      = htmlspecialchars($_REQUEST['sConstFlg2']);
    $param["sConstFlg3"]      = htmlspecialchars($_REQUEST['sConstFlg3']);
    $param["sConstFlg4"]      = htmlspecialchars($_REQUEST['sConstFlg4']);
    $param["sInteriorCharge"] = htmlspecialchars($_REQUEST['sInteriorCharge']);

    $param["orderBy"] = $_REQUEST['orderBy'];
    $param["orderTo"] = $_REQUEST['orderTo'];
    $param["sPage"]   = $_REQUEST['sPage'];

    return $param;
}
