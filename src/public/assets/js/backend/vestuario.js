var editor;

$(function () {
    editor = new $.fn.dataTable.Editor({
        "ajaxUrl": {
           "create" : "/api/vestuarios/create",
           "edit"   : "/api/vestuarios/edit",
           "remove" : "/api/vestuarios/delete"
        },
        "domTable" : "#crudtable",
        "idSrc"   : "id",
        "fields":[
            {
                "label":"Nombre:",
                "name":"nombre"
            },
            {
                "label":"Fecha:",
                "name":"fecha"
            }
        ]
    });

    editor.on('onPostCreate', function( e, json, data ){
        vestuarioArticulos[ json.id  ] = new Array();
    });

/*
    editor.on('onPostEdit', function( e, json, data ){
    });
*/

    editor.on('onPostRemove', function( e, json, data ){
        $('#articulosVestuarioSeleccionado').empty();
        $('#vestuario-id').val('');
        delete vestuarioArticulos[ json.id  ];
    });

    $('#crudtable').dataTable({
        "sDom": "<'row'<'col-sm-6'T><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "bServerSide": false,
        "bAutoWidth": true,
        "bDestroy": true,
        "aoColumns":[
            { "mData":"id" },
            { "mData":"nombre" },
            { "mData":"fecha" }
        ],
        "oTableTools":{
            "sRowSelect":"single",
            "aButtons":[
                { "sExtends":"editor_create", "editor": editor },
                { "sExtends":"editor_edit",   "editor": editor },
                { "sExtends":"editor_remove", "editor": editor }
            ]
        }
    });


    $('.dataTables_filter input').addClass('form-control').attr('placeholder','Buscar...');
    $('.dataTables_length select').addClass('form-control');


    $('#crudtable').on('click', 'tr', function(){
        var id = $(this).find('td:first').text();
        var container = $('#articulosVestuarioSeleccionado');

        $('#vestuario-id').val(id);
        
        container.empty();

        if ($(this).hasClass('active')) {
            if (typeof vestuarioArticulos[id] != 'undefined' && Object.keys(vestuarioArticulos[id]).length > 0) {
                for (i in vestuarioArticulos[id]) {
                    var row = setArticulo( vestuarioArticulos[id][i] );
                    container.append(row);
                }

            }
        }
    });

    $('#articulosVestuarioSeleccionado').on('click', '.removeArticulo', function(){
        if (confirm('Está seguro que desea borrar el articulo?')) {
            var row = $(this).parents('tr');
            var id = parseInt($(this).attr('data-id'));
            var vestuario = $('.gradeX.active td.id').text();
            var index = row.find('td.orden').text();

            $.ajax({
                type : 'POST',
                url  : '/api/vestuarios/removearticulo',
                data : { 'articulo' : id, 'vestuario' : vestuario }
            }).done(function( data ){
                row.remove();
                delete vestuarioArticulos[vestuario][index];
            });
        }
    });

    function setArticulo( articulo ) {
        var articulo = '<tr id="' + articulo.orden + '">'
                     + '<td class="id">' + articulo.id + '</td>'
                     + '<td style="text-align:center">'
                     + '<span class="preview">'
                     + '<img src="/media/site/img/content/vestuarios/' + articulo.vestuario + '/.thumbs/' + articulo.imagen + '" width="50" height="50" /></span>'
                     + '</td>'
                     + '<td class="orden">' + articulo.orden + '</td>'
                     + '<td><a style="display:block;" class="removeArticulo" data-id="' + articulo.id + '">x</a></td>';
        return articulo;
    }


    $('#articulosVestuarioSeleccionado').sortable({
        stop : function( event, ui ) {
            var order = $('#articulosVestuarioSeleccionado').sortable('toArray');
            var r = new Array();
            var vestuario = $('.gradeX.active td.id').text();

            for (i in order) {
                r.push({ 
                    'id' : $('#articulosVestuarioSeleccionado tr[id='+ order[i] +'] td.id').text(), 
                    'orden' : i
                });
                $('#articulosVestuarioSeleccionado tr[id='+ order[i] +'] td.orden').text(i);
            }

            $.ajax({
                type : 'POST',
                url  : '/api/vestuarios/setorder',
                data : { 'articulosorden' : r, 'vestuario' : vestuario }
            }).done(function( data ){
                vestuarioArticulos[vestuario] = jQuery.parseJSON(data);
            });
        }
    });

    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload({
        url: '/api/vestuarios/addarticulo',
        always : function( e, data ){
            var row,
                container = $('#articulosVestuarioSeleccionado');

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
        parentidselector: '#crudtable tr.active',
        parenterrormessage: 'Debe seleccionar un vestuario antes de agregar archivos'
    });

});
