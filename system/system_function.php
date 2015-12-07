<?php defined('SECURITY') or die('No direct script access.');

class system_function {
    
    /**
     * 
     * @param type $master_page
     * @param type $page
     * @param type $data
     * 
     * Загрузка темы
     */
    public function theme_view($master_page, $page, $data) {
        
        require_once 'view/viewMaster/'.$master_page.'.php';
    }
    
    /**
     * 
     * @param type $value_temp
     * @return type
     * 
     * Очистка данных от спец символов и html/php иньекцый
     */
    public function clean_injection($value_temp) {
        
        foreach ($value_temp as $key => $value) {
            
            $value = trim($value);
            $value = stripslashes($value);
            $value = strip_tags($value);
            $value = htmlspecialchars($value);
            $value = addslashes($value);

            $value_res[$key] = $value;
        }
        
        return $value_res;
    }
    
    /**
     * 
     * @param string/int $sign regular expression or constant expression
     * @param string $value
     * 
     * Проверка данных на корректность заданному условию
     */

    public function solve_sign($sign='', $value, $min='', $max='') {
        
        switch ($sign) {
            case 1:
                
                $sign = '/^[а-яёіА-ЯЁІ]*$/u';  // span sign абвгдз... (ru/uk) 
                break;
            
            case 2:
                
                $sign = '/^[а-яёіА-ЯЁІ0-9]*$/';  // span sign абвгдз... (ru/uk) and 0-9
                break;
            
            case 3:
                
                $sign = '/^[aA-zZ]*$/';  // span sign абвгдз... (en)
                break;
            
            case 4:
                
                $sign = '/^[aA-zZ0-9]*$/';  // span sign абвгдз... (en) end 0-9
                break;
            
            case 5:
                
                $sign = '/^[\.\-_A-Za-z0-9]+?@[\.\-A-Za-z0-9]+?\.[A-Za-z0-9]{2,6}$/';  // span sign email
                break;
            
            case 6:
                
                $sign = '/^\+[0-9]*$/';  // span sign telephone
                break;

            default:
                
                if(empty($sign)){
                    $sign = '[]';   // span sign all
                }
                break;
        }
        
        if (preg_match($sign, $value)) {
            
            if(empty($min) && empty($max)){
                return '';
            }  elseif(strlen(trim(iconv("UTF-8", "windows-1251",$value))) >= $min && strlen(trim(iconv("UTF-8", "windows-1251",$value))) <= $max) {
                return '';
            }  else {
                return "Количество символов должно быть не менее $min и не более $max!";
            }
        } else {
            
            return "Введены некоректные данные!";
        }
    }
    
    /**
     * 
     * @param type $to
     * @param type $title
     * @param type $mess
     * @param type $email
     * 
     * отправка почты от произвольного отправителя и от задданых по шаблону
     */
    public function get_mail($to, $title, $mess, $email) {
        
        $default_mail = array('technical@kydosupport.com','kryarek@mail.ru');
        
        if(array_key_exists($to, $default_mail)){
            
            mail($email, $title, $mess, 'From:'.$default_mail[$to]);
        }  else {
            mail($email, $title, $mess, 'From:'.$to);
        }
    }

    /**
     * Возвращает сумму прописью
     * @author runcore
     * @uses morph(...)
     */
    public function num2str($num) {
        $nul='ноль';
        $ten=array(
            array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
            array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
        );
        $a20=array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
        $tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
        $hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
        $unit=array( // Units
            array('копейка' ,'копейки' ,'копеек',	 1),
            array('гривна'   ,'гривны'   ,'гривен'    ,0),
            array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
            array('миллион' ,'миллиона','миллионов' ,0),
            array('миллиард','милиарда','миллиардов',0),
        );
        //
        list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
        $out = array();
        if (intval($rub)>0) {
            foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
                if (!intval($v)) continue;
                $uk = sizeof($unit)-$uk-1; // unit key
                $gender = $unit[$uk][3];
                list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
                // mega-logic
                $out[] = $hundred[$i1]; # 1xx-9xx
                if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
                else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
                // units without rub & kop
                if ($uk>1) $out[]= self::morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
            } //foreach
        }
        else $out[] = $nul;
        $out[] = self::morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
        $out[] = $kop.' '.self::morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
        return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));

        /**
         * Склоняем словоформу
         * @ author runcore
         */

    }

    public function morph($n, $f1, $f2, $f5) {
        $n = abs(intval($n)) % 100;
        if ($n>10 && $n<20) return $f5;
        $n = $n % 10;
        if ($n>1 && $n<5) return $f2;
        if ($n==1) return $f1;
        return $f5;
    }

}


