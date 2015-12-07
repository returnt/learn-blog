<?php defined('SECURITY') or die('No direct script access.');?>
<html>
<head>
    <title>История чатов</title>
    <link rel="stylesheet" href="/css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/js/tablesorter/addons/pager/jquery.tablesorter.pager.css">
    <link rel="stylesheet" href="/js/tablesorter/themes/green/style.css">
    <script type="text/javascript" src="/js/jquery/jquery-2.1.3.min.js"></script>
    <script type="text/javascript" src="/css/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/tablesorter/jquery-latest.js"></script>
    <script type="text/javascript" src="/js/tablesorter/jquery.tablesorter.min.js"></script>
    <script type="text/javascript" src="/js/tablesorter/addons/pager/jquery.tablesorter.pager.js"></script>
    <script type="text/javascript" src="/js/admin/admin.js"></script>

</head>
<body>
    <ul class="nav nav-pills" style="position: fixed; z-index: 100; background-color: #bffdff; width: 100%;">
        <li ><a href="/admin">Админка</a></li>
        <li style="width: 88px; text-align: center;"><a href="/admin/chatactiv">Чат</a></li>
        <li style="width: 88px; text-align: center;"><a href="/admin/chat">Архив</a></li>
        <li style="width: 100px; text-align: center;"><a href="/admin/user">Пользователи</a></li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                Справочники <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="/admin/tarifi">Тарифы</a></li>
                <li><a href="/admin/rozdel">Разделы</a></li>
                <li><a href="/admin/period">Период заказа</a></li>
                <li class="divider"></li>
                <li><a href="#">Отдельная ссылка</a></li>
            </ul>
        </li>
    </ul><br><br><br>
    <?php include 'view/'.$master_page.'/'.$page.'.php';?>
</body>
</html>

<script type="text/javascript">
    var id;
    function addClass (id){
        $('.'+id).addClass('active');
    }
</script>
