<?php defined('SECURITY') or die('No direct script access.');?>

<form method="post">
    <label>Название тарифа</label> <input type="text" name="chat_time_zakaz_id">
    <label>Описание тарифа</label> <input type="text" name="chat_time_zakaz_period">
    <label>Цена</label> <input type="text" name="chat_tarif_cost">
    <label>Количество чатов</label> <input type="text" name="chat_tarif_dialog_sum">
    <input type="submit" name="add" value="Добавить ">
    <input type="submit" name="dell" value="Удалить ">


    <table border="1" width="1000" >
        <thead style="text-align: center; font-size: 14pt">
        <tr>
            <td>Выбрать</td>
            <td>№</td>
            <td>Название тарифа</td>
            <td>Описание тарифа</td>
            <td>Стоимость</td>
            <td>Количество чатов</td>
        </tr>
        </thead>
        <?php foreach($data['tarif'] as $val){ ?>
            <tr>
                <td style="text-align: center;"><input type="checkbox" name="chec[]" value="<?php echo $val['chat_time_zakaz_id'] ?>"></td>
                <td><?php echo $val['chat_time_zakaz_id'] ?></td>
                <td><?php echo $val['chat_time_zakaz_period'] ?></td>
                <td><?php echo $val['chat_tarif_desc'] ?></td>
                <td><?php echo $val['chat_tarif_cost'] ?></td>
                <td><?php echo $val['chat_tarif_dialog_sum'] ?></td>
            </tr>
        <?php } ?>
    </table>
</form>