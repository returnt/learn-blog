<?php defined('SECURITY') or die('No direct script access.');
session_start();

require_once 'clases/root_Controller.php';

class main_Controller extends root_Controller {

    public function index_Action() {
        
        $this->theme_view('main_View', 'home_View', $data = array());
    }

    public function reg_Action() {
        
        $data = array();
        
        if($_SESSION['chatuserboobscooki']!=NULL){
            
            $this->theme_view('main_View', 'hello_View', $data);        
        }elseif (isset($_POST['btnsubmit'])) {
            
            $data['name'] = $_POST['name'];
            $data['first_name'] = $_POST['first_name'];
            $data['patronumic'] = $_POST['patronumic'];
            $data['tel'] = $_POST['tel'];
            $data['email'] = $_POST['email'];
            $password = $_POST['password'];
            $akcept_password = $_POST['akcept_password'];

            $data['error_name'] = $this->solve_sign(1, $data['name'], 2, 20);
            $data['error_first_name'] = $this->solve_sign(1, $data['first_name'], 2, 50);
            $data['error_patronumic'] = $this->solve_sign(1, $data['patronumic'], 0, 25);
			//валидация поля error_tel
            $data['error_email'] = $this->solve_sign(5, $data['email'], 2, 70);
            $data['error_password'] = $this->solve_sign(4, $password, 8, 25);
            $data['error_akcept_password'] = $this->solve_sign(4, $akcept_password, 8, 25);

            if (empty($data['error_name']) && empty($data['error_first_name']) && empty($data['error_patronumic']) && empty($data['error_tel']) && empty($data['error_email']) && empty($data['error_password']) && empty($data['error_akcept_password'])) {
                if($password!==$akcept_password){

                    $data['error'] = 'Пароли не совпадают!';
                }  elseif ($_POST['lic_ok']== NULL) {

                    $data['error'] = 'Примите лицензионное соглашение!';
                }  else {

                    try {
						
                        $post_valid = //очистка входящих данных от пользователя

                        $user_Model = new user_Model();
                        $user_unique = $user_Model->user_unique($post_valid['tel']);

                        if(empty($user_unique)){
                            
                            $user_Model->add_new_user($post_valid);
                            $user_next = $user_Model->last_user();
                            $user_Model->add_new_user_rol($user_next);
                            $token = //получить случайное число и от него хеш
                            $user_Model->set_user_tocen($user_next[0][0], $token, 'User registration: '.$user_next[0][0]);
                            
                            $this->get_mail(0, 'Регистрация на сайте kydosupport.com', 'Для подтверждения регистриции перейдите по ссыдке: http://kydosupport.com/main/regverification/'.$token, $post_valid['email']);
                            $this->theme_view('main_View', 'regmail_View', $data);        
                        }  else {
                            $data['error'] = 'Такой пользователь уже зарегистрирован!';
                        }
                    } catch (Exception $exc) {
                         $data['error'] = 'Ошыбка при регистрации пользователя';
                    }          
                }
            }
        }
        
        $this->theme_view('main_View', 'reg_View', $data);        
    }

