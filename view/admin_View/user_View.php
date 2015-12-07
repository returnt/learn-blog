<?php defined('SECURITY') or die('No direct script access.');
?>

<script type="text/javascript">
    $(document).ready(function()
        {
            //$("#myTable").tablesorter();
            $("#myTable").tablesorter( {
                sortList: [[2,1]],
                //widthFixed: true,
                widgets:['zebra']
            }).tablesorterPager({
                size: 17,
                container:$('#pager'),
                positionFixed:false
            });
        }
    );
</script>

<div style="padding-left: 20px;"><a href="/admin/adduser"><img src="/img/Plus.png" width="40"></a></div><br>

<table id="myTable" class="tablesorter" border="1px" style="width: 100%;">

    <thead>
    <tr>
        <th>№</th>
        <th>ФИО</th>
        <th>Телефон</th>
        <th>E-mail</th>
        <th>Зарегистрирован</th>
        <th>Активен</th>
        <th>Обновить</th>
        <th>Удалить</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data['user'] as $value) {?>
        <tr>
            <td><?php echo $value['id_user'] ?></td>
            <td><?php echo $value['chat_user_first_name'] ?> <?php echo $value['user_name'] ?> <?php echo $value['chat_user_patronumic'] ?></td>
            <td><?php echo $value['chat_user_tel'] ?></td>
            <td><?php echo $value['user_email'] ?></td>
            <td><?php echo $value['chat_user_data_reg'] ?></td>
            <td style="text-align: center;"><input type="checkbox" id="<?php echo $value['id_user'] ?>" onclick="activUser('<?php echo $value['id_user'] ?>');" <?php if($value['chat_user_activ']==1){echo 'checked';}?> ></td>
            <td style="text-align: center;"><a href=""> <img src="/img/update.png" width="20"></a></td>
            <td style="text-align: center;"><a <?php if(strpos($_SESSION['chatuserboobscooki'][4], '6')){echo 'href="/admin/delluser/'.$value['id_user'];}else{echo 'onclick="alert(\'У вас недостаточно прав для удаления пользователя! Обратитесь к Ультра админу.\');"';} ?>"> <img src="/img/statuszakazno.png" width="20"></a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<div id="pager" class="pager">
    <form>
        <img src="/img22/first.png" class="first" width="30" height="30">
        <img src="/img22/prev.png" class="prev" width="30" height="30">
        <input disabled type="text" class="pagedisplay" style="width: 80px; text-align: center;">
        <img src="/img22/next.png" class="next" width="30" height="30">
        <img src="/img22/last.png" class="last" width="30" height="30">
        <select class="pagesize">
            <option selected="selected"  value="17">17</option>
            <option value="30">30</option>
            <option value="50">50</option>
            <option  value="100">100</option>
            <option  value="100000000000000000000000000000000000000000000">Все</option>
        </select>
    </form>
</div>


