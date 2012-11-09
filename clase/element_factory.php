<?php
/******************************************************
 * Projectname:   php form class 
 * Version:       1.0
 * Author:        Tzuly <tzulac@gmail.com>
 * Last modified: 15-oct-2012
 ******************************************************
 * Description of element_factory class
 * 
 * This class extend factory design pattern.
 * Here are generated form elements objects.
 * 
 */
class element_factory {
    /**
     * Return a new element object based on type
     * 
     * @return object element
     */
    public static function getInstance($name,$type) {
        //filter input variables
        $name=preg_replace('#[^\w]#','',$name);
        $type=preg_replace('#[^\w]#','',$type);
        if (strlen($name)<1 || strlen($type)<1) {
            throw new Exception('Element must have name and type');
        }
        //check if element of type has class
        if (!class_exists($type)) {
            throw new Exception ($type.' class not loaded');
        }
        return new $type($name);
    }
}