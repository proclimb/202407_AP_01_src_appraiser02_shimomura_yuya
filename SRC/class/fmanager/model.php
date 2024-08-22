<?php
//
//ファイルマネージャー物件管理リスト
//
function fnSqlFManagerList($flg, $param)
{
    switch ($flg) {
        case 0:
            $select  = "SELECT COUNT(*)";
            $order = "";
            $limit = "";
            break;
        case 1:
            $select  = "SELECT FMNO,NAME,ROOM,NOTE,IF(INSDT > '0000-00-00',DATE_FORMAT(INSDT,'%Y/%m/%d'),'')";
            if ($param["orderBy"]) {
                $order = " ORDER BY " . $param["orderBy"] . " " . $param["orderTo"];
            }
            $limit = " LIMIT " . (($param["sPage"] - 1) * PAGE_MAX) . ", " . PAGE_MAX;
            break;
    }
    $from = " FROM TBLFM";
    $where = " WHERE DEL = " . $param["sDel"];
    if ($param["sSearchDTFrom"]) {
        $where .= " AND INSDT >= " . $param["sSearchDTFrom"];
    }
    if ($param["sSearchDTTo"]) {
        $where .= " AND INSDT <= " . $param["sSearchDTTo"] . " 23:59:59 ";
    }
    if ($param["sName"]) {
        $where .= " AND NAME LIKE '%" . $param["sName"] . "%'";
    }
    if ($param["sRoom"]) {
        $where .= " AND ROOM LIKE '%" . $param["sRoom"] . "%'";
    }
    if ($param["sNote"]) {
        $where .= " AND NOTE LIKE '%" . $param["sNote"] . "%'";
    }

    return $select . $from . $where . $order . $limit;
}

//
//ファイルマネージャー物件管理情報
//
function fnSqlFManagerEdit($fMNo)
{
    $select  = "SELECT NAME,ROOM,NOTE,INSDT,DEL";
    $from = " FROM TBLFM";
    $where = " WHERE FMNO = $fMNo";

    return $select . $from . $where;
}

//
//ファイルマネージャー物件管理情報更新
//
function fnSqlFManagerUpdate($param)
{
    $sql  = "UPDATE TBLFM";
    $sql .= " SET NAME = '" . $param["name"] . "'";
    $sql .= ",ROOM = '" . $param["room"] . "'";
    $sql .= ",NOTE = '" . $param["note"] . "'";
    $sql .= ",UPDT = CURRENT_TIMESTAMP";
    $sql .= ",DEL = '" . $param["del"] . "'";
    $sql .= " WHERE FMNO = " . $param["fMNo"];

    return ($sql);
}

//
//ファイルマネージャー物件管理情報登録
//
function fnSqlFManagerInsert($param)
{
    $sql  = "INSERT INTO TBLFM(";
    $sql .= "FMNO,NAME,ROOM,NOTE,INSDT,UPDT,DEL";
    $sql .= ")VALUES(";
    $sql .= "'" . $param["fMNo"] . "','" . $param["name"] . "','" . $param["room"] . "','" . $param["note"] . "',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,'" . $param["del"] . "')";

    return ($sql);
}

//
//ファイルマネージャー物件管理情報削除
//
function fnSqlFManagerDelete($fMNo)
{
    $sql  = "UPDATE TBLFM";
    $sql .= " SET DEL = -1";
    $sql .= ",UPDT = CURRENT_TIMESTAMP";
    $sql .= " WHERE FMNO = '$fMNo'";

    return ($sql);
}

//
//ファイルマネージャー書類タイトル
//
function fnSqlFManagerViewTitle()
{
    $sql  = "SELECT CLASSNO,NAME FROM TBLDOC";
    $sql .= " WHERE DEL = 1";
    $sql .= " AND SEQNO = 0";
    $sql .= " ORDER BY CLASSNO ASC";

    return ($sql);
}

//
//ファイルマネージャー書類一覧
//
function fnSqlFManagerViewList($classNo)
{
    $sql  = "SELECT DOCNO,CLASSNO,SEQNO,NAME FROM TBLDOC";
    $sql .= " WHERE DEL = 1";
    if ($classNo) {
        $sql .= " AND CLASSNO = '$classNo'";
    }
    $sql .= " ORDER BY CLASSNO ASC,SEQNO ASC";

    return ($sql);
}

//
//ファイルマネージャー登録書類一覧
//
function fnSqlFManagerViewPDF($fMNo, $docNo)
{
    $sql  = "SELECT PDFNO,NOTE FROM TBLPDF";
    $sql .= " WHERE DEL = 1";
    $sql .= " AND FMNO = '$fMNo'";
    $sql .= " AND DOCNO = '$docNo'";

    return ($sql);
}

//
//ファイルマネージャー書類編集
//
function fnSqlFManagerViewEdit($pdfNo)
{
    $sql  = "SELECT NOTE FROM TBLPDF";
    $sql .= " WHERE DEL = 1";
    $sql .= " AND PDFNO = '$pdfNo'";

    return ($sql);
}

//
//ファイルマネージャー書類更新
//
function fnSqlFManagerViewUpdate($param)
{
    $sql  = "UPDATE TBLPDF";
    $sql .= " SET note = '" . $param["note"] . "'";
    $sql .= ",UPDT = CURRENT_TIMESTAMP";
    $sql .= " WHERE PDFNO = '" . $param["pdfNo"];

    return ($sql);
}

//
//ファイルマネージャー書類登録
//
function fnSqlFManagerViewInsert($param)
{
    $sql  = "INSERT INTO TBLPDF(";
    $sql .= "PDFNO,FMNO,DOCNO,NOTE,INSDT,UPDT,DEL";
    $sql .= ")VALUES(";
    $sql .= "'" . $param["pdfNo"] . "','" . $param["fMNo"] . "','" . $param["docNo"] . "','" . $param["note"] . "',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,1)";

    return ($sql);
}

//
//ファイルマネージャー書類削除
//
function fnSqlFManagerViewDelete($pdfNo)
{
    $sql  = "UPDATE TBLPDF";
    $sql .= " SET DEL = -1";
    $sql .= ",UPDT = CURRENT_TIMESTAMP";
    $sql .= " WHERE PDFNO = '$pdfNo'";

    return ($sql);
}
