<?php
/**************************************************************
* Projectname:   php form generate class 
* Version:       1.0
* Author:        Tzuly <tzulac@gmail.com>
* Last modified: 15-oct-2012
***************************************************************
* 
*******************************
* Description: radio class    *
******************************* 
* Child of element class
*  return string html element
 */
class radio extends element {
    /**
     * array with value of every radio element, where key is value of radio
     * 
     * @var array 
     */
    protected $_options=array();
    /**
     * name of checked option
     * 
     * @var string 
     */
    protected $_checked=NULL;
    /**
     * 
     * @param string $name
     */
    public function __construct($name) {
        parent::__construct($name);
    }
    /**
     * Add radio elements
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
        $this->_checked=$val;
    }
    /**
     * 
     * @return string
     */
    public function getElement() {
        $full='';
        foreach ($this->_options as $val=>$label) {
            $full.="<input type='radio' name='".$this->_name."' value='".$val."' ";
            if ($this->_checked==$val) {
                $full.=" checked='checked'";
            }
            $full.="/>".ucfirst($label)."<br/>";
        }
        return $full;
    }
}