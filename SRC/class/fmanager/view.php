<?php

function subFmanagerView($param)
{
?>
    <script>
        var cal1 = new JKL.Calendar("cal1", "form", "sSearchDTFrom");
        var cal2 = new JKL.Calendar("cal2", "form", "sSearchDTTo");
    </script>

    <h1>ファイルマネージャー画面</h1>

    <form name="form" id="form" action="index.php" method="post">
        <input type="hidden" name="act" value="fManagerSearch" />
        <input type="hidden" name="orderBy" value="<?php print $param["orderBy"]; ?>" />
        <input type="hidden" name="orderTo" value="<?php print $param["orderTo"]; ?>" />
        <input type="hidden" name="sPage" value="<?php print $param["sPage"]; ?>" />
        <input type="hidden" name="fMNo" />

        <a href="javascript:form.act.value='fManagerEdit';form.submit();"><img src="./images/btn_enter.png"></a>

        <div class="search">
            <table border="0" cellpadding="2" cellspacing="0">
                <tr>
                    <th>除外</th>
                    <td><input type="checkbox" name="sDel" value="0" <?php if ($param["sDel"] == 0) print ' checked="checked"'; ?> /></td>
                </tr>
                <tr>
                    <th>検索日</th>
                    <td>
                        <input type="text" name="sSearchDTFrom" value="<?php print $param["sSearchDTFrom"]; ?>" size="15" /><a href="javascript:cal1.write();" onChange="cal1.getFormValue(); cal1.hide();"><img src="./images/b_calendar.png"></a><span id="cal1"></span>
                        ～
                        <input type="text" name="sSearchDTTo" value="<?php print $param["sSearchDTTo"]; ?>" size="15" /><a href="javascript:cal2.write();" onChange="cal2.getFormValue(); cal2.hide();"><img src="./images/b_calendar.png"></a><span id="cal2"></span>
                    </td>
                </tr>
                <tr>
                    <th>物件名</th>
                    <td><input type="text" name="sName" value="<?php print $param["sName"]; ?>" size="50" /></td>
                </tr>
                <tr>
                    <th>部屋</th>
                    <td><input type="text" name="sRoom" value="<?php print $param["sRoom"]; ?>" size="30" /></td>
                </tr>
                <tr>
                    <th>備考</th>
                    <td><input type="text" name="sNote" value="<?php print $param["sNote"]; ?>" size="50" /></td>
                </tr>
            </table>
        </div>

        <input type="image" src="./images/btn_search.png" onclick="form.act.value='fManagerSearch';form.sPage.value=1;form.submit();" />

        <hr />
        <?php
        if ($_REQUEST['act'] == 'fManager') {
            return;
        }

        $sql = fnSqlFManagerList(0, $param);
        $res = mysqli_query($param["conn"], $sql);
        $row = mysqli_fetch_array($res);

        $count = $row[0];

        $sPage = fnPage($count, $param["sPage"], 'fManagerSearch');
        ?>

        <div class="list">
            <table border="0" cellpadding="5" cellspacing="1">
                <tr>
                    <th class="list_head">登録日<?php fnOrder('INSDT', 'fManagerSearch'); ?></th>
                    <th class="list_head">物件名<?php fnOrder('NAME', 'fManagerSearch'); ?></th>
                    <th class="list_head">部屋<?php fnOrder('ROOM', 'fManagerSearch'); ?></th>
                    <th class="list_head">備考<?php fnOrder('NOTE', 'fManagerSearch'); ?></th>
                    <th class="list_head">表示</th>
                </tr>
                <?php
                $sql = fnSqlFManagerList(1, $param);
                $res = mysqli_query($param["conn"], $sql);
                $i = 0;
                while ($row = mysqli_fetch_array($res)) {
                    $fMNo  = htmlspecialchars($row[0]);
                    $name  = htmlspecialchars($row[1]);
                    $room  = htmlspecialchars($row[2]);
                    $note  = htmlspecialchars($row[3]);
                    $insDT = htmlspecialchars($row[4]);
                ?>
                    <tr>
                        <td class="list_td<?php print $i; ?>"><?php print $insDT; ?></td>
                        <td class="list_td<?php print $i; ?>"><a href="javascript:form.act.value='fManagerEdit';form.fMNo.value=<?php print $fMNo; ?>;form.submit();"><?php print $name; ?></a></td>
                        <td class="list_td<?php print $i; ?>"><?php print $room; ?></td>
                        <td class="list_td<?php print $i; ?>"><?php print $note; ?></td>
                        <td class="list_td<?php print $i; ?>"><a href="javascript:form.act.value='fManagerView';form.fMNo.value=<?php print $fMNo; ?>;form.submit();">＞＞＞この物件の書類一覧を表示する</a></td>
                    </tr>
                <?php
                    $i = ($i + 1) % 2;
                }
                ?>
            </table>
        </div>
    </form>
<?php
}



