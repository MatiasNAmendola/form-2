<?php

/**************************************************************
* Projectname:   php form generate class 
* Version:       1.0
* Author:        Tzuly <tzulac@gmail.com>
* Last modified: 15-oct-2012
***************************************************************
* 
*******************************
* Description: element class  *
******************************* 
* This class is parent class for form elements.
* Is used to set tags for label, for element, for group;
*   - to set label if exist;
*   - to set attributes for every element;
*/
class element {
    /**
     * element name
     * 
     * @var string 
     */
    protected $_name;
    /**
     * html tag for element render on form. Is used by child elements
     * 
     * @var string 
     */
    protected $_fullName;
    /**
     * array with attributes name as keys
     * 
     * @var array 
     */
    protected $_attr=array();
    /**
     * element html tag
     * 
     * @var object tag 
     */
    protected $_tag=NULL;
    /**
     * element label
     * 
     * @var string 
     */
    protected $_label;
    /**
     * label html tag
     * 
     * @var object tag 
     */
    protected $_labelTag=NULL;
    /**
     * group element+label html tag
     * 
     * @var object tag 
     */
    protected $_masterTag=NULL;
    /**
     * set name of element
     * initialize html tags
     * 
     * @param string $name
     */
    public function __construct ($name) {
        $this->_name=$name;
        $this->_masterTag=new tag('tr');
        $this->_tag=new tag('td');
        $this->_labelTag=new tag('td');
    }
    /**
     * Magic method for element attributes setting
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
     * Magic method to get element attributes
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
     * add label
     * 
     * @param string $text
     */
    public function addLabel($text) {
        $text=preg_replace('#[^\w\s]#','',$text);
        $this->_label=$text;
    }
    /**
     * add label html tag and attributes for tag
     * generate and object tag
     * 
     * @param string $tag
     * @param array $attr
     */
    public function addLabelTag($tag, array $attr=NULL) {
        $tag=preg_replace('#[^\w]#','',$tag);
        $this->_labelTag=new tag($tag, $attr);
    }
    /**
     * add element html tag and attributes for tag
     * generate and object tag
     * 
     * @param string $tag
     * @param array $attr
     */
    public function addTag($tag, array $attr=NULL) {
        $tag=preg_replace('#[^\w]#','',$tag);
        $this->_tag=new tag($tag, $attr);
    }
    /**
     * return element html tag
     * 
     * @return object tag or null
     */
    public function getTag() {
        if (isset($this->_tag)) {
            return $this->_tag;
        }
        return NULL;
    } 
    /**
     * add group html tag and attributes for tag
     * generate and object tag
     * 
     * @param string $tag
     * @param array $attr
     */
    public function addMasterTag($tag, array $attr=NULL) {
        $tag=preg_replace('#[^\w]#','',$tag);
        $this->_masterTag=new tag($tag, $attr);
    }
    /**
     * return group html tag
     * 
     * @return object tag or null
     */
    public function getMasterTag() {
        if (isset($this->_masterTag)) {
            return $this->_masterTag;
        }
        return NULL;
    } 
    /**
     * return label+html tag as string
     * 
     * @return string
     */
    public function getLabel() {
        $label=$this->_labelTag===NULL?"":$this->_labelTag->getStartTag();
        if (isset($this->_label)) {
            $label.=$this->_label;
        } 
        $label.=$this->_labelTag===NULL?"":$this->_labelTag->getEndTag();
        return $label;
    }

}