var formularioArticulos = {

    settings : {
        'selectRows' : '#articulosRows',
        'form'       : '#validate-form',
        'submit'     : '#submit'
    },

    createRow : function( i ) {
      var row = '<tr>'
              + '   <td class="form-group"><input name="articulo[' + i + '][nombre]" type="text" placeholder="Nombre del articulo" required="required" class="form-control parsley-validated"></td>'
              + '   <td class="form-group"><input name="imagen_' + i + '" type="file" required="required" class="form-control"></td>'
              + '   <td class="form-group">'
              + '       <select name="articulo[' + i + '][categoria]" class="form-control" required="required">'
              + '           <option value=""></option>'
              + '           <option value="1">Remera</option>'
              + '           <option value="2">Pantalon</option>'
              + '           <option value="3">Buzo</option>'
              + '           <option value="4">Musculosa</option>'
              + '           <option value="5">Campera</option>'
              + '           <option value="6">Mono</option>'
              + '           <option value="7">Short</option>'
              + '           <option value="8">Bermuda</option>'
              + '           <option value="9">Joggin</option>'
              + '           <option value="10">Vestido</option>'
              + '           <option value="11">Pollera</option>'
              + '       </select>'
              + '   </td>'
              + '   <td class="form-group"><input name="articulo[' + i + '][color]" type="text" placeholder="Color" required="required" class="form-control"></td>'
              + '   <td class="form-group">'
              + '       <select name="articulo[' + i + '][talle]" class="form-control" required="required">'
              + '           <option value=""></option>'
              + '           <option value="S">S</option>'
              + '           <option value="M">M</option>'
              + '           <option value="L">L</option>'
              + '           <option value="X">X</option>'
              + '           <option value="XL">XL</option>'
              + '       </select>'
              + '   </td>'
              + '   <td class="form-group">'
              + '       <select name="articulo[' + i + '][sexo]" class="form-control" required="required">'
              + '           <option value=""></option>'
              + '           <option value="H">Hombre</option>'
              + '           <option value="M">Mujer</option>'
              + '           <option value="U">Unisex</option>'
              + '       </select>'
              + '   </td>'
              + '   <td class="form-group"><input name="articulo[' + i + '][precio]" type="text" placeholder="Precio" required="required" class="form-control"></td>'
              + '</tr>';

        return row;
    },

    setRows : function( triggerClass ) {
        return triggerClass.bind('change', function(){
            var value = $(this).val();

            $('#listadoArticulosNuevos').empty();

            for (i = 0; i < value; i++) {
               $('#listadoArticulosNuevos').append(formularioArticulos.createRow( i ));
            }
        });
    },

    form : {

        validate : function( fields ) {

            var f = 0;

            $.each(fields, function(index, element){

                if ($(element).val() == '') {
                    $(element).parent().addClass('has-error');
                    f++;
                } else {
                    $(element).parent().addClass('has-success').removeClass('has-error');
                    f--;
                }

            });

            if (f > 0 || fields.length == 0) {
                return false;
            }

            return true;
        },

        submit : function( triggerClass, form ) {

            return triggerClass.bind('click', function(){

                if (formularioArticulos.form.validate( $('#listadoArticulosNuevos input, #listadoArticulosNuevos select') )) {
                    form.submit();
                }            

            });

        }

    },


    init : function() {
        this.setRows( $(this.settings.selectRows) );
        this.form.submit( $(this.settings.submit), $(this.settings.form) );
    }

};

formularioArticulos.init();
