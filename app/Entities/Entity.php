<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 04/10/15
 * Time: 09:05 PM
 */

namespace SistemasAmigables\Entities;


use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{

    public function getClass()
    {
        return get_class(new static);
    }
}