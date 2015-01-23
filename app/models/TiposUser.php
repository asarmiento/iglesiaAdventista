<?php

class TiposUser extends \Eloquent {

    use SoftDeletingTrait;

    protected $softDelete = true;
    protected $table = 'tipos_users';

    // Don't forget to fill this array
    protected $fillable = ['name'];

    public function user() {
        return $this->belongsTo('User', 'id', 'tipos_users_id');
    }

  public function isValid($data)
    {  
        $rules = ['name'=> 'required|unique:tipos_users'];
       
        if ($this->exists)
        {
            $rules['name'] .= ',name,' . $this->id;
        }
       
         $validator = Validator::make($data, $rules);
        if ($validator->passes())
        {
            return true;
        }
        
        $this->errors = $validator->errors();
        
        return false;
    }

}
