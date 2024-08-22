<?php
//
//ファイルマネージャー画面
//
function subFManager()
{
    $param = getFmanagerParam();

    if ($param["sDel"] == '') {
        $param["sDel"] = 1;
    }

    if (!$param["sPage"]) {
        $param["sPage"] = 1;
    }

    if (!$param["orderBy"] || $param["orderBy"] == 'ARTICLENO') {
        $param["orderBy"] = 'FMNO';
        $param["orderTo"] = 'DESC';
    }

    subMenu();
    subFmanagerView($param);
}

//
//ファイルマネージャー編集画面
//
function subFManagerEdit()
{
    $param = getFmanagerParam();

    $param["fMNo"] = $_REQUEST['fMNo'];

    if ($param["fMNo"]) {
        $sql = fnSqlFManagerEdit($param["fMNo"]);
        $res = mysqli_query($param["conn"], $sql);
        $row = mysqli_fetch_array($res);

        $param["name"]  = htmlspecialchars($row[0]);
        $param["room"]  = htmlspecialchars($row[1]);
        $param["note"]  = htmlspecialchars($row[2]);
        $param["del"]   = htmlspecialchars($row[4]);

        $param["purpose"]  = '更新';
        $param["btnImage"] = 'btn_load.png';
    } else {
        $param["purpose"] = '登録';
        $param["btnImage"] = 'btn_enter.png';
    }

    subMenu();
    subFmanagerEditView($param);
}

//
//ファイルマネージャー物件編集完了処理
//
function subFManagerEditComplete()
{
    $param = getFmanagerParam();

    $param["fMNo"] = mysqli_real_escape_string($param["conn"], $_REQUEST['fMNo']);
    $param["name"] = mysqli_real_escape_string($param["conn"], $_REQUEST['name']);
    $param["room"] = mysqli_real_escape_string($param["conn"], $_REQUEST['room']);
    $param["note"] = mysqli_real_escape_string($param["conn"], $_REQUEST['note']);
    $param["del"]  = mysqli_real_escape_string($param["conn"], $_REQUEST['del']);

    if ($param["fMNo"]) {
        $sql = fnSqlFManagerUpdate($param);
        $res = mysqli_query($param["conn"], $sql);
    } else {
        $param["fMNo"] = fnNextNo('FM');
        $sql = fnSqlFManagerInsert($param);
        $res = mysqli_query($param["conn"], $sql);
    }

    $_REQUEST['act'] = 'fManagerSearch';
    subFManager();
}

//
//ファイルマネージャー物件管理削除処理
//
function subFManagerDelete()
{
    $param = getFmanagerParam();

    $param["fMNo"] = $_REQUEST['fMNo'];

    $sql = fnSqlFManagerDelete($param["fMNo"]);
    $res = mysqli_query($param["conn"], $sql);

    $_REQUEST['act'] = 'fManagerSearch';
    subFManager();
}

//
//ファイルマネージャー書類一覧画面
//
function subFManagerPdf()
{
    $param = getFmanagerParam();

    $param["sClassNo"] = $_REQUEST['sClassNo'];

    $param["fMNo"] = $_REQUEST['fMNo'];

    $sql = fnSqlFManagerEdit($param["fMNo"]);
    $res = mysqli_query($param["conn"], $sql);
    $row = mysqli_fetch_array($res);

    $param["name"]  = htmlspecialchars($row[0]);
    $param["room"]  = htmlspecialchars($row[1]);
    $param["note"]  = htmlspecialchars($row[2]);
    $param["insDT"] = htmlspecialchars($row[3]);

    subMenu();
    subFManagerPdfView($param);
}

//
//ファイルマネージャー書類編集画面
//
function subFManagerViewEdit()
{
    $param = getFmanagerParam();

    $param["fMNo"]  = $_REQUEST['fMNo'];
    $param["pdfNo"] = $_REQUEST['pdfNo'];

    if ($param["pdfNo"]) {
        $sql = fnSqlFManagerViewEdit($param["pdfNo"]);
        $res = mysqli_query($param["conn"], $sql);
        $row = mysqli_fetch_array($res);

        $param["note"] = htmlspecialchars($row[0]);

        $param["purpose"] = '更新';
        $param["btnImage"] = 'btn_load.png';
    } else {
        $param["docNo"]   = $_REQUEST['docNo'];
        $param["purpose"] = '登録';
        $param["btnImage"] = 'btn_enter.png';
    }

    subMenu();
    subFManagerViewEditView($param);
}

//
//ファイルマネージャー書類編集完了処理
//
function subFManagerViewEditComplete()
{
    $param = getFmanagerParam();

    $param["fMNo"]  = mysqli_real_escape_string($param["conn"], $_REQUEST['fMNo']);
    $param["pdfNo"] = mysqli_real_escape_string($param["conn"], $_REQUEST['pdfNo']);
    $param["docNo"] = mysqli_real_escape_string($param["conn"], $_REQUEST['docNo']);
    $param["note"]  = mysqli_real_escape_string($param["conn"], $_REQUEST['note']);

    if ($param["pdfNo"]) {
        $sql = fnSqlFManagerViewUpdate($param);
        $res = mysqli_query($param["conn"], $sql);
    } else {
        $sql = "SELECT COUNT(*) FROM TBLPDF WHERE DEL = 1 AND FMNO = '" . $param["fMNo"] . " AND DOCNO = '" . $param["docNo"];
        $res = mysqli_query($param["conn"], $sql);
        $row = mysqli_fetch_array($res);
        if (!$row[0]) {
            $param["pdfNo"] = fnNextNo('PDF');

            $sql = fnSqlFManagerViewInsert($param);
            $res = mysqli_query($param["conn"], $sql);
        }
    }

    if ($_FILES['pdfFile']['tmp_name']) {
        move_uploaded_file($_FILES['pdfFile']['tmp_name'], './pdfs/' . substr('0000000000' . $param["pdfNo"], -10) . '.pdf');
    }

    $_REQUEST['act'] = 'fManagerView';
    subFManagerPdf();
}

//
//ファイルマネージャー書類削除処理
//
function subFManagerViewDelete()
{
    $param = getFmanagerParam();

    $param["pdfNo"] = $_REQUEST['pdfNo'];

    $sql = fnSqlFManagerViewDelete($param["pdfNo"]);
    $res = mysqli_query($param["conn"], $sql);

    unlink('./pdfs/' . substr('0000000000' . $param["pdfNo"], -10) . '.pdf');
    $_REQUEST['act'] = 'fManagerView';
    subFManagerPdf();
}


function getFmanagerParam()
{
    $param = array();

    // DB接続
    $param["conn"] = fnDbConnect();

    $param["sDel"]          = htmlspecialchars($_REQUEST['sDel']);
    $param["sSearchDTFrom"] = htmlspecialchars($_REQUEST['sSearchDTFrom']);
    $param["sSearchDTTo"]   = htmlspecialchars($_REQUEST['sSearchDTTo']);
    $param["sName"]         = htmlspecialchars($_REQUEST['sName']);
    $param["sRoom"]         = htmlspecialchars($_REQUEST['sRoom']);
    $param["sNote"]         = htmlspecialchars($_REQUEST['sNote']);

    $param["orderBy"] = $_REQUEST['orderBy'];
    $param["orderTo"] = $_REQUEST['orderTo'];
    $param["sPage"]   = $_REQUEST['sPage'];

    return $param;
}
