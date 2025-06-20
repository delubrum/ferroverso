<?php 

if(!isset($_SESSION)) { 
    session_start(); 
}
if (empty($_SESSION["id-APP"])) {
    header('Location: ?c=Home&a=Index&m=Index');
}
else {
$filter = "and id = " . $_SESSION["id-APP"];
$user = $this->model->get('*','users',$filter);
$load_lang = $user->lang;
$lang_json = file_get_contents("app/assets/lang/".$load_lang.".json");
$lang = json_decode($lang_json, true);
}

?>