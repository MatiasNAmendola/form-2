<?php
/**************************************************************
* Projectname:   php form generate class 
* Version:       1.0
* Author:        Tzuly <tzulac@gmail.com>
* Last modified: 15-oct-2012
***************************************************************
* 
****************************
* Description: tag class   *
**************************** 
* This class create html tag.
* Is used to set start and end tags for label, for element, for group;
* - set attributes for tag created
*/
class tag {
    /**
     * name of tag
     * 
     * @var string 
     */
    private $_tag;
    /**
     * array with tag attributes where key is attributes name
     *
     * @var array 
     */
    private $_attr=array();
    /**
     * construct for setting tname of tag and tag attributes
     * 
     * @param string $tag
     * @param array $attr
     */
    public function __construct($tag,$attr=NULL) {
        $this->_tag=$tag;
        if ($attr!==NULL && count($attr)>0) {
            foreach ($attr as $key=>$value) {
                $key=preg_replace('#[^\w]#','',$key);
                $value=preg_replace('#[^\w\s]#','',$value);
                $this->_attr[$key]=$value;
            }
        }
    }
    /**
     * return start tag
     * 
     * @return string
     */
    public function getStartTag() {
        if (!empty($this->_tag)) {
            $startTag="<".$this->_tag;
            if (count($this->_attr)>0) {
                foreach ($this->_attr as $key=>$value) {
                    $startTag.=" $key='".$value."' ";
                }
            } 
            $startTag.=">";
            return $startTag;
        }
        return '';
    }
    /**
     * return end tag
     * 
     * @return string
     */
    public function getEndTag() {
        if (!empty($this->_tag)) {
            $endTag="</".$this->_tag.">";
            return $endTag;
        }
        return '';
    }
}