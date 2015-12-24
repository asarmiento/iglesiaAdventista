<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 04/10/15
 * Time: 09:05 PM
 */

namespace SistemasAmigables\Entities;


use Illuminate\Database\Eloquent\Model;

abstract class Entity extends Model
{
    abstract public function getRules();

    public function getClass()
    {
        return get_class(new static);
    }

    public function isValid($data) {
        $rules = $this->getRules();

        $validator = \Validator::make($data, $rules);

        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }
}