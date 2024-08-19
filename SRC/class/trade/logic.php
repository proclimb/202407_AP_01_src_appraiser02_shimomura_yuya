<?php

function subTrade()
{
    $param = getTradeParam();

    if ($param["sDel"] == '') {
        $param["sDel"] = 1;
    }

    if (!$param["sPage"]) {
        $param["sPage"] = 1;
    }

    if (!$param["orderBy"]) {
        $param["orderBy"] = 'TRADENO';
        $param["orderTo"] = 'DESC';
    }

    subMenu();
    subTradeView($param);
}

function subTradeEdit()
{
    $param = getTradeParam();

    $param["tradeNo"] = $_REQUEST['tradeNo'];
    if ($param["tradeNo"]) {
        $sql = fnSqlTradeEdit($param["tradeNo"]);
        $res = mysqli_query($param["conn"], $sql);
        $row = mysqli_fetch_array($res);

        $param["name"]       = htmlspecialchars($row[0]);
        $param["nameFuri"]   = htmlspecialchars($row[1]);
        $param["branch"]     = htmlspecialchars($row[2]);
        $param["branchFuri"] = htmlspecialchars($row[3]);
        $param["zip"]        = htmlspecialchars($row[4]);
        $param["prefecture"] = htmlspecialchars($row[5]);
        $param["address1"]   = htmlspecialchars($row[6]);
        $param["address2"]   = htmlspecialchars($row[7]);
        $param["tel"]        = htmlspecialchars($row[8]);
        $param["fax"]        = htmlspecialchars($row[9]);
        $param["mobile"]     = htmlspecialchars($row[10]);
        $param["interior"]   = htmlspecialchars($row[11]);
        $param["del"]        = htmlspecialchars($row[12]);

        $param["purpose"]  = '更新';
        $param["btnImage"] = 'btn_load.png';
    } else {
        $param["purpose"] = '登録';
        $param["btnImage"] = 'btn_enter.png';
    }

    subMenu();
    subTradeEditView($param);
}

//
//業者一覧編集完了処理
//
function subTradeEditComplete()
{
    $param = getTradeParam();

    $param["tradeNo"]    = mysqli_real_escape_string($param["conn"], $_REQUEST['tradeNo']);
    $param["name"]       = mysqli_real_escape_string($param["conn"], $_REQUEST['name']);
    $param["nameFuri"]   = mysqli_real_escape_string($param["conn"], $_REQUEST['nameFuri']);
    $param["branch"]     = mysqli_real_escape_string($param["conn"], $_REQUEST['branch']);
    $param["branchFuri"] = mysqli_real_escape_string($param["conn"], $_REQUEST['branchFuri']);
    $param["zip"]        = mysqli_real_escape_string($param["conn"], $_REQUEST['zip']);
    $param["prefecture"] = mysqli_real_escape_string($param["conn"], $_REQUEST['prefecture']);
    $param["address1"]   = mysqli_real_escape_string($param["conn"], $_REQUEST['address1']);
    $param["address2"]   = mysqli_real_escape_string($param["conn"], $_REQUEST['address2']);
    $param["tel"]        = mysqli_real_escape_string($param["conn"], $_REQUEST['tel']);
    $param["fax"]        = mysqli_real_escape_string($param["conn"], $_REQUEST['fax']);
    $param["mobile"]     = mysqli_real_escape_string($param["conn"], $_REQUEST['mobile']);
    $param["interior"]   = mysqli_real_escape_string($param["conn"], $_REQUEST['interior']);
    $param["del"]        = mysqli_real_escape_string($param["conn"], $_REQUEST['del']);

    if ($param["tradeNo"]) {
        $sql = fnSqlTradeUpdate($param);
        $res = mysqli_query($param["conn"], $sql);
    } else {
        $param["tradeNo"] = fnNextNo('TRADE');
        $sql = fnSqlTradeInsert($param);
        $res = mysqli_query($param["conn"], $sql);
    }

    $_REQUEST['act'] = 'tradeSearch';
    subTrade();
}

//
//業者一覧削除処理
//
function subTradeDelete()
{
    $param = getTradeParam();

    $param["tradeNo"] = $_REQUEST['tradeNo'];

    $sql = fnSqlTradeDelete($param);
    $res = mysqli_query($param["conn"], $sql);

    $_REQUEST['act'] = 'tradeSearch';
    subTrade();
}

function getTradeParam()
{
    $param = array();

    // DB接続
    $param["conn"] = fnDbConnect();

    // 検索情報
    $param["sDel"] = htmlspecialchars($_REQUEST['sDel']);
    $param["sName"] = htmlspecialchars($_REQUEST['sName']);
    $param["sBranch"] = htmlspecialchars($_REQUEST['sBranch']);
    $param["sZip"] = htmlspecialchars($_REQUEST['sZip']);
    $param["sPrefecture"] = htmlspecialchars($_REQUEST['sPrefecture']);
    $param["sAddress1"] = htmlspecialchars($_REQUEST['sAddress1']);
    $param["sAddress2"] = htmlspecialchars($_REQUEST['sAddress2']);
    $param["sTel"] = htmlspecialchars($_REQUEST['sTel']);
    $param["sFax"] = htmlspecialchars($_REQUEST['sFax']);
    $param["sMobile"] = htmlspecialchars($_REQUEST['sMobile']);
    $param["sInterior"] = htmlspecialchars($_REQUEST['sInterior']);

    $param["orderBy"] = $_REQUEST['orderBy'];
    $param["orderTo"] = $_REQUEST['orderTo'];
    $param["sPage"] = $_REQUEST['sPage'];

    return $param;
}
