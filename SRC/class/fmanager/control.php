<?php
require('class/fmanager/logic.php');
require('class/fmanager/model.php');
require('class/fmanager/view.php');

function fmanager_control()
{
    switch ($_REQUEST['act']) {

        case 'fManager':
        case 'fManagerSearch':
            subFManager();
            break;

        case 'fManagerEdit':
            subFManagerEdit();
            break;

        case 'fManagerEditComplete':
            subFManagerEditComplete();
            break;

        case 'fManagerDelete':
            subFManagerDelete();
            break;

        case 'fManagerView':
            subFManagerPdf();
            break;

        case 'fManagerViewEdit':
            subFManagerViewEdit();
            break;

        case 'fManagerViewEditComplete':
            subFManagerViewEditComplete();
            break;

        case 'fManagerViewDelete':
            subFManagerViewDelete();
            break;
    }
}
