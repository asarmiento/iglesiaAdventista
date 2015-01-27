<?php

class Iglesia extends \Eloquent {
    use SoftDeletingTrait;
    protected $softDelete = true;
    // Add your validation rules here

    // Don't forget to fill this array
    protected $fillable = ['name', 'phone', 'address'];

    public function user() {
        return $this->belongsTo('user','id','users_id');
    }
     public function miembro() {
        return $this->belongsTo('Miembro','id','iglesias_id');
    }
    public function departamento() {
        return $this->belongsTo('Departamento','id','departamentos_id');
    }
     public function isValid($data)
    {  
        $rules = ['name'=> 'required|unique:iglesias',
            'phone' => 'required',
        'address' => 'required'];
       
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
