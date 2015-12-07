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

<div style="position: fixed; z-index: 2; background-color: #FFF;">
    <form method="POST">
        <label>Токин</label> <input type="text" name="token" placeholder="token">
        <label>С</label> <input value="" type="text" name="data_s" placeholder="гггг-мм-дд чч:мм:сс">
        <label>До</label> <input value="" type="text" name="data_do" placeholder="гггг-мм-дд чч:мм:сс">
        <label>Оператор</label> <select name="operator" style="width: 200px;">
            <option value="">Оператор</option>
            <?php foreach ($data['operator'] as $value) { ?>
            <option value="<?php echo $value['id_user']; ?>"><?php echo $value['user_name'].' '.$value['chat_user_first_name']; ?></option>
            <?php } ?>
        </select>
        <label>Статус чата</label> <select name="chat_status">
            <option value="">Состояние</option>
            <option value="1">В ожыдании обработки</option>
            <option value="2">В обработке</option>
            <option value="3">завершены</option>
        </select>
        <input type="submit" name="chat_filtr" value="Фильтровать"> <input type="submit" value="Сбросить">
    </form>
</div><br><br>
<div class="col-xs-6">
    <table id="myTable" class="tablesorter" border="1px" style="width: 100%;">
        
        <thead>
            <tr>
                <th>Токин</th>
                <th>Сайт</th>
                <th>Время</th>
                <th>Оператор</th>
                <th>#</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($data['array_chat'] as $value) {?>
            <tr>
                <td><a href="/storeadmin/activchat/<?php echo $value['chat_token'] ?>" target="frame_chat"><?php echo $value['chat_token'] ?></a></td>
                <td><?php echo $value['chat_zakaz_site'] ?></td>
                <td><?php echo $value['chat_create_time'] ?></td>
                <td><?php echo $value['chat_user_first_name'] ?></td>
                <td><img width="10" height="10" src="<?php if($value['chat_status']==1){echo '/img/statuszakazok.png';}elseif ($value['chat_status']==2) {echo '/img/statusobrabotka.png';}else {echo'/img/statuszakazno.png';} ?>"></td>
                <td><img width="10" height="10" src="<?php if($value['chat_rejim']!=1){echo '/img/online.png';}else{echo '/img/ofline.png';} ?>"></td>
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
</div>

<div class="col-xs-6">
    <iframe name="frame_chat" frameborder="0" width="600" height="535" style="border: double"></iframe>
</div>
