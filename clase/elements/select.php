<?php
/**************************************************************
* Projectname:   php form generate class 
* Version:       1.0
* Author:        Tzuly <tzulac@gmail.com>
* Last modified: 15-oct-2012
***************************************************************
* 
*******************************
* Description: select class   *
******************************* 
* Child of element class
*  return string html element
 */
class select extends element{
    /**
     * array with value of every options element, where key is name of option
     * 
     * @var array 
     */
    protected $_list=array();
    /**
     * array with name of checked option
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
     * Add option elements
     * 
     * @param array $option
     */
    public function addOptions($option) {
        foreach ($option as $key=>$value) {
            $value=preg_replace('#[^\w\s]#','',$value);
            $key=preg_replace('#[^\w]#','',$key);
            $this->_list[$key]=$value;
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
        $full="<select name='".$this->_name."'";
        foreach ($this->_attr as $key=>$value) {
            $full.=" $key='".$value."'";
        }
        $full.=">";
        foreach ($this->_list as $val=>$label) {
            $full.="<option value='".$val."'";
            if ($this->_checked==$val) {
                $full.=" selected='selected'";
            }
            $full.=" />".ucfirst($label)."<br/>";
        }
        return $full;
    }
    
}