<?php

/**************************************************************
* Projectname:   php form generate class 
* Version:       1.0
* Author:        Tzuly <tzulac@gmail.com>
* Last modified: 15-oct-2012
***************************************************************
* 
* GNU General Public License (Version 2, June 1991)
*
* This program is free software; you can redistribute
* it and/or modify it under the terms of the GNU
* General Public License as published by the Free
* Software Foundation; either version 2 of the License,
* or (at your option) any later version.
*
* This program is distributed in the hope that it will
* be useful, but WITHOUT ANY WARRANTY; without even the
* implied warranty of MERCHANTABILITY or FITNESS FOR A
* PARTICULAR PURPOSE. See the GNU General Public License
* for more details.
* 
****************************
* Description: form class  *
**************************** 
* This class allow to define form attributes, to add new elements to form and
* to render to form.
* As default has table tag and is rendered as table, but this can be changed 
* by adding new tag on form (form->addTag('tag') and to elements!
* Can add attributes to form, to elements, to tag.
* Can set option selected for Select, Radio and Checkbox
*
 ************
 * Use:     *
 ************
 * instantiate a new form;
 * set the attributes (default is none setted);
 * change the form tag (default is table);
 * declare new elements (addElement);
 * declare attributes for every elements: id, class, placeholder, etc;
 * add label for element (optional);
 * change tag for label and element (default is td 
 * - change if you change table on form); 
 * change tag for group of element (default is tr);
 * add elements to form and render (showElements);
 *
 **************
 * Example
 **************
 * <?php
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
$form->addTag('table');

$nume=$form->addElement('nume', 'text');
$nume->addLabel('Numele dvs.');
$nume->id='nume';
$nume->placeholder='Introduceti numele dvs';
$nume->addMasterTag('tr');
$nume->addTag('td',array('id'=>'colElements'));
$nume->addLabelTag('td');

$parola=$form->addElement('parola','password');
$parola->addLabel('Password');

$sex=$form->addElement('sex','radio');
$sex->addOptions(array('masculin'=>'Masculin','feminin'=>'Feminin'));
$sex->addLabel('Sex');
$sex->isChecked('feminin');

$computer=$form->addElement('computer','checkbox');
$computer->addOptions(array(
   'desktop'=>'You have a desktop?',
   'laptop'=>'You have a laptop',
   'nothing'=>'You dont have a computer'));
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
*/
class form {
    /**
     * form tag
     * 
     * @var object tag
     */
    protected $_tag=NULL;
    /**
     * array with name of declared elements
     * 
     * @var array 
     */
    protected $_nameOfElements=array();
    /**
     * array with atributes: name as key
     * 
     * @var array 
     */
    protected $_attr=array();
    /**
     * Constructor who initialize form tag
     */
    public function __construct() {
        //create tag object with name 'table'
        $this->_tag=new tag('table');
    }
    /**
     * Function who create a new instance of element
     * 
     * @param string $name
     * @param string $tip
     * @return object element
     * @throws Exception
     */
    public function addElement($name,$tip) {
        //check if element name is already in use
        $name=preg_replace('#[^\w]#','',$name);
        if (in_array($name,$this->_nameOfElements)) {
            throw new Exception ($name.' is already used. Pick other');
        }
        $this->_nameOfElements[]=$name;
        //return element object if all is correct
        try {
            return element_factory::getInstance($name,$tip);
        }
        catch (exception $e) {
            echo $e->getMessage();
        }
    }
    /**
     * Magic method for attributes setting
     * 
     * @param string $name
     * @param string $value
     * @throws Exception
     */
    public function __set($name,$value) {
        $name=preg_replace('#[^\w]#','',$name);
        $value=preg_replace('#[^\w\s]#','',$value);
        if (strlen($name)<1 || strlen($value)<1) {
            throw new Exception('Attributes must have name and value');
        }
        $this->_attr[$name]=$value;
    }
    /**
     * Magic method for getting attributtes
     * 
     * @param string $name
     * @return string
     * @throws Exception
     */
    public function __get($name) {
        if (!array_key_exists($name, $this->_attr)) {
            throw new Exception ($name.' attribut is not set');
        }
        return $this->_attr[$name];
    }
    /**
     * Method for declaring a new tag for form and attributes for tag
     * 
     * @param string $tag
     * @param array $attr
     */
    public function addTag ($tag, array $attr=NULL) {
        $tag=preg_replace('#[^\w]#','',$tag);
        //create a new tag object
        $this->_tag=new tag($tag,$attr);
    }
    /**
     * Method to render the form. Must put name if elements as 
     * method arguments.
     * 
     * @return string
     * @throws Exception
     */
    public function showElements () {
        $list=  func_get_args();
        $form='';
        //access tag object and return start tag
        $form.=$this->_tag===NULL?"":$this->_tag->getStartTag();
        //show html tag for form and attributes, if exists
        $form.="<form ";
        foreach ($this->_attr as $key=>$value) {
            $form.=$key."='".$value."' ";
        }
        $form.=">";
        //show form elements, with tags, labels, attributes
        foreach ($list as $elem) {
            if (!($elem instanceof element)) {
                throw new Exception ($elem.' is not a valid element');
            }
            $form.=$elem->getMasterTag()===NULL?"":$elem->getMasterTag()->getStartTag();
            $form.=$elem->getLabel();
            $form.=$elem->getTag()===NULL?"":$elem->getTag()->getStartTag();
            $form.=$elem->getElement();
            $form.=$elem->getTag()===NULL?"":$elem->getTag()->getEndTag();
            $form.=$elem->getMasterTag()===NULL?"":$elem->getMasterTag()->getEndTag();
            
        }
        $form.="</form>";
        $form.=$this->_tag===NULL?"":$this->_tag->getEndTag();
        return $form;
    }
}