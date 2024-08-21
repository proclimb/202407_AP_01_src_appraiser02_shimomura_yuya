<?php

function subArticleView($param)
{
?>
    <h1>物件管理一覧</h1>

    <form name="form" id="form" action="index.php" method="post">
        <input type="hidden" name="act" value="articleSearch" />
        <input type="hidden" name="orderBy" value="<?php print $param["orderBy"] ?>" />
        <input type="hidden" name="orderTo" value="<?php print $param["orderTo"] ?>" />
        <input type="hidden" name="sPage" value="<?php print $param["sPage"] ?>" />
        <input type="hidden" name="articleNo" />
        <input type="hidden" name="sName" />

        <a href="javascript:form.act.value='articleEdit';form.submit();"><img src="./images/btn_enter.png"></a>

        <div class="search">
            <table border="0" cellpadding="2" cellspacing="0">
                <tr>
                    <th>除外</th>
                    <td><input type="checkbox" name="sDel" value="0" <?php if ($param["sDel"] == 0) print ' checked="checked"' ?> /></td>
                    <th>備考</th>
                    <td><input type="text" name="sArticleNote" value="<?php print $param["sArticleNote"] ?>" size="50" /></td>
                </tr>
                <tr>
                    <th>物件名</th>
                    <td><input type="text" name="sArticle" value="<?php print $param["sArticle"] ?>" size="50" /></td>
                    <th>キーBox番号</th>
                    <td><input type="text" name="sKeyBox" value="<?php print $param["sKeyBox"] ?>" size="30" /></td>
                </tr>
                <tr>
                    <th>部屋番号</th>
                    <td><input type="text" name="sRoom" value="<?php print $param["sRoom"] ?>" size="30" /></td>
                    <th>3Dパース</th>
                    <td><input type="text" name="sDrawing" value="<?php print $param["sDrawing"] ?>" size="30" /></td>
                </tr>
                <tr>
                    <th>鍵場所</th>
                    <td><input type="text" name="sKeyPlace" value="<?php print $param["sKeyPlace"] ?>" size="30" /></td>
                    <th>営業担当者</th>
                    <td><input type="text" name="sSellCharge" value="<?php print $param["sSellCharge"] ?>" /></td>
                </tr>
            </table>
        </div>

        <input type="image" src="./images/btn_search.png" onclick="form.act.value='articleSearch';form.sPage.value=1;form.submit();" />

        <hr />

        <?php
        if ($_REQUEST['act'] == 'article') {
            return;
        }
        $sql = fnSqlArticleList(0, $param);
        $res = mysqli_query($param["conn"], $sql);
        $row = mysqli_fetch_array($res);

        $count = $row[0];

        $sPage = fnPage($count, $param["sPage"], 'articleSearch');
        ?>

        <div class="list">
            <table border="0" cellpadding="5" cellspacing="1">
                <tr>
                    <th class="list_head">物件名<?php fnOrder('ARTICLE', 'articleSearch') ?></th>
                    <th class="list_head">部屋<?php fnOrder('ROOM', 'articleSearch') ?></th>
                    <th class="list_head">鍵場所<?php fnOrder('KEYPLACE', 'articleSearch') ?></th>
                    <th class="list_head">備考<?php fnOrder('ARTICLENOTE', 'articleSearch') ?></th>
                    <th class="list_head">書類</th>
                    <th class="list_head">キーBox番号<?php fnOrder('KEYBOX', 'articleSearch') ?></th>
                    <th class="list_head">3Dパース<?php fnOrder('DRAWING', 'articleSearch') ?></th>
                    <th class="list_head">営業担当者<?php fnOrder('SELLCHARGE', 'articleSearch') ?></th>
                </tr>
                <?php
                $sql = fnSqlArticleList(1, $param);

                $res = mysqli_query($param["conn"], $sql);
                $i = 0;
                while ($row = mysqli_fetch_array($res)) {
                    $articleNo   = htmlspecialchars($row["ARTICLENO"]);
                    $article     = htmlspecialchars($row["ARTICLE"]);
                    $room        = htmlspecialchars($row["ROOM"]);
                    $keyPlace    = htmlspecialchars($row["KEYPLACE"]);
                    $articleNote = htmlspecialchars($row["ARTICLENOTE"]);
                    $keyBox      = htmlspecialchars($row["KEYBOX"]);
                    $drawing     = htmlspecialchars($row["DRAWING"]);
                    $sellCharge  = htmlspecialchars($row["SELLCHARGE"]);
                ?>
                    <tr>
                        <td class="list_td<?php print $i ?>"><a href="javascript:form.act.value='articleEdit';form.articleNo.value='<?php print $articleNo ?>';form.submit();"><?php print $article ?></a></td>
                        <td class="list_td<?php print $i ?>"><?php print $room ?></td>
                        <td class="list_td<?php print $i ?>"><?php print $keyPlace ?></td>
                        <td class="list_td<?php print $i ?>"><?php print $articleNote ?></td>
                        <td class="list_td<?php print $i ?>"><a href="javascript:form.act.value='fManager';form.sName.value='<?php print $article ?>';form.sRoom.value='<?php print $room ?>';form.submit();">表示</a></td>
                        <td class="list_td<?php print $i ?>"><?php print $keyBox  ?></td>
                        <td class="list_td<?php print $i ?>"><?php print $drawing ?></td>
                        <td class="list_td<?php print $i ?>"><?php print $sellCharge ?></td>
                    </tr>
                <?php
                    $i = ($i + 1) % 3;
                }
                ?>
            </table>
        </div>
    </form>
<?php
}

