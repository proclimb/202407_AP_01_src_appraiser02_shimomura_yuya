<?php
require('class/const/logic.php');
require('class/const/model.php');
require('class/const/view.php');

function const_control()
{
    switch ($_REQUEST['act']) {

            // 工事管理表
        case 'const':
        case 'constSearch':
            subConst();
            break;

        case 'constEdit':
            subConstEdit();
            break;

        case 'constEditComplete':
            subConstEditComplete();
            break;
    }
}
