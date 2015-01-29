<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Validator::extend('alpha_custom', function($attribute, $value)
{
    return preg_match('/^[0-9a-zA-Z\@\ñ\Ñ\Ó\é\É\á\Á\í\Í\ú\Ú\ó\*\_\.]+$/', $value);
});


//class ValidatorGlobal {
// 
//    public function unico($attribute, $value, $parameters){
//        dd($value);
//        if ($this->exists)
//        {
//            $rules['name'] .= ',name,' . $this->id;
//        }
//      
//         $validator = Validator::make($data, $rules);
//        if ($validator->passes())
//        {
//            return true;
//        }
//        
//        $this->errors = $validator->errors();
//        
//        return false;
//    }
//
//}
