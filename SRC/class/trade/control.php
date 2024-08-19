<?php
require('class/trade/logic.php');
require('class/trade/model.php');
require('class/trade/view.php');

function trade_control()
{
    switch ($_REQUEST['act']) {

            // 業者管理
        case 'trade':
        case 'tradeSearch':
            subTrade();
            break;

        case 'tradeEdit':
            subTradeEdit();
            break;

        case 'tradeEditComplete':
            subTradeEditComplete();
            break;

        case 'tradeDelete':
            subTradeDelete();
            break;
    }
}
