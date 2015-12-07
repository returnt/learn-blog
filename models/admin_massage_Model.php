<?php defined('SECURITY') or die('No direct script access.');

require_once 'ORM/query_orm.php';

class admin_massage_Model extends query_orm {
    
    public function get_chat() {
        
        return $this->query_select_orm('SELECT chat_chat.*, chat_user.chat_user_first_name, chat_zakaz.chat_zakaz_site
                                        FROM chat_chat, chat_user, chat_zakaz
                                        WHERE chat_chat.chat_operator=chat_user.id_user
                                        AND chat_chat.chat_siteBef=chat_zakaz.chat_zakaz_id');
    }
    
    public function get_chat_where($param) {
        
        $query = 'SELECT chat_chat.*, chat_user.chat_user_first_name, chat_zakaz.chat_zakaz_site
                FROM chat_chat, chat_user, chat_zakaz
                WHERE chat_chat.chat_operator=chat_user.id_user 
                AND chat_chat.chat_siteBef=chat_zakaz.chat_zakaz_id ';
        $where = '';
        
        if(!empty($param['token'])){
            $query = $query.'AND chat_chat.chat_token ="'.$this->slashes($param['token']).'"';
        }
        if (!empty($param['data_s']) && empty($param['data_do'])) {
            $query = $query.' AND chat_chat.chat_create_time BETWEEN "'.$this->slashes($param['data_s']).'" AND "'.date("Y.m.d H:i:s").'"';
        }
        if (empty($param['data_s']) && !empty($param['data_do'])) {
            $query = $query.' AND chat_chat.chat_create_time BETWEEN "1917-02-20 10:00:00" AND "'.$this->slashes($param['data_do']).'"';
        }
        if(!empty($param['data_s']) && !empty($param['data_do'])){
            $query = $query.' AND chat_chat.chat_create_time BETWEEN "'.$this->slashes($param['data_s']).'" AND "'.$this->slashes($param['data_do']).'"';
        }
        if(!empty($param['operator'])){
            $query = $query.' AND chat_chat.chat_operator = "'.$this->slashes($param['operator']).'"';
        }
        if(!empty($param['chat_status'])){
            $query = $query.' AND chat_chat.chat_status = "'.$this->slashes($param['chat_status']).'"';
        }
        
        return $this->query_select_orm($query);
    }
    
    public function get_massage($param) {
     
        return $this->query_select_orm('SELECT chat_massage.*, chat_user.user_name
                                        FROM chat_massage, chat_user WHERE chat_user.id_user=chat_massage.chat_user_id 
                                        AND chat_massage.chat_token = "'.$this->slashes($param[0]).'" ORDER BY chat_massage.chat_date_massage');
    }
    
    public function get_operator() {
        
        return $this->query_select_orm('SELECT * FROM chat_user, chat_user_rol
                                        WHERE chat_user.id_user=chat_user_rol.user_id 
                                        AND chat_user_rol.user_rol_id=3 ');
    }

    public function get_chat_history(){


    }
}
