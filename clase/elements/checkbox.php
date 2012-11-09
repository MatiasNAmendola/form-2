<?php
/**************************************************************
* Projectname:   php form generate class 
* Version:       1.0
* Author:        Tzuly <tzulac@gmail.com>
* Last modified: 15-oct-2012
***************************************************************
* 
*******************************
* Description: checkbox class *
******************************* 
* Child of element class
*  return string html element
* Add values to options and checked.
*/
class checkbox extends element{
    /**
     * array with value of every checkbox element, where key is value of option
     * 
     * @var array 
     */
    protected $_options=array();
    /**
     * array with name of checked option
     * 
     * @var array 
     */
    protected $_checked=array();
    /**
     * 
     * @param string $name
     */
    public function __construct($name) {
        parent::__construct($name);
    }
    /**
     * Add checkbox elements
     * 
     * @param array $option
     */
    public function addOptions($option) {
        foreach ($option as $key=>$value) {
            $value=preg_replace('#[^\w\s]#','',$value);
            $key=preg_replace('#[^\w]#','',$key);
            $this->_options[$key]=$value;
        }
    }
    /**
     * Set checked option
     * 
     * @param string $val
     */
    public function isChecked($val) {
        $this->_checked[]=$val;
    }
    /**
     * 
     * @return string
     */
    public function getElement() {
        $full='';
        foreach ($this->_options as $val=>$label) {
            $full.="<input type='checkbox' name='".$this->_name."' value='".$val."' ";
            if (in_array($val, $this->_checked)) {
                $full.=" checked='checked'";
            }
            $full.="/>".ucfirst($label)."<br/>";
        }
        return $full;
    }
}