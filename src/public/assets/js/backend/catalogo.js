$(function () {
var editor;

    editor = new $.fn.dataTable.Editor({
        "ajaxUrl": {
            "create" : "/api/catalogos/create",
            "edit"   : "/api/catalogos/edit",
            "remove" : "/api/catalogos/delete",
        },
        "domTable":"#crudtable",
        "idSrc"   : "id",
        "fields":[
            {
                "label":"Nombre:",
                "name":"nombre"
            },
            {
                "label":"Fecha:",
                "name":"fecha",
                "type": "date",
                def: function() { return new Date(); },
                "dateFormat": 'D, d M y'
            },
            {
                "label":"Estado:",
                "name":"estado",
                "type":"select",
                "ipOpts": [
                    { label: "Habilitado", value: "habilitada" },
                    { label: "Deshabilitado", value: "deshabilitada" }
                ],
                "default": "habilitada"
            }
        ]
    });

    editor.on('onPostCreate', function( e, json, data ){
        catalogoArticulos[ json.id  ] = new Array();
    });

    editor.on('onPostRemove', function( e, json, data ){
        var container = $('#articulosCampanaSeleccionada').empty();

        delete catalogoArticulos[ json.id  ];
    });

    $('#crudtable').dataTable({
        "sDom":"<'row'<'col-sm-6'T><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "bServerSide": false,
        "bAutoWidth": true,
        "bDestroy": true,
        "aoColumns":[
            { "mData":"nombre" },
            { "mData":"fecha" },
            { "mData":"estado" },
            { "mData":"id" }
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
    $('#sArticulos').quicksearch('ul.ms-list li');

    $('#crudtable_wrapper_list').droppable({
        drop: function( event, ui) {
            id = parseInt(ui.draggable.attr('id'));
            catalogo = $('#crudtable tr.active td:last').text();

            if ($.inArray(id, catalogoArticulos[catalogo]) < 0) {
                $.ajax({
                    type : 'POST',
                    url : '/api/catalogos/setarticulo',
                    data : { 'articulo' : id, 'catalogo' : catalogo }
                }).done(function( data ) {
                    var row = setArticulo ( id );
                    $('#articulosCampanaSeleccionada').append(row);
                    catalogoArticulos[catalogo].push(id);
                });
            } else {
                alert('La catalogo ya posee este articulo!');
            }

        }
    });

    $('ul.ms-list li').draggable({
        cursor: "crosshair",
        disabled: true,
        revert: true
    });

    $('#crudtable').on('click', 'tbody tr', function(){
        var id = $(this).find('td:last').text(),
            container = $('#articulosCampanaSeleccionada').empty();

        $('ul.ms-list li').draggable("option", "disabled", true);

        if ($(this).hasClass('active')) {
            $('ul.ms-list li').draggable("option", "disabled", false);

            if (typeof catalogoArticulos[id] != 'undefined' && catalogoArticulos[id].length > 0) {
                for (i in catalogoArticulos[id]) {
                    var row = setArticulo( catalogoArticulos[id][i] );
                    container.append(row);
                }
            }
        }
    });

    $('#articulosCampanaSeleccionada').on('click', '.removeArticulo', function(){
        if (confirm('Está seguro que desea borrar el articulo?')) {
            var row = $(this).parents('tr');
            var id = parseInt($(this).attr('data-id'));
            var catalogoId = $('.gradeX.active td.id').text();

            $.ajax({
                type : 'POST',
                url  : '/api/catalogos/removearticulo',
                data : { 'articulo' : id, 'catalogo' : catalogoId }
            }).done(function( data ){
                row.remove();
                var index = catalogoArticulos[catalogoId].indexOf(parseInt(id));
                catalogoArticulos[catalogoId].splice(index, 1);
            });
        }
    });


    function setArticulo( id ) {
        var articulo = '<tr>'
                     + '<td>' + articulos[id].id + '</td>'
                     + '<td>' + articulos[id].categoria + '</td>'
                     + '<td>' + articulos[id].color + '</td>'
                     + '<td>' + articulos[id].talle + '</td>'
                     + '<td>' + articulos[id].sexo + '</td>'
                     + '<td>' + articulos[id].precio + '</td>'
                     + '<td><a style="display:block;" class="removeArticulo" data-id="' + id + '">x</a></td>';
        return articulo;
    }

});

