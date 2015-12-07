<?php defined('SECURITY') or die('No direct script access.');

echo '<a style="color: red;">'.$data['error'].'</a>';
?>

<form method="POST" >
    <div style="width: 270px; float: left; padding-left: 50px;"> 
        <label style="padding-top: 7px">Фамилия</label> <input class="form-control" type="text" name="first_name" value="<?php echo $data['first_name']; ?>"><div style="font-size: 8pt; color: red;"><?php echo $data["error_first_name"]; ?></div>
        <label style="padding-top: 7px">Имя</label> <input class="form-control" type="text" name="name" value="<?php echo $data['name']; ?>" ><div style="font-size: 8pt; color: red;"><?php echo $data['error_name'];  ?></div>
        <label style="padding-top: 7px">Отчество</label> <input class="form-control" type="text" name="patronumic" value="<?php echo $data['patronumic']; ?>" ><div style="font-size: 8pt; color: red;"><?php echo $data['error_patronumic']; ?></div>
        <label style="padding-top: 7px">Мобильный телефон</label> <input class="form-control" type="text" name="tel" placeholder="+380663332211" value="<?php echo $data['tel']; ?>" ><div style="font-size: 8pt; color: red;"><?php echo $data['error_tel']; ?></div>
    </div>
    <div style="width: 270px; float: left; padding-left: 50px;">
        <label style="padding-top: 7px">E-mail</label> <input class="form-control" type="text" name="email" value="<?php echo $data['email']; ?>"><div style="font-size: 8pt; color: red;"><?php echo $data['error_email']; ?></div>
        <label style="padding-top: 7px">Пароль</label> <input class="form-control" type="password" name="password" ><div style="font-size: 8pt; color: red;"><?php echo $data['error_password'];  ?></div>
        <label style="padding-top: 7px">Повторите пароль</label> <input class="form-control" type="password" name="akcept_password"><div style="font-size: 8pt; color: red;"><?php echo $data['error_akcept_password']; ?></div>
        
        <div style="text-align: right;">
            <label style="padding-top: 7px">Лицензионное соглашение</label> <input type="checkbox" name="lic_ok">
            <input type="submit" class="btn btn-info" value="Регистрация" name="btnsubmit" >
        </div>
    </div> 
</form>

