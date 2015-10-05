<?php

namespace SistemasAmigables\Entities;

use Illuminate\Database\Eloquent\Model;

class Menu extends Entity
{
    protected $fillable = ['name', 'url', 'icon_font'];
    //
    public function getRules()
    {
       return [
            'name'      => 'required',
            'url'       => 'required',
            'icon_font' => 'required' ];
    }

    public function getExist()
    {
        // TODO: Implement getExist() method.
    }

    public function Tasks()
    {
        return $this->belongsToMany(Task::getClass())->withPivot('status');
    }

    public function tasksActive($user)
    {
        return $this->belongsToMany(Task::getClass(), 'task_user')->wherePivot('status', 1)->wherePivot('user_id', $user);
    }
}
