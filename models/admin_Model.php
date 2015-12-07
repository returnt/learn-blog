<?php defined('SECURITY') or die('No direct script access.');

require_once 'ORM/query_orm.php';

class admin_Model extends query_orm {
    
    public function get_user() {
        
        $user_unique = $this->query_select_orm('
                        SELECT chat_user.*, GROUP_CONCAT(chat_rol.rol_desc SEPARATOR ", ") as user_rol_desk
                        FROM chat_user, chat_user_rol, chat_rol 
                        WHERE chat_user.id_user=chat_user_rol.user_id 
                        AND chat_user_rol.user_rol_id=chat_rol.rol_id
                        GROUP BY chat_user.id_user;
                        ');
        
        return $user_unique;
    }
    
    public function add_new_user($data) {
        
        $this->query_insert_orm('INSERT INTO chat_user (chat_user.user_name, chat_user.chat_user_first_name, chat_user.chat_user_patronumic,
                                chat_user.chat_user_tel, chat_user.user_email, chat_user.password, chat_user.chat_user_data_reg) 
                                VALUES ("'.$this->slashes($data['name']).'","'.$this->slashes($data['first_name']).'",
                                "'.$this->slashes($data['patronumic']).'","'.$this->slashes($data['tel']).'",
                                "'.$this->slashes($data['email']).'","'.$this->slashes(md5($data['password'])).'",
                                "'.date("Y.m.d H:i").'")');
        
    }
    
    public function last_user() {
        
        $user_next = $this->query_select_orm('SELECT MAX(chat_user.id_user) FROM chat_user');
        
        return $user_next;
    }
    
    public function add_new_user_rol($user_next) {
        
        $this->query_insert_orm('INSERT INTO chat_user_rol (chat_user_rol.user_rol_id, chat_user_rol.user_id) VALUES ("2","'.$user_next[0][0].'")');
        
    }
    
    public function where_user_auth($login) {
        
        $where_user_auth = $this->query_select_orm('SELECT chat_user.*, GROUP_CONCAT(user_rol_id) AS user_rol FROM chat_user, chat_user_rol WHERE chat_user_rol.user_id=chat_user.id_user AND chat_user.user_email="'.$this->slashes($login).'" GROUP BY chat_user.id_user');
        
        return $where_user_auth;
    }
    
    public function set_user_tocen($id_user, $user_token, $desc) {
        
        $this->fpdo->insertInto('chat_token_user')
                    ->values(array(
                    'chat_token_user_user_id' => $id_user, 
                    'chat_token_user_token' => $user_token,
                    'chat_token_user_date_create' => date("Y.m.d H:i"), 
                    'chat_token_user_lifetime' => date("Y.m.d H:i", strtotime ('+1 days')),
                    'chat_token_user_desc' => $desc))
                    ->execute();
    }
    
    public function user_verefication($param) {
        
        $res = $this->query_select_orm('SELECT * FROM chat_token_user WHERE chat_token_user.chat_token_user_token = "'.$this->slashes($param).'"');
        
        if(empty($res)){
            return 0;
        }  elseif(strtotime($res[0]['chat_token_user_lifetime']) >= strtotime(date("Y.m.d H:i"))) {
            $this->query_updata_orm('UPDATE chat_user SET chat_user.chat_user_activ="1" WHERE chat_user.id_user="'.$res[0]['chat_token_user_user_id'].'"');
            return 1;
        }  else {
            return 0;
        }
        
    }
    
    public function set_user_auth_date($param) {
        
        return $this->query_insert_orm('INSERT INTO chat_user_session (
                                chat_user_session.chat_user_session_id_user, chat_user_session.chat_user_session_auth)
                                VALUES ("'.$param.'", "'.date("Y.m.d H:i:s").'")');

    }
    
    public function set_user_logout_date($param) {
        
        $this->query_updata_orm('UPDATE chat_user_session
                                SET chat_user_session.chat_user_session_logout="'.date("Y.m.d H:i:s").'"
                                WHERE chat_user_session.chat_user_session_id="'.$param.'"');
    }

    public function all_tarif() {

        return $this->query_select_orm('SELECT * FROM chat_tarif');

    }

    public function add_tarif($data) {

        return $this->query_insert_orm('INSERT INTO chat_tarif (chat_tarif.chat_tarif_name,
                                        chat_tarif.chat_tarif_desc, chat_tarif.chat_tarif_cost,
                                        chat_tarif.chat_tarif_dialog_sum)
                                        VALUES ("'.$this->slashes($data['chat_tarif_name']).'",
                                        "'.$this->slashes($data['chat_tarif_desc']).'",
                                        "'.$this->slashes($data['chat_tarif_cost']).'",
                                        "'.$this->slashes($data['chat_tarif_dialog_sum']).'")');

    }

    public function dell_tarif($tarif_id){

        $this->query_delete_orm('DELETE FROM chat_tarif WHERE chat_tarif.chat_tarif_id="'.$tarif_id.'"');
    }

    public function all_period() {

        return $this->query_select_orm('SELECT * FROM chat_time_zakaz');

    }

    public function add_period($data) {

        return $this->query_insert_orm('INSERT INTO chat_tarif (chat_tarif.chat_tarif_name,
                                        chat_tarif.chat_tarif_desc, chat_tarif.chat_tarif_cost,
                                        chat_tarif.chat_tarif_dialog_sum)
                                        VALUES ("'.$this->slashes($data['chat_tarif_name']).'",
                                        "'.$this->slashes($data['chat_tarif_desc']).'",
                                        "'.$this->slashes($data['chat_tarif_cost']).'",
                                        "'.$this->slashes($data['chat_tarif_dialog_sum']).'")');

    }

    public function dell_period($tarif_id){

        $this->query_delete_orm('DELETE FROM chat_tarif WHERE chat_tarif.chat_tarif_id="'.$tarif_id.'"');
    }
}
