<?php

require_once 'HTMLPurifier/AttrDef.php';
require_once 'HTMLPurifier/AttrDef/Number.php';

class HTMLPurifier_AttrDef_CSSLength extends HTMLPurifier_AttrDef
{
    
    var $units = array('em' => true, 'ex' => true, 'px' => true, 'in' => true,
         'cm' => true, 'mm' => true, 'pt' => true, 'pc' => true);
    var $number_def;
    
    function HTMLPurifier_AttrDef_CSSLength($non_negative = false) {
        $this->number_def = new HTMLPurifier_AttrDef_Number($non_negative);
    }
    
    function validate($length, $config, &$context) {
        
        $length = $this->parseCDATA($length);
        if ($length === '') return false;
        if ($length === '0') return '0';
        $strlen = strlen($length);
        if ($strlen === 1) return false; // impossible!
        
        // we assume all units are two characters
        $unit = substr($length, $strlen - 2);
        $number = substr($length, 0, $strlen - 2);
        
        if (!isset($this->units[$unit])) return false;
        
        $number = $this->number_def->validate($number, $config, $context);
        if ($number === false) return false;
        
        return $number . $unit;
        
    }
    
}

?>