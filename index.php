<?php
function __autoload($class) {
    $filename="clase/".$class.".php";
    if (is_readable($filename)) {
        require_once $filename;
    } else {
        $filename="clase/elements/".$class.".php";
        if (is_readable($filename)) {
            require_once $filename;
        }
    }
}
$form=new form();
$form->method='post';
$form->addTag(NULL);

$nume=$form->addElement('nume', 'text');
$nume->addLabel('Numele dvs.');
$nume->id='nume';
$nume->placeholder='Introduceti numele dvs';
$nume->addMasterTag(NULL);
$nume->addTag('span',array('id'=>'colElements'));
$nume->addLabelTag('span');

$parola=$form->addElement('parola','password');
$parola->addLabel('Password');

$sex=$form->addElement('sex','radio');
$sex->addOptions(array('masculin'=>'Masculin','feminin'=>'Feminin'));
$sex->addLabel('Sex');
$sex->isChecked('feminin');

$computer=$form->addElement('computer','checkbox');
$computer->addOptions(array('desktop'=>'You have a desktop?','laptop'=>'You have a laptop','nothing'=>'You dont have a computer'));
$computer->addLabel('Computer');
$computer->isChecked('laptop');
$computer->isChecked('desktop');

$car=$form->addElement('car','select');
$car->addOptions(array('mercedes'=>'Mercedes','volvo'=>'Volvo'));
$car->addLabel('Car');
$car->isChecked('volvo');

$comment=$form->addElement('comment','textarea');
$comment->addLabel('Your comment');

$submit=$form->addElement('submit','submit');
$submit->value='submit';

echo $form->showElements($nume,$parola,$sex,$computer,$car,$comment,$submit);
?>
