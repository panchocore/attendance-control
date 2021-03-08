    function MuestraMensajeGuardadoCorrectoPegajoso(mensaje) {
        $().toastmessage('showToast', {
            text     : mensaje,
            sticky   : false,
            position : 'top-center',
            type     : 'success',
            closeText: '',
            close    : function () {
                console.log("Mensaje cerrado ...");
            }
        });

    }
    function MuestraInformacion(mensaje) {
        $().toastmessage('showToast', {
             text     : mensaje,
             sticky   : false,
             position : 'top-center',
             type     : 'notice',
             closeText: '',
             close    : function () {console.log("Mensaje cerrado ...");}
        });
    }
    function showStickyWarningToast() {
        $().toastmessage('showToast', {
            text     : 'Warning Dialog which is sticky',
            sticky   : false,
            position : 'top-right',
            type     : 'warning',
            closeText: '',
            close    : function () {
                console.log("Mensaje cerrado ...");
            }
        });
    }
    function mostrarerroregajoso(mensaje) {
        $().toastmessage('showToast', {
            text     : mensaje,
            sticky   : false,
            position : 'top-center',
            type     : 'error',
            closeText: '',
            close    : function () {
                console.log("Mensaje cerrado ...");
            }
        });
    }
    function mostrarerroregajosopermisos(mensaje) {
        $().toastmessage('showToast', {
            text     : mensaje,
            sticky   : false,
            position : 'middle-center',
            type     : 'error',
            closeText: '',
            close    : function () {
                console.log("Mensaje cerrado ...");
            }
        });
    }
    function mostrarerroregajosoderecha(mensaje) {
            $().toastmessage('showToast', {
                text     : mensaje,
                sticky   : true,
                position : 'top-right',
                type     : 'error',
                closeText: '',
                close    : function () {
                    console.log("Mensaje cerrado ...");
                }
            });
    }