//
//物件管理編集画面
//
function subArticleEditView($param)
{
?>

    <script type="text/javascript" src="./js/article.js"></script>

    <h1>物件<?php print $param["purpose"] ?></h1>

    <form name="form" id="form" action="index.php" method="post">
        <input type="hidden" name="act" />
        <input type="hidden" name="sDel" value="<?php print $param["sDel"] ?>" />
        <input type="hidden" name="sArticle" value="<?php print $param["sArticle"] ?>" />
        <input type="hidden" name="sRoom" value="<?php print $param["sRoom"] ?>" />
        <input type="hidden" name="sKeyPlace" value="<?php print $param["sKeyPlace"]  ?>" />
        <input type="hidden" name="sArticleNote" value="<?php print $param["sArticleNote"] ?>" />
        <input type="hidden" name="sKeyBox" value="<?php print $param["sKeyBox"] ?>" />
        <input type="hidden" name="sDueDTFrom" value="<?php print $param["sDueDTFrom"] ?>" />
        <input type="hidden" name="sDueDTTo" value="<?php print $param["sDueDTTo"] ?>" />
        <input type="hidden" name="sSellCharge" value="<?php print $param["sSellCharge"] ?>" />
        <input type="hidden" name="orderBy" value="<?php print $param["orderBy"] ?>" />
        <input type="hidden" name="orderTo" value="<?php print $param["orderTo"] ?>" />
        <input type="hidden" name="sPage" value="<?php print $param["sPage"] ?>" />
        <input type="hidden" name="articleNo" value="<?php print $param["articleNo"] ?>" />

        <table border="0" cellpadding="5" cellspacing="1">
            <tr>
                <th>除外</th>
                <td>
                    <input type="radio" name="del" value="1" checked="checked" /> 非除外
                    <input type="radio" name="del" value="0" <?php if ($param["del"] == '0') print ' checked="checked"' ?> /> 除外
                </td>

            </tr>
            <tr>
                <th>物件名<span class="red">（必須）</span></th>
                <td><input type="text" name="article" value="<?php print $param["article"] ?>" /></td>
            </tr>
            <tr>
                <th>部屋番号</th>
                <td><input type="text" name="room" value="<?php print $param["room"] ?>" /></td>
            </tr>
            <tr>
                <th>鍵場所</th>
                <td><textarea name="keyPlace" cols="50" rows="10"><?php print $param["keyPlace"] ?></textarea></td>
            </tr>
            <tr>
                <th>住所</th>
                <td><input type="text" name="address" value="<?php print $param["address"] ?>" /></td>
            </tr>
            <tr>
                <th>備考</th>
                <td><textarea name="articleNote" cols="50" rows="10"><?php print $param["articleNote"] ?></textarea></td>
            </tr>
            <tr>
                <th>キーBox番号</th>
                <td><input type="text" name="keyBox" value="<?php print $param["keyBox"] ?>" /></td>
            </tr>
            <tr>
                <th>3Dパース</th>
                <td><input type="text" name="drawing" value="<?php print $param["drawing"] ?>" /></td>
            </tr>
            <tr>
                <th>営業担当者</th>
                <td><input type="text" name="sellCharge" value="<?php print $param["sellCharge"] ?>" /></td>
            </tr>
        </table>

        <a href="javascript:fnArticleEditCheck();"><img src="./images/<?php print $param["btnImage"] ?>" /></a>　
        <a href="javascript:form.act.value='articleSearch';form.submit();"><img src="./images/btn_return.png" /></a>
        <?php if ($param["articleNo"]) { ?>
            &nbsp;&nbsp;<a href="javascript:fnArticleDeleteCheck(<?php print $param["articleNo"] ?>);"><img src="./images/btn_del.png" /></a>
        <?php } ?>
    </form>
<?php
}
