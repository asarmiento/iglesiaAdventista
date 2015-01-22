<?php

class TiposUser extends \Eloquent {
    use SoftDeletingTrait;
    protected $softDelete = true;
    protected $table = 'tipos_users';
    // Add your validation rules here
    public static $rules = [
        'name' => 'required'
    ];
    // Don't forget to fill this array
    protected $fillable = ['name'];

    public function user() {
        return $this->belongsTo('User','id','tipos_users_id');
    }

}