    /*public function regform_Action($check) {

        $data = array();
        $data['get'] = $check;

        if($_SESSION['chatuserboobscooki']!=NULL){

            $this->theme_view('main_View', 'hello_View', $data);
        }elseif (isset($_POST['btnsubmit'])) {

            $data['name'] = $_POST['name'];
            $data['first_name'] = $_POST['first_name'];
            $data['patronumic'] = $_POST['patronumic'];
            $data['tel'] = $_POST['tel'];
            $data['email'] = $_POST['email'];
            $password = $_POST['password'];
            $akcept_password = $_POST['akcept_password'];

            $data['error_name'] = $this->solve_sign(1, $data['name'], 2, 20);
            $data['error_first_name'] = $this->solve_sign(1, $data['first_name'], 2, 50);
            $data['error_patronumic'] = $this->solve_sign(1, $data['patronumic'], 0, 25);
            $data['error_tel'] = $this->solve_sign(6, $data['tel'], 13, 13);
            $data['error_email'] = $this->solve_sign(5, $data['email'], 2, 70);
            $data['error_password'] = $this->solve_sign(4, $password, 8, 25);
            $data['error_akcept_password'] = $this->solve_sign(4, $akcept_password, 8, 25);

            if (empty($data['error_name']) && empty($data['error_first_name']) && empty($data['error_patronumic']) && empty($data['error_tel']) && empty($data['error_email']) && empty($data['error_password']) && empty($data['error_akcept_password'])) {
                if($password!==$akcept_password){

                    $data['error'] = 'Пароли не совпадают!';
                }  elseif ($_POST['lic_ok']== NULL) {

                    $data['error'] = 'Примите лицензионное соглашение!';
                }  else {

                    try {

                        $post_valid = $this->clean_injection($_POST);

                        $user_Model = new user_Model();
                        $user_unique = $user_Model->user_unique($post_valid['tel']);

                        if(empty($user_unique)){

                            $user_Model->add_new_user($post_valid);
                            $user_next = $user_Model->last_user();
                            $user_Model->add_new_user_rol($user_next);
                            $token = md5(rand());
                            $user_Model->set_user_tocen($user_next[0][0], $token, 'User registration: '.$user_next[0][0]);

                            $this->get_mail(0, 'Регистрация на сайте kydosupport.com', 'Для подтверждения регистриции перейдите по ссыдке: http://kydosupport.com/main/regverification/'.$token, $post_valid['email']);

                            $error_login = $this->solve_sign(5, $post_valid['email'], 2, 70);
                            $error_password = $this->solve_sign(4, $post_valid['password'], 8, 25);

                            if(empty($error_login) && empty($error_password)){

                                try {
                                    $user_Model = new user_Model();

                                    $user = $user_Model->where_user_auth($post_valid['email']);

                                    if($user!="" && md5($post_valid['password'])==$user[0]['password']){

                                        $token_user_data_auth = $user_Model->set_user_auth_date($user[0][0]);

                                        $_SESSION['chatuserboobscooki'] = array($user[0][0], $user[0][1], $user[0][5], $user[0][8], $user[0][9], $token_user_data_auth);
                                        header('Location: /kabinet/addnewproject/'.$check);
                                    }  else {
                                        $data['error'] = 'Такого пользователя не существует или логин пароль не совпадают!';
                                    }
                                } catch (Exception $exc) {
                                    $data['error'] = 'Такого пользователя не существует или логин пароль не совпадают';
                                }
                            }  else {
                                $data['error'] = 'Проверьте правильность вводимых данных!';
                            }

                        }  else {
                            $data['error'] = 'Такой пользователь уже зарегистрирован!';
                        }
                    } catch (Exception $exc) {
                        $data['error'] = 'Ошыбка при регистрации пользователя';
                    }
                }
            }
        }

        $this->theme_view('main_View', 'reg_form_View', $data);
    }
    
    public function regverification_Action($check) {
        
        $user_Model = new user_Model();
        $res = $user_Model->user_verefication($check);
        
        if($res == 0){
            header('Location: /');
        }  else {
            header('Location: /');
        }
    }
    
    public function auth_Action() {

        $data = array();
        
        if($_SESSION['chatuserboobscooki']!=NULL){
            
            $this->theme_view('main_View', 'hello_View', $data);
        }  elseif(isset($_POST['btnsubmit'])){

                $error_login = $this->solve_sign(5, $_POST['login'], 2, 70);
                $error_password = $this->solve_sign(4, $_POST['password'], 8, 25);

                if(empty($error_login) && empty($error_password)){
                    
                    try {
                            $user_Model = new user_Model();

                            $post_valid = $this->clean_injection($_POST);
                            $user = $user_Model->where_user_auth($post_valid['login']);

                            if($user[0]['chat_user_activ'] != 1){
                                
                                $data['error'] = 'Пользователь не активен. Перейдите на почту и подтвердите активацию.';
                            }elseif($user!="" && md5($post_valid['password'])==$user[0]['password']){
                                
                                $token_user_data_auth = $user_Model->set_user_auth_date($user[0][0]);
                                
                                $_SESSION['chatuserboobscooki'] = array($user[0][0], $user[0][1], $user[0][5], $user[0][8], $user[0][9], $token_user_data_auth); 
                                $this->theme_view('main_View', 'hello_View', $data);        
                            }  else {
                                $data['error'] = 'Такого пользователя не существует или логин пароль не совпадают!';
                            }
                        } catch (Exception $exc) {
                            $data['error'] = 'Такого пользователя не существует или логин пароль не совпадают';
                        }
                }  else {
                    $data['error'] = 'Проверьте правильность вводимых данных!';
                }        
            }
        
        $this->theme_view('main_View', 'auth_View', $data);        
    }
    
    public function logout_Action() {
        
        $user_Model = new user_Model();
        $user_Model->set_user_logout_date($_SESSION['chatuserboobscooki'][5]);
        
        unset($_SESSION['chatuserboobscooki']);
        header('Location: /');
        
    }
    
    public function projectsignature_Action() {
        
        $user_zakaz = new kabinet_Model();
        
        $signature_privat_data = $_POST['data'];
        $signature_privat_signature = $_POST['signature'];
        
        /*$public_key = 'i66305871306';
        $private_key = '5p24goqOarOLLHQ2W3Juk3e1GYfKfww6ikqyPCYd';
        $sign = base64_encode( sha1( 
        $private_key .  
        $signature_privat_data . 
        $private_key 
       , 1 ));*/
        
        /*$user_zakaz->user_zakaz_signature_privat_otvet($signature_privat_data, $signature_privat_signature);
    }*/
}
