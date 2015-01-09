<?php

class Gasto extends \Eloquent {

    // Add your validation rules here
    public static $rules = [
        'num_factura' => 'required',
        'date' => 'required',
        'datefactura' => 'required',
        'monto' => 'required',
        'descripcion' => 'required',
        'departamentos_id' => 'required',
    ];
    // Don't forget to fill this array
    protected $fillable = ['num_factura', 'date', 'datefactura', 'monto', 'descripcion', 'departamentos_id'];

    public function Departamentos() {

        $this->HasMany('departamentos');
    }

}
