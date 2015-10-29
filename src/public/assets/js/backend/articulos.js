$(function () {
    $('#crudtable').dataTable({
        "bServerSide": false,
        "bAutoWidth": true,
        "bDestroy": true

    });
    $('.dataTables_filter input').addClass('form-control').attr('placeholder','Buscar...');
    $('.dataTables_length select').addClass('form-control');


    $('#crudtable').on('click', '.delete', function(){
        if (confirm('Está seguro que desea borrar el articulo?')) {
            var row = $(this).parents('tr');
            var id = parseInt($(this).attr('data-id'));

            $.ajax({
                type : 'POST',
                url  : '/api/articulos/delete',
                data : { 'articulo' : id }
            }).done(function( data ){
                row.remove();
            });
        }
    });
});


$(function () {
    'use strict';

    function setArticulo( articulo ) {
        var articulo = '<tr class="odd gradeX">'
                     + '    <td class="">' + articulo.categoria + '</td>'
                     + '    <td class="">' + articulo.color + '</td>'
                     + '    <td class="">' + articulo.talle + '</td>'
                     + '    <td class="">' + articulo.sexo + '</td>'
                     + '    <td class="">' + articulo.precio + '</td>'
                     + '    <td class="">' + articulo.imagen + '</td>'
                     + '    <td class="">' + articulo.stock + '</td>'
                     + '    <td class=""><a data-id="' + articulo.id + '" class="delete" style="display: block">X</a></td>'
                     + '    <td style="display:none" data-id="' + articulo.id + '" class="id "></td>'
                     + '</tr>';

        return articulo;
    }

    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload({
        url: '/api/articulos/add',
        always : function( e, data ){
            var row,
                container = $('#crudtable tbody');

            row = setArticulo(data.jqXHR.responseJSON.articulo);
            container.append(row);
        },
        fail : function( e, data ){
            console.log(e);
            console.log(data);
        }
    });

    $('#fileupload').fileupload('option', {
        maxFileSize: 5000000,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        parentidselector: null
    });

});
