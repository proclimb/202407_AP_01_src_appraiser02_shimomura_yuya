<?php

function subConstView($param)
{
?>
    <h1>工事管理一覧</h1>

    <form name="form" id="form" action="index.php" method="post">
        <input type="hidden" name="act" value="constSearch" />
        <input type="hidden" name="orderBy" value="<?php print $param["orderBy"] ?>" />
        <input type="hidden" name="orderTo" value="<?php print $param["orderTo"] ?>" />
        <input type="hidden" name="sPage" value="<?php print $param["sPage"] ?>" />
        <input type="hidden" name="articleNo" />

        <div class="search">
            <table border="0" cellpadding="2" cellspacing="0">
                <tr>
                    <th>除外</th>
                    <td><input type="checkbox" name="sDel" value="0" <?php if ($param["sDel"] == 0) print ' checked="checked"' ?> /></td>
                </tr>
                <tr>
                    <th>物件名</th>
                    <td><input type="text" name="sArticle" value="<?php print $param["sArticle"] ?>" size="50" /></td>
                </tr>
                <tr>
                    <th>施工業者</th>
                    <td><input type="text" name="sConstTrader" value="<?php print $param["sConstTrader"] ?>" size="30" /></td>
                </tr>
                <tr>
                    <th>工事中</th>
                    <td><input type="checkbox" name="sConstFlg1" value="1" <?php if ($param["sConstFlg1"]) print ' checked="checked"' ?> /> <?php print fnConstFlgName(0) ?>
                        <input type="checkbox" name="sConstFlg2" value="1" <?php if ($param["sConstFlg2"]) print ' checked="checked"' ?> /> <?php print fnConstFlgName(1) ?>
                        <input type="checkbox" name="sConstFlg3" value="1" <?php if ($param["sConstFlg3"]) print ' checked="checked"' ?> /> <?php print fnConstFlgName(2) ?>
                        <input type="checkbox" name="sConstFlg4" value="1" <?php if ($param["sConstFlg4"]) print ' checked="checked"' ?> /> <?php print fnConstFlgName(3) ?>
                    </td>
                </tr>
                <tr>
                    <th>内装担当者</th>
                    <td><input type="text" name="sInteriorCharge" value="<?php print $param["sInteriorCharge"] ?>" size="30" /></td>
                </tr>
            </table>
        </div>

        <input type="image" src="./images/btn_search.png" onclick="form.act.value='constSearch';form.sPage.value=1;form.submit();" />

        <hr />
    </form>

    <?php
    if ($_REQUEST['act'] == 'const') {
        return;
    }

    $sql = fnSqlConstList(0, $param);
    $res = mysqli_query($param["conn"], $sql);
    $row  = mysqli_fetch_array($res);

    $count = $row[0];

    $sPage = fnPage($count, $param["sPage"], 'constSearch');
    ?>

    <div class="list">
        <table border="0" cellpadding="5" cellspacing="1">
            <tr>
                <th class="list_head">物件名<?php fnOrder('ARTICLE', 'constSearch') ?></th>
                <th class="list_head">部屋番号<?php fnOrder('ROOM', 'constSearch') ?></th>
                <th class="list_head">住所<?php fnOrder('ADDRESS', 'constSearch') ?></th>
                <th class="list_head">鍵場所<?php fnOrder('KEYPLACE', 'constSearch') ?></th>
                <th class="list_head">施工業者<?php fnOrder('CONSTTRADER', 'constSearch') ?></th>
                <th class="list_head">内装見越額<?php fnOrder('INTERIORPRICE', 'constSearch') ?></th>
                <th class="list_head">工事金額<?php fnOrder('CONSTPRICE', 'constSearch') ?></th>
                <th class="list_head">追加工事<?php fnOrder('CONSTADD', 'constSearch') ?></th>
                <th class="list_head">買取決済<?php fnOrder('PURCHASEDT', 'constSearch') ?></th>
                <th class="list_head">工期<?php fnOrderConstWork('WORKSTARTDT', 'WORKENDDT', 'constSearch') ?></th>
                <th class="list_head">荷&amp;鍵引取<?php fnOrder('RECEIVE', 'constSearch') ?></th>
                <th class="list_head">電気水道開栓/閉栓<?php fnOrder('LINEOPENDT', 'constSearch') ?></th>
                <th class="list_head">電気水道開栓/閉栓連絡日<?php fnOrder('LINEOPENCONTACTDT', 'constSearch') ?></th>
                <th class="list_head">照明発注<?php fnOrder('LIGHTORDER', 'constSearch') ?></th>
                <th class="list_head">現調<?php fnOrder('SITEDT', 'constSearch') ?></th>
                <th class="list_head">営業担当者<?php fnOrder('SELLCHARGE', 'constSearch') ?></th>
                <th class="list_head">内装担当者<?php fnOrder('INTERIORCHARGE', 'constSearch') ?></th>
            </tr>
            <?php
            $sql = fnSqlConstList(1, $param);
            $res = mysqli_query($param["conn"], $sql);
            $i = 0;
            while ($row = mysqli_fetch_array($res)) {
                $articleNo      = htmlspecialchars($row["ARTICLENO"]);
                $article        = htmlspecialchars($row["ARTICLE"]);
                $room           = htmlspecialchars($row["ROOM"]);
                $address        = htmlspecialchars($row["ADDRESS"]);
                $constTrader    = htmlspecialchars($row["CONSTTRADER"]);
                $interiorPrice  = htmlspecialchars(fnNumFormat((int)$row["INTERIORPRICE"]));
                $constPrice     = htmlspecialchars(fnNumFormat((int)$row["CONSTPRICE"]));
                $constAdd       = htmlspecialchars($row["CONSTADD"]);
                $purchaseDT     = htmlspecialchars($row["PURCHASEDT"]);
                $workStartDT    = htmlspecialchars($row["WORKSTARTDT"]);
                $workEndDT      = htmlspecialchars($row["WORKENDDT"]);
                $receive        = htmlspecialchars($row["RECEIVE"]);
                $lineOpenDT     = htmlspecialchars($row["LINEOPENDT"]);
                $lineCloseDT    = htmlspecialchars($row["LINECLOSEDT"]);
                $siteDT         = htmlspecialchars($row["SITEDT"]);
                $sellCharge     = htmlspecialchars($row["SELLCHARGE"]);
                $interiorCharge = htmlspecialchars($row["INTERIORCHARGE"]);
                $keyPlace       = htmlspecialchars($row["KEYPLACE"]);
                $lineOpenContactDT = htmlspecialchars($row["LINEOPENCONTACTDT"]);
                $lineCloseContactDT = htmlspecialchars($row["LINECLOSECONTACTDT"]);
                $lightOrder     = htmlspecialchars($row["LIGHTORDER"]);
            ?>
                <tr>
                    <td class="list_td<?php print $i ?>"><a href="javascript:form.act.value='constEdit';form.articleNo.value=<?php print $articleNo ?>;form.submit();"><?php print $article ?></a></td>
                    <td class="list_td<?php print $i ?>"><?php print $room ?></td>
                    <td class="list_td<?php print $i ?>"><?php print $address ?></td>
                    <td class="list_td<?php print $i ?>"><?php print $keyPlace ?></td>
                    <td class="list_td<?php print $i ?>"><?php print $constTrader ?></td>
                    <td class="list_td<?php print $i ?>" align="right"><?php print $interiorPrice ?></td>
                    <td class="list_td<?php print $i ?>" align="right"><?php print $constPrice ?></td>
                    <td class="list_td<?php print $i ?>"><?php print $constAdd ?></td>
                    <td class="list_td<?php print $i ?>"><?php print $purchaseDT ?></td>
                    <td class="list_td<?php print $i ?>"><?php print $workStartDT ?>～<?php print $workEndDT ?></td>
                    <td class="list_td<?php print $i ?>"><?php print $receive ?></td>
                    <td class="list_td<?php print $i ?>"><?php print $lineOpenDT ?>～<?php print $lineCloseDT ?></td>
                    <td class="list_td<?php print $i ?>"><?php print $lineOpenContactDT ?>～<?php print $lineCloseContactDT ?></td>
                    <td class="list_td<?php print $i ?>"><?php if ($lightOrder == 1) print '済' ?></td>
                    <td class="list_td<?php print $i ?>"><?php print $siteDT ?></td>
                    <td class="list_td<?php print $i ?>"><?php print $sellCharge ?></td>
                    <td class="list_td<?php print $i ?>"><?php print $interiorCharge ?></td>
                </tr>
            <?php
                $i = ($i + 1) % 2;
            }
            ?>
        </table>
    </div>
<?php
}

