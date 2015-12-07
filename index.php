<?php
define("SECURITY", TRUE);
date_default_timezone_set('Europe/Kiev');

if($_GET['search']){
    $class = trim(strip_tags($_GET['search']));
    $file_class = "clases/controllers/".$class."_Controller.php";
}  else {
    $class = 'main';
    $file_class = "clases/controllers/".$class."_Controller.php";
}

if($_GET['action']){
    $action = trim(strip_tags($_GET['action']));
    $action_name = $action.'_Action';
}  else {
    $action_name = 'index_Action';
}

if($_GET['check']){
    $check = trim(strip_tags($_GET['check']));
}  else {
    $check = NULL;
}

if(file_exists($file_class)){
    
    require_once $file_class;
    
    $class_name = $class.'_Controller';
    
    if(class_exists($class_name)){
        
        $obj_class = new $class_name;
        
        if(method_exists($obj_class, $action_name))
        {
            $obj_class->$action_name($check);
        }  else {
            exit('Не коректный адрес URI!');
        }
        
    }  else {
        exit('Не коректный адрес!');
    }
    
}  else {
    exit('Не коректный адрес URL!');
}