function subFmanagerEditView($param)
{
?>
    <script type="text/javascript" src="./js/fmanager.js"></script>

    <h1>ファイルマネージャー物件<?php print $param["purpose"]; ?></h1>

    <form name="form" id="form" action="index.php" method="post">
        <input type="hidden" name="act" />
        <input type="hidden" name="sDel" value="<?php print $param["sDel"]; ?>" />
        <input type="hidden" name="sSearchDTFrom" value="<?php print $param["sSearchDTFrom"]; ?>" />
        <input type="hidden" name="sSearchDTTo" value="<?php print $param["sSearchDTTo"]; ?>" />
        <input type="hidden" name="sName" value="<?php print $param["sName"]; ?>" />
        <input type="hidden" name="sRoom" value="<?php print $param["sRoom"]; ?>" />
        <input type="hidden" name="sNote" value="<?php print $param["sNote"]; ?>" />
        <input type="hidden" name="orderBy" value="<?php print $param["orderBy"]; ?>" />
        <input type="hidden" name="orderTo" value="<?php print $param["orderTo"]; ?>" />
        <input type="hidden" name="sPage" value="<?php print $param["sPage"]; ?>" />
        <input type="hidden" name="fMNo" value="<?php print $param["fMNo"]; ?>" />

        <table border="0" cellpadding="5" cellspacing="1">
            <tr>
                <th>除外</th>
                <td><input type="radio" name="del" value="1" checked="checked" /> 非除外
                    <input type="radio" name="del" value="0" <?php if ($param["del"] == '0') print ' checked="checked"'; ?> /> 除外
                </td>
            </tr>
            <tr>
                <th>物件名</th>
                <td><input type="text" name="name" value="<?php print $param["name"]; ?>" /></td>
            </tr>
            <tr>
                <th>部屋</th>
                <td><input type="text" name="room" value="<?php print $param["room"]; ?>" /></td>
            </tr>
            <tr>
                <th>備考</th>
                <td><textarea name="note" cols="50" rows="10"><?php print $param["note"]; ?></textarea></td>
            </tr>
        </table>

        <a href="javascript:fnFManagerEditCheck();"><img src="./images/<?php print $param["btnImage"]; ?>" /></a>　
        <a href="javascript:form.act.value='fManagerSearch';form.submit();"><img src="./images/btn_return.png" /></a>　
        <?php
        if ($param["fMNo"]) {
        ?>
            <a href="javascript:fnFManagerDeleteCheck(<?php print $param["fMNo"]; ?>);"><img src="./images/btn_del.png" /></a>
        <?php
        }
        ?>

    </form>
<?php
}

