<?php defined('SECURITY') or die('No direct script access.');
session_start();

require_once 'clases/mycontrollerstoreadmin_Controller.php';
require_once 'models/admin_massage_Model.php';
require_once 'models/user_Model.php';
require_once 'models/admin_Model.php';

class admin_Controller extends mycontrollerstoreadmin_Controller {
    
    public function index_Action() {

        $this->theme_view('admin_View', 'index_View', $data=array());
    }
    
    public function user_Action() {

        $user = new user_Model();
        $data['user'] = $user->all_user();

        $this->theme_view('admin_View', 'user_View', $data);
    }

    public function delluser_Action($check) {

        $user = new user_Model();
        $user->dell_user($check);

        header('Location: /admin/user');
    }

    public function activuser_Action() {

        $user = new user_Model();
        $post_valid = $this->clean_injection($_POST);
        if($post_valid['status']=='true'){
            $user->useractiv_user('1', $post_valid['idUser']);
        }else{
            $user->useractiv_user('0', $post_valid['idUser']);
        }

    }

    public function adduser_Action() {


        if(isset($_POST['btnsubmit'])) {

            $data['name'] = $_POST['name'];
            $data['first_name'] = $_POST['first_name'];
            $data['patronumic'] = $_POST['patronumic'];
            $data['tel'] = $_POST['tel'];
            $data['email'] = $_POST['email'];
            if(empty($_POST['password'])){
                $password = '12345678';
                $akcept_password = '12345678';
            }else{
                $password = $_POST['password'];
                $akcept_password = $_POST['akcept_password'];
            }


            $data['error_name'] = $this->solve_sign(1, $data['name'], 2, 20);
            $data['error_first_name'] = $this->solve_sign(1, $data['first_name'], 2, 50);
            $data['error_patronumic'] = $this->solve_sign(1, $data['patronumic'], 0, 25);
            $data['error_tel'] = $this->solve_sign(6, $data['tel'], 13, 13);
            $data['error_email'] = $this->solve_sign(5, $data['email'], 2, 70);
            $data['error_password'] = $this->solve_sign(4, $password, 8, 25);
            $data['error_akcept_password'] = $this->solve_sign(4, $akcept_password, 8, 25);

            if (empty($data['error_name']) && empty($data['error_first_name']) && empty($data['error_patronumic']) && empty($data['error_tel']) && empty($data['error_email']) && empty($data['error_password']) && empty($data['error_akcept_password'])) {
                if ($password !== $akcept_password) {

                    $data['error'] = 'Пароли не совпадают!';
                } else {

                    try {

                        $post_valid = $this->clean_injection($_POST);

                        $user_Model = new user_Model();
                        $user_unique = $user_Model->user_unique($post_valid['tel']);

                        if (empty($user_unique)) {

                            $user_Model->add_new_user($post_valid);
                            $user_next = $user_Model->last_user();
                            $user_Model->add_new_user_rol($user_next);
                            $token = md5(rand());
                            $user_Model->set_user_tocen($user_next[0][0], $token, 'User registration: ' . $user_next[0][0]);

                            $user_Model = new user_Model();
                            $user_Model->user_verefication($token);

                            header('Location: /admin/user');
                        } else {
                            $data['error'] = 'Такой пользователь уже зарегистрирован!';
                        }
                    } catch (Exception $exc) {
                        $data['error'] = 'Ошыбка при регистрации пользователя';
                    }
                }
            }
        }

        $this->theme_view('admin_View', 'add_user_View', $data);
    }

    public function chatactiv_Action(){

    }
    
    public function chat_Action() {
        
        $admin_massage_model = new admin_massage_Model();
        $data['array_chat'] = $admin_massage_model->get_chat();
        $data['operator'] = $admin_massage_model->get_operator();
        
        if(isset($_POST['chat_filtr'])){
            
            $data['array_chat'] = $admin_massage_model->get_chat_where($this->clean_injection($_POST));
        }
        
        $this->theme_view('admin_View', 'massage_View', $data);
    }
    
    public function massage_Action($token) {
        
        $admin_massage_model = new admin_massage_Model();
        
        exit(json_encode($admin_massage_model->get_massage($this->clean_injection(array($token)))));
    }

    public function chathistory_Action($token) {

        $admin_massage_model = new admin_massage_Model();


    }

    public function tarifi_Action(){

        $adm_mod = new admin_Model();
        $data['tarif'] = $adm_mod->all_tarif();

        if(isset($_POST['add'])){
            $res = $adm_mod->add_tarif($this->clean_injection($_POST));
            if($res){
                header('Location: /admin/tarifi');
            }
        }

        if(isset($_POST['dell'])){
            foreach($_POST['chec'] as $val){
               $adm_mod->dell_tarif($val);
            }
            header('Location: /admin/tarifi');
        }

        $this->theme_view('admin_View', 'tarifi_View', $data);
    }

    public function period_Action(){

        $adm_mod = new admin_Model();
        $data['tarif'] = $adm_mod->all_tarif();

        if(isset($_POST['add'])){
            $res = $adm_mod->add_tarif($this->clean_injection($_POST));
            if($res){
                header('Location: /admin/tarifi');
            }
        }

        if(isset($_POST['dell'])){
            foreach($_POST['chec'] as $val){
                $adm_mod->dell_tarif($val);
            }
            header('Location: /admin/tarifi');
        }

        $this->theme_view('admin_View', 'razdel_View', $data);
    }

    public function rozdel_Action(){

        $adm_mod = new admin_Model();
        $data['tarif'] = $adm_mod->all_tarif();

        if(isset($_POST['add'])){
            $res = $adm_mod->add_tarif($this->clean_injection($_POST));
            if($res){
                header('Location: /admin/tarifi');
            }
        }

        if(isset($_POST['dell'])){
            foreach($_POST['chec'] as $val){
                $adm_mod->dell_tarif($val);
            }
            header('Location: /admin/tarifi');
        }

        $this->theme_view('admin_View', 'time_View', $data);
    }
    
    
}
