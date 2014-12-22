$(document).ready(function(){
    
     $("#presupuesto").change(function(event){
            var id = $("#presupuesto").find(':selected').val();
            $("#tipopresupuesto").load('/tpresupuestos/select/'+id);
        });
        
         $("#tipopresupuesto").change(function(event){
            var id = $("#tipopresupuesto").find(':selected').val();
             var pres = $("#presupuesto").find(':selected').val();
            $("#cuentapresupuesto").load('/saldocuentapresupuestos/select?id='+id+'&pres='+pres);
        });
});