//
//工事管理表編集画面
//
function subConstEditView($param)
{
?>

    <script type="text/javascript" src="./js/const.js"></script>
    <script>
        var cal1 = new JKL.Calendar("cal1", "form", "purchaseDT");
        var cal2 = new JKL.Calendar("cal2", "form", "workStartDT");
        var cal3 = new JKL.Calendar("cal3", "form", "workEndDT");
        var cal4 = new JKL.Calendar("cal4", "form", "lineOpenDT");
        var cal5 = new JKL.Calendar("cal5", "form", "lineCloseDT");
        var cal6 = new JKL.Calendar("cal6", "form", "siteDate");
        var cal7 = new JKL.Calendar("cal7", "form", "lineOpenContactDT");
        var cal8 = new JKL.Calendar("cal8", "form", "lineCloseContactDT");
        var cal9 = new JKL.Calendar("cal9", "form", "leavingDT");
    </script>

    <h1>工事更新</h1>

    <form name="form" id="form" action="index.php" method="post">
        <input type="hidden" name="act" />
        <input type="hidden" name="sDel" value="<?php print $param["sDel"] ?>" />
        <input type="hidden" name="sArticle" value="<?php print $param["sArticle"] ?>" />
        <input type="hidden" name="sConstFlg1" value="<?php print $param["sConstFlg1"] ?>" />
        <input type="hidden" name="sConstFlg2" value="<?php print $param["sConstFlg2"] ?>" />
        <input type="hidden" name="sConstFlg3" value="<?php print $param["sConstFlg3"] ?>" />
        <input type="hidden" name="sConstFlg4" value="<?php print $param["sConstFlg4"] ?>" />
        <input type="hidden" name="sInteriorCharge" value="<?php print $param["sInteriorCharge"] ?>" />
        <input type="hidden" name="orderBy" value="<?php print $param["orderBy"] ?>" />
        <input type="hidden" name="orderTo" value="<?php print $param["orderTo"] ?>" />
        <input type="hidden" name="sPage" value="<?php print $param["sPage"] ?>" />
        <input type="hidden" name="articleNo" value="<?php print $param["articleNo"] ?>" />
        <input type="hidden" name="article" value="<?php print $param["article"] ?>" />
        <input type="hidden" name="room" value="<?php print $param["room"] ?>" />
        <input type="hidden" name="address" value="<?php print $param["address"] ?>" />
        <input type="hidden" name="keyPlace" value="<?php print $param["keyPlace"] ?>" />
        <input type="hidden" name="sellCharge" value="<?php print $param["sellCharge"] ?>" />

        <table border="0" cellpadding="5" cellspacing="1">
            <tr>
                <th>物件名</th>
                <td><?php print $param["article"] ?></td>
            </tr>
            <tr>
                <th>部屋番号</th>
                <td><?php print $param["room"] ?></td>
            </tr>
            <tr>
                <th>住所</th>
                <td><?php print $param["address"] ?></td>
            </tr>
            <tr>
                <th>面積</th>
                <td><input type="text" name="area" value="<?php print $param["area"] ?>" /></td>
            </tr>
            <tr>
                <th>築年</th>
                <td><input type="text" name="years" value="<?php print $param["years"] ?>" /></td>
            </tr>
            <tr>
                <th>販売予定額</th>
                <td><input type="text" name="sellPrice" value="<?php print $param["sellPrice"] ?>" />円</td>
            </tr>
            <tr>
                <th>内装見越額</th>
                <td><input type="text" name="interiorPrice" value="<?php print $param["interiorPrice"] ?>" />円</td>
            </tr>
            <tr>
                <th>施工業者</th>
                <td><input type="text" name="constTrader" value="<?php print $param["constTrader"] ?>" /></td>
            </tr>
            <tr>
                <th>工事金額</th>
                <td><input type="text" name="constPrice" value="<?php print $param["constPrice"] ?>" />円</td>
            </tr>
            <tr>
                <th>追加工事</th>
                <td><input type="text" name="constAdd" value="<?php print $param["constAdd"] ?>" /></td>
            </tr>
            <tr>
                <th>備考</th>
                <td><textarea name="constNote" cols="50" rows="10"><?php print $param["constNote"] ?></textarea></td>
            </tr>
            <tr>
                <th>買取決済</th>
                <td>
                    <input type="text" name="purchaseDT" value="<?php print $param["purchaseDT"] ?>" />
                    <a href="javascript:cal1.write();" onChange="cal1.getFormValue(); cal1.hide();"><img src="./images/b_calendar.png"></a><span id="cal1"></span>
                </td>
            </tr>
            <tr>
                <th>工期</th>
                <td>
                    <input type="text" name="workStartDT" value="<?php print $param["workStartDT"] ?>" />
                    <a href="javascript:cal2.write();" onChange="cal2.getFormValue(); cal2.hide();"><img src="./images/b_calendar.png"></a><span id="cal2"></span>～
                    <input type="text" name="workEndDT" value="<?php print $param["workEndDT"] ?>" />
                    <a href="javascript:cal3.write();" onChange="cal3.getFormValue(); cal3.hide();"><img src="./images/b_calendar.png"></a><span id="cal3"></span>
                </td>
            </tr>
            <tr>
                <th>電気水道開栓</th>
                <td>
                    <input type="text" name="lineOpenDT" value="<?php print $param["lineOpenDT"] ?>" />
                    <a href="javascript:cal4.write();" onChange="cal4.getFormValue(); cal4.hide();"><img src="./images/b_calendar.png"></a><span id="cal4"></span>
                </td>
            </tr>
            <tr>
                <th>電気水道閉栓</th>
                <td>
                    <input type="text" name="lineCloseDT" value="<?php print $param["lineCloseDT"] ?>" />
                    <a href="javascript:cal5.write();" onChange="cal5.getFormValue(); cal5.hide();"><img src="./images/b_calendar.png"></a><span id="cal5"></span>
                </td>
            </tr>
            <tr>
                <th>電気水道開栓連絡日</th>
                <td>
                    <input type="text" name="lineOpenContactDT" value="<?php print $param["lineOpenContactDT"] ?>" />
                    <a href="javascript:cal7.write();" onChange="cal7.getFormValue(); cal7.hide();"><img src="./images/b_calendar.png"></a><span id="cal7"></span>
                    &nbsp;&nbsp;<b>電気連絡者</b>
                    <input type="text" name="electricityCharge" value="<?php print $param["electricityCharge"] ?>" />
                </td>
            </tr>
            <tr>
                <th>電気水道閉栓連絡日</th>
                <td>
                    <input type="text" name="lineCloseContactDT" value="<?php print $param["lineCloseContactDT"] ?>" />
                    <a href="javascript:cal8.write();" onChange="cal8.getFormValue(); cal8.hide();"><img src="./images/b_calendar.png"></a><span id="cal8"></span>
                    &nbsp;&nbsp;<b>ガス連絡者</b>
                    <input type="text" name="gasCharge" value="<?php print $param["gasCharge"] ?>" />
                </td>
            </tr>
            <tr>
                <th>備考</th>
                <td><textarea name="lineContactNote" cols="50" rows="10"><?php print $param["lineContactNote"] ?></textarea></td>
            </tr>
            <tr>
                <th>照明発注</th>
                <td><input type="checkbox" name="lightOrder" value="1" <?php if ($param["lightOrder"] == 1) print ' checked="checked"' ?> /> 済</td>
            </tr>
            <tr>
                <th>荷＆鍵引取</th>
                <td><input type="text" name="receive" value="<?php print $param["receive"] ?>" /></td>
            </tr>
            <tr>
                <th>給湯</th>
                <td><input type="text" name="hotWater" value="<?php print $param["hotWater"] ?>" /></td>
            </tr>
            <tr>
                <th>現調</th>
                <td>
                    <input type="text" name="siteDate" value="<?php print $param["siteDate"] ?>" />
                    <a href="javascript:cal6.write();" onChange="cal6.getFormValue(); cal6.hide();"><img src="./images/b_calendar.png"></a><span id="cal6"></span><br />
                    <select name="siteHour">
                        <?php for ($i = 0; $i < 24; $i++) { ?>
                            <option value="<?php print $i ?>" <?php if ($i == $param["siteHour"]) print ' selected="selected"' ?>><?php print $i ?></option>
                        <?php } ?>
                    </select>：
                    <select name="siteMinute">
                        <?php for ($i = 0; $i < 60; $i++) { ?>
                            <option value="<?php print $i ?>" <?php if ($i == $param["siteMinute"]) print ' selected="selected"' ?>><?php print $i ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>届出用紙</th>
                <td><input type="text" name="leavingForm" value="<?php print $param["leavingForm"] ?>" /></td>
            </tr>
            <tr>
                <th>届出期日</th>
                <td>
                    <input type="text" name="leavingDT" value="<?php print $param["leavingDT"] ?>" />
                    <a href="javascript:cal9.write();" onChange="cal9.getFormValue(); cal9.hide();"><img src="./images/b_calendar.png"></a><span id="cal9"></span>
                </td>
            </tr>
            <tr>
                <th>カギ</th>
                <td><?php print $param["keyPlace"] ?></td>
            </tr>
            <tr>
                <th>管理会社</th>
                <td><input type="text" name="manageCompany" value="<?php print $param["manageCompany"] ?>" /></td>
            </tr>
            <tr>
                <th>管理室</th>
                <td><input type="text" name="floorPlan" value="<?php print $param["floorPlan"] ?>" /></td>
            </tr>
            <tr>
                <th>前所有者</th>
                <td><input type="text" name="formerOwner" value="<?php print $param["formerOwner"] ?>" /></td>
            </tr>
            <tr>
                <th>仲介会社　担当</th>
                <td><input type="text" name="brokerCharge" value="<?php print $param["brokerCharge"] ?>" /></td>
            </tr>
            <tr>
                <th>仲介会社　（連絡先）</th>
                <td><input type="text" name="brokerContact" value="<?php print $param["brokerContact"] ?>" /></td>
            </tr>
            <tr>
                <th>内装担当者</th>
                <td><input type="text" name="interiorCharge" value="<?php print $param["interiorCharge"] ?>" /></td>
            </tr>
            <tr>
                <th>営業担当者</th>
                <td><?php print $param["sellCharge"] ?></td>
            </tr>
            <tr>
                <th>工事</th>
                <td>
                    <input type="checkbox" name="constFlg1" value="1" <?php if ($param["constFlg1"] == 1) print ' checked="checked"' ?> /> <?php print fnConstFlgName(0) ?>
                    <input type="checkbox" name="constFlg2" value="1" <?php if ($param["constFlg2"] == 1) print ' checked="checked"' ?> /> <?php print fnConstFlgName(1) ?>
                    <input type="checkbox" name="constFlg3" value="1" <?php if ($param["constFlg3"] == 1) print ' checked="checked"' ?> /> <?php print fnConstFlgName(2) ?>
                    <input type="checkbox" name="constFlg4" value="1" <?php if ($param["constFlg4"] == 1) print ' checked="checked"' ?> /> <?php print fnConstFlgName(3) ?>
                </td>
            </tr>
        </table>

        <a href="javascript:fnConstEditCheck();"><img src="./images/btn_load.png" /></a>　
        <a href="javascript:form.act.value='constSearch';form.submit();"><img src="./images/btn_return.png" /></a><br />
    </form>
<?php
}
?>