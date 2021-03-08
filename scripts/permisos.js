function desabilitarMenusForm(permisos)//permisos 1-lectura, 2-escritura
            {
	            if(permisos == 1){
               		$('input:submit, input:button, input:text').attr('disabled','disabled');
                }
         	   //$('#prof').attr('disabled','');
         	}
function desabilitarMenusTabla(permisos)//permisos 0-lectura, 1-escritura
{
    if(permisos == 1){
   		$('input:submit[value!="Filtrar tabla"], input:button, input:file').attr('disabled','disabled');
   		$('a').attr('href','javascript:mostrarerroregajosopermisos("No tiene permisos para ejecutar esta opcion")');
		//$('#file1').attr('disabled','disabled');
   		//$('input[value!="Filtrar tabla"]').attr('disabled','disabled');
    }
	   //$('#prof').attr('disabled','');
	}