$(function () {
    $('#crudtable').dataTable({});

    $('.dataTables_filter input').addClass('form-control').attr('placeholder','Buscar...');
    $('.dataTables_length select').addClass('form-control');

    $('#crudtable').on('click', 'tr', function(){
        $('#crudtable tr').removeClass('active');

        $(this).addClass('active');
        var id = $(this).find('td.id').text();
        var container = $('#articulosCampanaSeleccionada');

        $('#campana-id').val(id);
        
        container.empty();

        if ($(this).hasClass('active')) {
            if (typeof campanaArticulos[id] != 'undefined' && Object.keys(campanaArticulos[id]).length > 0) {
                for (i in campanaArticulos[id]) {
                    var row = setArticulo( campanaArticulos[id][i] );
                    container.append(row);
                }

            }
        }
    });


    $('#delete-campain').on('click', function(e) {
        var cid = $('#campana-id').val(),
            row = $('#crudtable tr.active'),
            container = $('#articulosCampanaSeleccionada');

        if (cid.length > 0) {
            if(confirm('Está seguro que desea eliminar la campaña?')) {
                $.ajax({
                    type : 'POST',
                    url  : '/api/campanas/delete',
                    data : { 'campana' : cid }
                }).done(function( data ){
                    delete campanaArticulos[cid];
                    row.remove();
                    container.empty();
                    $('#campana-id').val('');
                });
            }
        }
    });


    $('#articulosCampanaSeleccionada').on('click', '.removeArticulo', function(){
        if (confirm('Está seguro que desea borrar el articulo?')) {
            var row = $(this).parents('tr');
            var id = parseInt($(this).attr('data-id'));
            var campana = $('.gradeX.active td.id').text();
            var index = row.find('td.orden').text();

            $.ajax({
                type : 'POST',
                url  : '/api/campanas/removearticulo',
                data : { 'articulo' : id, 'campana' : campana }
            }).done(function( data ){
                row.remove();
                delete campanaArticulos[campana][index];
            });
        }
    });

    function setArticulo( articulo ) {
        var articulo = '<tr id="' + articulo.orden + '">'
                     + '<td class="id">' + articulo.id + '</td>'
                     + '<td style="text-align:center"><span class="preview">'
                     + '<img src="/media/site/img/content/campanas/' + articulo.campana + '/' + articulo.imagen + '" width="50" height="50" /></span></td>'
                     + '<td class="orden">' + articulo.orden + '</td>'
                     + '<td><a style="display:block;" class="removeArticulo" data-id="' + articulo.id + '">x</a></td>';
        return articulo;
    }

    $('#articulosCampanaSeleccionada').sortable({
        stop : function( event, ui ) {
            var order = $('#articulosCampanaSeleccionada').sortable('toArray');
            var r = new Array();
            var campana = $('.gradeX.active td.id').text();

            for (i in order) {
                r.push({ 
                    'id' : $('#articulosCampanaSeleccionada tr[id='+ order[i] +'] td.id').text(), 
                    'orden' : i
                });

                $('#articulosCampanaSeleccionada tr[id='+ order[i] +'] td.orden').text(i);
            }

            $.ajax({
                type : 'POST',
                url  : '/api/campanas/setorder',
                data : { 'articulosorden' : r, 'campana' : campana }
            }).done(function( data ){
                campanaArticulos[campana] = jQuery.parseJSON(data);
            });
        }
    });


    $('#fileupload').fileupload({
        url: '/api/campanas/addarticulo',
        always : function( e, data ){
            var row,
                container = $('#articulosCampanaSeleccionada'),
                campana = $('.gradeX.active td.id').text();

            //campanaArticulos[campana][data.jqXHR.responseJSON.articulo.orden] = data.jqXHR.responseJSON.articulo;

            row = setArticulo(data.jqXHR.responseJSON.articulo);
            container.append(row);
        },
        fail : function( e, data ){
            console.log(e);
            console.log(data);
        }
    });

    $('#fileupload').fileupload('option', {
        maxFileSize: 10000000,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        parentidselector: '.gradeX.active td.id',
        parenterrormessage: 'Debe seleccionar una campaña antes de agregar archivos'
    });


});


 $(function() {
    var  name = $( "#nombre" ),
    allFields = $( [] ).add( name ),
         tips = $( ".validateTips" );

    function updateTips( t ) {
        tips
            .text( t )
            .addClass( "ui-state-highlight" );

        setTimeout(function() {
            tips.removeClass( "ui-state-highlight", 1500 );
        }, 500 );
    }
    function checkLength( o, n, min, max ) {
        if ( o.val().length > max || o.val().length < min ) {
            o.addClass( "ui-state-error" );
            updateTips( "Length of " + n + " must be between " +
            min + " and " + max + "." );
            return false;
        } else {
            return true;
        }
    }
    function checkRegexp( o, regexp, n ) {
        if ( !( regexp.test( o.val() ) ) ) {
            o.addClass( "ui-state-error" );
            updateTips( n );
            return false;
        } else {
            return true;
        }
    }
    $( "#dialog-form" ).dialog({
        autoOpen: false,
        height: 500,
        width: 550,
        modal: true,
        buttons: {
            "Crear campana": function() {
                var bValid = true;
                allFields.removeClass( "ui-state-error" );
//                bValid = bValid && checkLength( name, "username", 3, 16 );
                if ( bValid ) {
                    $('form#campanaform').submit();
                    allFields.val('');
                    $( this ).dialog( "close" );
                }
            },
            Cancel: function() {
                $( this ).dialog( "close" );
            }
        },
        close: function() {
            allFields.val( "" ).removeClass( "ui-state-error" );
        }
    });

    $( "#create-campain" ).button().click(function() {
        $( "#dialog-form" ).dialog( "open" );
    });

});

