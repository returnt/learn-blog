<?php defined('SECURITY') or die('No direct script access.');

require_once 'ORM/query_orm.php';

class kabinet_Model extends query_orm {
    
    
    public function user_zakaz_all($user_id) {
        
        $user_unique = $this->query_select_orm('
            SELECT chat_user.id_user, chat_user.user_name, chat_user.user_email, chat_razdel.chat_razdel_name, 
            chat_razdel.chat_razdel_desc, chat_zakaz.*, chat_time_zakaz.*, chat_tarif.*
            FROM chat_zakaz, chat_user, chat_razdel, chat_time_zakaz, chat_tarif 
            WHERE chat_user.id_user=chat_zakaz.chat_zakaz_user 
            AND chat_razdel.chat_razdel_id=chat_zakaz.chat_razdel_site
            AND chat_zakaz.chat_zakaz_tarif=chat_tarif.chat_tarif_id
            AND chat_zakaz.chat_zakaz_time=chat_time_zakaz.chat_time_zakaz_id AND chat_user.id_user='.$user_id);
        
        return $user_unique;
    }

    public function user_zakaz_one($id_zakaz){

        return $this->fpdo->from('chat_zakaz')->where('chat_zakaz_id', $id_zakaz)->fetchAll();
    }

    public function get_user_zakaz_one_tarif($id_tarif){

        return $this->fpdo->from('chat_tarif')->where('chat_tarif_id', $id_tarif)->fetchAll();
    }
    
    public function user_zakaz_add($user_id, $value) {


        return $this->query_insert_orm('
            INSERT INTO chat_zakaz (chat_zakaz.chat_zakaz_user, chat_zakaz.chat_zakaz_site, 
            chat_zakaz.chat_razdel_site, chat_zakaz.chat_zakaz_tarif, chat_zakaz.chat_zakaz_time, 
            chat_zakaz.chat_zakaz_time_reg) 
            VALUES ("'.$this->slashes($user_id).'", "'.$this->slashes($value['url_site']).'", "'.$this->slashes($value['site_rozd']).'", "'.$this->slashes($value['tarif_plan']).'",
                "'.$this->slashes($value['termin_zakaz']).'", "'.date("Y.m.d H:i").'")');

    }
    
    public function user_zakaz_signature_mysignature($site, $mysignature) {
        
        $this->query_updata_orm('
            UPDATE chat_zakaz
            SET chat_zakaz.signature_my="'.$mysignature.'"
            WHERE chat_zakaz.chat_zakaz_site = "'.$site.'"');
        
    }
    
    public function user_zakaz_signature_privat_otvet($signature_privat_data, $signature_privat_signature) {
        
        $this->query_updata_orm('
            UPDATE chat_zakaz
            SET chat_zakaz.signature_privat_signature="'.$signature_privat_signature.'"
            WHERE chat_zakaz.signature_my = "'.$signature_privat_signature.'"');
        
    }
    
    public function get_chat_razdel() {
        
        return $this->query_select_orm('SELECT * FROM chat_razdel');
    }
    
    public function get_chat_tarif() {
        
        return $this->query_select_orm('SELECT * FROM chat_tarif');
    }
    
    public function get_chat_period() {
        
        return $this->query_select_orm('SELECT * FROM chat_time_zakaz');
    }
    
}
