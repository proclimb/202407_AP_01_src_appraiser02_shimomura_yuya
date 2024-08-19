<?php

function subTradeView($param)
{
?>
    <h1>業者管理一覧</h1>

    <form name="form" id="form" action="index.php" method="post">
        <input type="hidden" name="act" value="tradeSearch" />
        <input type="hidden" name="orderBy" value="<?php print $param["orderBy"]; ?>" />
        <input type="hidden" name="orderTo" value="<?php print $param["orderTo"]; ?>" />
        <input type="hidden" name="sPage" value="<?php print $param["sPage"]; ?>" />
        <input type="hidden" name="tradeNo" />

        <a href="javascript:form.act.value='tradeEdit';form.submit();"><img src="./images/btn_enter.png"></a>

        <div class="search">
            <table border="0" cellpadding="2" cellspacing="0">
                <tr>
                    <th>除外</th>
                    <td><input type="checkbox" name="sDel" value="0" <?php if ($param["sDel"] == 0) print ' checked="checked"'; ?> /></td>
                    <th>郵便番号</th>
                    <td><input type="text" name="sZip" value="<?php print $param["sZip"]; ?>" size="15" /></td>
                </tr>
                <tr>
                    <th>業者名</th>
                    <td><input type="text" name="sName" value="<?php print $param["sName"]; ?>" size="30" /></td>
                    <th>都道府県</th>
                    <td><input type="text" name="sPrefecture" value="<?php print $param["sPrefecture"]; ?>" size="15" /></td>
                </tr>
                <tr>
                    <th>支店名</th>
                    <td><input type="text" name="sBranch" value="<?php print $param["sBranch"]; ?>" size="30" /></td>
                    <th>住所1</th>
                    <td><input type="text" name="sAddress1" value="<?php print $param["sAddress1"]; ?>" size="30" /></td>
                </tr>
                <tr>
                    <th>&nbsp;</th>
                    <td>&nbsp;</td>
                    <th>住所2</th>
                    <td><input type="text" name="sAddress2" value="<?php print $param["sAddress2"]; ?>" size="50" /></td>
                </tr>
                <tr>
                    <th>&nbsp;</th>
                    <td>&nbsp;</td>
                    <th>TEL</th>
                    <td><input type="text" name="sTel" value="<?php print $param["sTel"]; ?>" size="30" /></td>
                </tr>
                <tr>
                    <th>&nbsp;</th>
                    <td>&nbsp;</td>
                    <th>FAX</th>
                    <td><input type="text" name="sFax" value="<?php print $param["sFax"]; ?>" size="30" /></td>
                </tr>
                <tr>
                    <th>&nbsp;</th>
                    <td>&nbsp;</td>
                    <th>携帯電話</th>
                    <td><input type="text" name="sMobile" value="<?php print $param["sMobile"]; ?>" size="30" /></td>
                </tr>
            </table>
        </div>

        <input type="image" src="./images/btn_search.png" onclick="form.act.value='tradeSearch';form.sPage.value=1;form.submit();" />

        <hr />

        <?php
        if ($_REQUEST['act'] == 'trade') {
            return;
        }

        $sql = fnSqlTradeList(0, $param);
        $res = mysqli_query($param["conn"], $sql);
        $row = mysqli_fetch_array($res);

        $count = $row[0];

        $sPage = fnPage($count, $param["sPage"], 'tradeSearch');
        ?>

        <div class="list">
            <table border="0" cellpadding="5" cellspacing="1">
                <tr>
                    <th class="list_head">業者名<?php fnOrder('NAME', 'tradeSearch'); ?></th>
                    <th class="list_head">支店名<?php fnOrder('BRANCH', 'tradeSearch'); ?></th>
                    <th class="list_head">郵便番号<?php fnOrder('ZIP', 'tradeSearch'); ?></th>
                    <th class="list_head">都道府県<?php fnOrder('PREFECTURE', 'tradeSearch'); ?></th>
                    <th class="list_head">住所1<?php fnOrder('ADDRESS1', 'tradeSearch'); ?></th>
                    <th class="list_head">住所2<?php fnOrder('ADDRESS2', 'tradeSearch'); ?></th>
                    <th class="list_head">TEL<?php fnOrder('TEL', 'tradeSearch'); ?></th>
                    <th class="list_head">FAX<?php fnOrder('FAX', 'tradeSearch'); ?></th>
                    <th class="list_head">携帯電話<?php fnOrder('MOBILE', 'tradeSearch'); ?></th>
                </tr>
                <?php
                $sql = fnSqlTradeList(1, $param);
                $res = mysqli_query($param["conn"], $sql);
                $i = 0;
                while ($row = mysqli_fetch_array($res)) {
                    $tradeNo    = htmlspecialchars($row[0]);
                    $name       = htmlspecialchars($row[1]);
                    $branch     = htmlspecialchars($row[2]);
                    $zip        = htmlspecialchars($row[3]);
                    $prefecture = htmlspecialchars($row[4]);
                    $address1   = htmlspecialchars($row[5]);
                    $address2   = htmlspecialchars($row[6]);
                    $tel        = htmlspecialchars($row[7]);
                    $fax        = htmlspecialchars($row[8]);
                    $mobile     = htmlspecialchars($row[9]);
                ?>
                    <tr>
                        <td class="list_td<?php print $i; ?>"><a href="javascript:form.act.value='tradeEdit';form.tradeNo.value=<?php print $tradeNo; ?>;form.submit();"><?php print $name; ?></a></td>
                        <td class="list_td<?php print $i; ?>"><?php print $branch; ?></td>
                        <td class="list_td<?php print $i; ?>"><?php print $zip; ?></td>
                        <td class="list_td<?php print $i; ?>"><?php print $prefecture; ?></td>
                        <td class="list_td<?php print $i; ?>"><?php print $address1; ?></td>
                        <td class="list_td<?php print $i; ?>"><?php print $address2; ?></td>
                        <td class="list_td<?php print $i; ?>"><?php print $tel; ?></td>
                        <td class="list_td<?php print $i; ?>"><?php print $fax; ?></td>
                        <td class="list_td<?php print $i; ?>"><?php print $mobile; ?></td>
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

//
//業者編集画面
//
function subTradeEditView($param)
{

?>
    <script type="text/javascript" src="./js/trade.js"></script>

    <h1>業者<?php print $param["purpose"]; ?></h1>

    <form name="form" id="form" action="index.php" method="post">
        <input type="hidden" name="act" />
        <input type="hidden" name="sDel" value="<?php print $param["sDel"]; ?>" />
        <input type="hidden" name="sName" value="<?php print $param["sName"]; ?>" />
        <input type="hidden" name="sBranch" value="<?php print $param["sBranch"]; ?>" />
        <input type="hidden" name="sZip" value="<?php print $param["sZip"]; ?>" />
        <input type="hidden" name="sPrefecture" value="<?php print $param["sPrefecture"]; ?>" />
        <input type="hidden" name="sAddress1" value="<?php print $param["sAddress1"]; ?>" />
        <input type="hidden" name="sAddress2" value="<?php print $param["sAddress2"]; ?>" />
        <input type="hidden" name="sTel" value="<?php print $param["sTel"]; ?>" />
        <input type="hidden" name="sFax" value="<?php print $param["sFax"]; ?>" />
        <input type="hidden" name="sMobile" value="<?php print $param["sMobile"]; ?>" />
        <input type="hidden" name="sInterior" value="<?php print $param["sInterior"]; ?>" />
        <input type="hidden" name="orderBy" value="<?php print $param["orderBy"]; ?>" />
        <input type="hidden" name="orderTo" value="<?php print $param["orderTo"]; ?>" />
        <input type="hidden" name="sPage" value="<?php print $param["sPage"]; ?>" />
        <input type="hidden" name="tradeNo" value="<?php print $param["tradeNo"]; ?>" />

        <table border="0" cellpadding="5" cellspacing="1">
            <tr>
                <th>除外</th>
                <td><input type="radio" name="del" value="1" checked="checked" /> 非除外
                    <input type="radio" name="del" value="0" <?php if ($param["del"] == '0') print ' checked="checked"'; ?> /> 除外
                </td>
            </tr>
            <tr>
                <th>業者名<span class="red">（必須）</span></th>
                <td><input type="text" name="name" value="<?php print $param["name"]; ?>" /></td>
            </tr>
            <tr>
                <th>業者名（よみ）</th>
                <td><input type="text" name="nameFuri" value="<?php print $param["nameFuri"]; ?>" /></td>
            </tr>
            <tr>
                <th>支店名</th>
                <td><input type="text" name="branch" value="<?php print $param["branch"]; ?>" /></td>
            </tr>
            <tr>
                <th>支店名（よみ）</th>
                <td><input type="text" name="branchFuri" value="<?php print $param["branchFuri"]; ?>" /></td>
            </tr>
            <tr>
                <th>郵便番号</th>
                <td><input type="text" name="zip" value="<?php print $param["zip"]; ?>" /></td>
            </tr>
            <tr>
                <th>住所（都道府県）</th>
                <td><input type="text" name="prefecture" value="<?php print $param["prefecture"]; ?>" /></td>
            </tr>
            <tr>
                <th>住所1（市区町村名）</th>
                <td><input type="text" name="address1" value="<?php print $param["address1"]; ?>" /></td>
            </tr>
            <tr>
                <th>住所2（番地・ビル名）</th>
                <td><input type="text" name="address2" value="<?php print $param["address2"]; ?>" /></td>
            </tr>
            <tr>
                <th>TEL</th>
                <td><input type="text" name="tel" value="<?php print $param["tel"]; ?>" /></td>
            </tr>
            <tr>
                <th>FAX</th>
                <td><input type="text" name="fax" value="<?php print $param["fax"]; ?>" /></td>
            </tr>
            <tr>
                <th>携帯電話</th>
                <td><input type="text" name="mobile" value="<?php print $param["mobile"]; ?>" /></td>
            </tr>
            <tr>
                <th>内装関係</th>
                <td><input type="checkbox" name="interior" value="1" <?php if ($param["interior"] == 1) print ' checked="checked"'; ?> /></td>
            </tr>

        </table>

        <a href="javascript:fnTradeEditCheck();"><img src="./images/<?php print $param["btnImage"]; ?>" /></a>　
        <a href="javascript:form.act.value='tradeSearch';form.submit();"><img src="./images/btn_return.png" /></a>　
        <?php
        if ($param["tradeNo"]) {
        ?>
            <a href="javascript:fnTradeDeleteCheck(<?php print $param["tradeNo"]; ?>);"><img src="./images/btn_del.png" /></a>
        <?php
        }
        ?>

    </form>
<?php
}
