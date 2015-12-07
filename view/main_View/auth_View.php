<?php defined('SECURITY') or die('No direct script access.');

echo '<div style="color: red;">'.$data['error'].'</div>';
?>

<form role="form" method="POST">
    <div class="form-group">
        <label for="exampleInputEmail1">Логин</label>
        <input type="email" name="login" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Пароль</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
    </div>
    <div style="text-align: right;">
        <button style="width: 80px;" type="submit" name="btnsubmit" class="btn btn-info">Вход</button>
    </div>
</form>