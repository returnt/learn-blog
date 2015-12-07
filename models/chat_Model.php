<?php defined('SECURITY') or die('No direct script access.');

require_once 'ORM/query_orm.php';

class chat_Model extends query_orm {
    
    public function get_massage($param) {
        
        return $this->query_select_orm('SELECT chat_massage.*, chat_user.user_name, chat_user_ava.ava_name
                                        FROM chat_massage, chat_user, chat_user_ava WHERE chat_massage.chat_token ="'.$this->slashes($param).'" 
                                        AND chat_user.id_user=chat_massage.chat_user_id AND chat_user.id_user=chat_user_ava.ava_user ORDER BY chat_massage.chat_date_massage');
    }
    
}
