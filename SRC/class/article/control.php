<?php
require('class/article/logic.php');
require('class/article/model.php');
require('class/article/view.php');

function article_control()
{
    switch ($_REQUEST['act']) {

            // 物件管理
        case 'article':
        case 'articleSearch':
            subArticle();
            break;

        case 'articleEdit':
            subArticleEdit();
            break;

        case 'articleEditComplete':
            subArticleEditComplete();
            break;

        case 'articleDelete':
            subArticleDelete();
            break;
    }
}