//
//ファイルマネージャー書類一覧画面
//
function subFManagerPdfView($param)
{ ?>

    <h1>書類一覧</h1>

    <form name="form" id="form" action="index.php" method="post">
        <input type="hidden" name="act" />
        <input type="hidden" name="sDel" value="<?php print $param["sDel"]; ?>" />
        <input type="hidden" name="sSearchDTFrom" value="<?php print $param["sSearchDTFrom"]; ?>" />
        <input type="hidden" name="sSearchDTTo" value="<?php print $param["sSearchDTTo"]; ?>" />
        <input type="hidden" name="sName" value="<?php print $param["sName"]; ?>" />
        <input type="hidden" name="sRoom" value="<?php print $param["sRoom"]; ?>" />
        <input type="hidden" name="sNote" value="<?php print $param["sNote"]; ?>" />
        <input type="hidden" name="orderBy" value="<?php print $param["orderBy"]; ?>" />
        <input type="hidden" name="orderTo" value="<?php print $param["orderTo"]; ?>" />
        <input type="hidden" name="sPage" value="<?php print $param["sPage"]; ?>" />
        <input type="hidden" name="fMNo" value="<?php print $param["fMNo"]; ?>" />
        <input type="hidden" name="pdfNo" />
        <input type="hidden" name="docNo" />

        <div class="list">
            <table border="0" cellpadding="5" cellspacing="1">
                <tr>
                    <th>登録日</th>
                    <th>物件名</th>
                    <th>部屋</th>
                    <th>備考</th>
                </tr>
                <tr>
                    <td><?php print $param["insDT"]; ?></td>
                    <td><?php print $param["name"]; ?></td>
                    <td><?php print $param["room"]; ?></td>
                    <td><?php print $param["note"]; ?></td>
                </tr>
            </table>
        </div>

        <a href="javascript:form.act.value='fManagerSearch';form.submit();"><img src="./images/btn_return.png" /></a>

        <hr />

        <select name="sClassNo" onchange="form.act.value='fManagerView';form.submit();">
            <option value="0">すべて</option>
            <?php
            $sql = fnSqlFManagerViewTitle();
            $res = mysqli_query($param["conn"], $sql);
            while ($row = mysqli_fetch_array($res)) {
                $classNo = htmlspecialchars($row[0]);
                $name    = htmlspecialchars($row[1]);
            ?>
                <option value="<?php print $classNo; ?>" <?php if ($param["sClassNo"] == $classNo) print ' selected="selected"'; ?>><?php print $name; ?></option>
            <?php
            }
            ?>
        </select>

        <div class="list">
            <table border="0" cellpadding="5" cellspacing="1">
                <?php
                $sql = fnSqlFManagerViewList($param["sClassNo"]);
                $res = mysqli_query($param["conn"], $sql);
                while ($row = mysqli_fetch_array($res)) {
                    $docNo   = htmlspecialchars($row[0]);
                    $classNo = htmlspecialchars($row[1]);
                    $seqNo   = htmlspecialchars($row[2]);
                    $name    = htmlspecialchars($row[3]);

                    if ($seqNo == 0) {
                ?>
                        <tr>
                            <th colspan="5">－－－　<?php print $name; ?>　－－－</th>
                        </tr>
                    <?php
                    } else {
                        $sql  = fnSqlFManagerViewPDF($param["fMNo"], $docNo);
                        $res2 = mysqli_query($param["conn"], $sql);
                        $row2 = mysqli_fetch_array($res2);

                        $pdfNo = htmlspecialchars($row2[0]);
                        $note  = htmlspecialchars($row2[1]);
                    ?>
                        <tr>
                            <td width="35%"><?php print $name; ?></td>
                            <td width="45%"><?php print $note; ?></td>
                            <?php
                            if ($pdfNo) {
                            ?>
                                <td width="10%"><a href="./pdfs/<?php print substr('0000000000' . $pdfNo, -10) . '.pdf'; ?>" target="_blank">表示</a></td>
                                <td width="10%"><a href="javascript:form.act.value='fManagerViewEdit';form.pdfNo.value=<?php print $pdfNo; ?>;form.submit();">編集</a></td>
                            <?php
                            } else {
                            ?>
                                <td width="10%">&nbsp;</td>
                                <td width="10%"><a href="javascript:form.act.value='fManagerViewEdit';form.docNo.value=<?php print $docNo; ?>;form.submit();">登録</a></td>
                            <?php
                            }
                            ?>
                            </td>
                        </tr>
                <?php
                    }
                }
                ?>
            </table>
        </div>

    </form>
<?php
}

//
//ファイルマネージャー書類編集画面
//
function subFManagerViewEditView($param)
{

?>
    <script type="text/javascript" src="./js/fmanager.js"></script>

    <h1>ファイルマネージャー書類<?php print $param["purpose"]; ?></h1>

    <form name="form" id="form" action="index.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="act" />
        <input type="hidden" name="sDel" value="<?php print $param["sDel"]; ?>" />
        <input type="hidden" name="sSearchDTFrom" value="<?php print $param["sSearchDTFrom"]; ?>" />
        <input type="hidden" name="sSearchDTTo" value="<?php print $param["sSearchDTTo"]; ?>" />
        <input type="hidden" name="sName" value="<?php print $param["sName"]; ?>" />
        <input type="hidden" name="sRoom" value="<?php print $param["sRoom"]; ?>" />
        <input type="hidden" name="sNote" value="<?php print $param["sNote"]; ?>" />
        <input type="hidden" name="orderBy" value="<?php print $param["orderBy"]; ?>" />
        <input type="hidden" name="orderTo" value="<?php print $param["orderTo"]; ?>" />
        <input type="hidden" name="sPage" value="<?php print $param["sPage"]; ?>" />
        <input type="hidden" name="fMNo" value="<?php print $param["fMNo"]; ?>" />
        <input type="hidden" name="pdfNo" value="<?php print $param["pdfNo"]; ?>" />
        <input type="hidden" name="docNo" value="<?php print $param["docNo"]; ?>" />

        <table border="0" cellpadding="5" cellspacing="1">
            <tr>
                <th>備考</th>
                <td><textarea name="note" cols="50" rows="10"><?php print $param["note"]; ?></textarea></td>
            </tr>
            <tr>
                <th>PDFファイル<?php print $param["purpose"]; ?></th>
                <td><input type="file" name="pdfFile" /></td>
            </tr>
        </table>

        <a href="javascript:fnFManagerViewEditCheck();"><img src="./images/<?php print $param["btnImage"]; ?>" /></a>　
        <a href="javascript:form.act.value='fManagerView';form.submit();"><img src="./images/btn_return.png" /></a>　
        <?php
        if ($param["pdfNo"]) {
        ?>
            <a href="javascript:fnFManagerViewDeleteCheck(<?php print $param["pdfNo"]; ?>);"><img src="./images/btn_del.png" /></a>
        <?php
        }
        ?>

    </form>
<?php
}
