<?php

//
// 物件管理一覧画面
//
function subArticle()
{
    $param = getArticleParam();

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
    subArticleView($param);
}

//
//物件管理編集画面
//
function subArticleEdit()
{

    $param = getArticleParam();

    $param["articleNo"] = $_REQUEST['articleNo'];

    if ($param["articleNo"]) {
        $sql = fnSqlArticleEdit($param["articleNo"]);
        $res = mysqli_query($param["conn"], $sql);
        $row = mysqli_fetch_array($res);

        $param["article"]     =  htmlspecialchars($row["ARTICLE"]);
        $param["room"]        =  htmlspecialchars($row["ROOM"]);
        $param["keyPlace"]    =  htmlspecialchars($row["KEYPLACE"]);
        $param["address"]     =  htmlspecialchars($row["ADDRESS"]);
        $param["articleNote"] =  htmlspecialchars($row["ARTICLENOTE"]);
        $param["keyBox"]      =  htmlspecialchars($row["KEYBOX"]);
        $param["drawing"]     =  htmlspecialchars($row["DRAWING"]);
        $param["sellCharge"]  =  htmlspecialchars($row["SELLCHARGE"]);
        $param["del"]         =  htmlspecialchars($row["DEL"]);

        $param["purpose"]  = '更新';
        $param["btnImage"] = 'btn_load.png';
    } else {
        $param["purpose"] = '登録';
        $param["btnImage"] = 'btn_enter.png';
    }

    subMenu();
    subArticleEditView($param);
}

//
//物件管理編集完了処理
//
function subArticleEditComplete()
{
    $param = getTradeParam();

    $param["articleNo"]    = mysqli_real_escape_string($param["conn"], $_REQUEST['articleNo']);
    $param["article"]       = mysqli_real_escape_string($param["conn"], $_REQUEST['article']);
    $param["room"]   = mysqli_real_escape_string($param["conn"], $_REQUEST['room']);
    $param["keyPlace"]     = mysqli_real_escape_string($param["conn"], $_REQUEST['keyPlace']);
    $param["address"] = mysqli_real_escape_string($param["conn"], $_REQUEST['address']);
    $param["articleNote"]        = mysqli_real_escape_string($param["conn"], $_REQUEST['articleNote']);
    $param["keyBox"] = mysqli_real_escape_string($param["conn"], $_REQUEST['keyBox']);
    $param["drawing"]   = mysqli_real_escape_string($param["conn"], $_REQUEST['drawing']);
    $param["sellCharge"]   = mysqli_real_escape_string($param["conn"], $_REQUEST['sellCharge']);
    $param["del"]        = mysqli_real_escape_string($param["conn"], $_REQUEST['del']);


    if ($param["articleNo"]) {
        // 編集
        $sql = fnSqlArticleUpdate($param);
        $res = mysqli_query($param["conn"], $sql);
    } else {
        // 新規登録
        $param["articleNo"] = fnNextNo('ARTICLE');
        $sql = fnSqlArticleInsert($param);
        $res = mysqli_query($param["conn"], $sql);

        $sql = fnSqlFManagerInsert(fnNextNo('FM'), $article, $room, $articleNote, $del);
        $res = mysqli_query($param["conn"], $sql);
    }

    $_REQUEST['act'] = 'articleSearch';
    subArticle();
}

//
//物件管理削除処理
//
function subArticleDelete()
{
    $param = getArticleParam();

    $param["articleNo"] = $_REQUEST['articleNo'];

    $sql = fnSqlArticleDelete($param["articleNo"]);
    $res = mysqli_query($param["conn"], $sql);

    $_REQUEST['act'] = 'articleSearch';
    subArticle();
}

function getArticleParam()
{
    $param = array();

    // DB接続
    $param["conn"] = fnDbConnect();

    // 検索情報
    $param["sDel"] = htmlspecialchars($_REQUEST['sDel']);
    $param["sArticle"] = htmlspecialchars($_REQUEST['sArticle']);
    $param["sRoom"] = htmlspecialchars($_REQUEST['sRoom']);
    $param["sKeyPlace"] = htmlspecialchars($_REQUEST['sKeyPlace']);
    $param["sArticleNote"] = htmlspecialchars($_REQUEST['sArticleNote']);
    $param["sKeyBox"] = htmlspecialchars($_REQUEST['sKeyBox']);
    $param["sDrawing"] = htmlspecialchars($_REQUEST['sDrawing']);
    $param["sSellCharge"] = htmlspecialchars($_REQUEST['sSellCharge']);

    $param["orderBy"] = $_REQUEST['orderBy'];
    $param["orderTo"] = $_REQUEST['orderTo'];
    $param["sPage"] = $_REQUEST['sPage'];

    return $param;
}
