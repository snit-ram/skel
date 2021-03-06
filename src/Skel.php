<?php
namespace skel;

require_once __DIR__."/annotations/annotations.php";

/**
 * Main Skel class
 *
 * All model classes should inherit from this class
 *
 * @author snit-ram
 * @package skel
 */
class Skel{

    /**
     * Magic method that returns the value for protected attributes
     * @param string $attribute the attribute name
     * @return mixed the attribute value
     * @ignore
     */
    public function &__get( $attribute ){
        $magicMethod = '__get' . ucfirst($attribute);
        if( method_exists($this, $magicMethod) ){
            $return = $this->$magicMethod();
            return $return;
        }

        return $this->$attribute;
    }


    /**
     * Magic method that sets the value for protected attributes
     * @param string $attribute the attribute name
     * @param mixed $value the value to be set to attribute
     * @return null
     * @ignore
     */
    public function __set( $attribute, $value ){
        $magicMethod = '__set' . ucfirst($attribute);
        if( method_exists($this, $magicMethod) ){
            $this->$attribute = $this->$magicMethod( $value );
            return;
        }

        $this->$attribute = $value;
    }
}
