<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
$destPage = 'http://'.$_SERVER['HTTP_HOST'].'/site/';
switch ($this->title){
    case 'Not Found (#403)':$destPage .= 'error403';break;
    case 'Not Found (#404)':$destPage .= 'error404';break;
    case 'Not Found (#405)':$destPage .= 'error500';break;

}
header("Location: $destPage");
exit;
?>

