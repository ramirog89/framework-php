$(function() {
    var iContainer =  $('#portfolioContainer').isotope({
        itemSelector: '.folio',
        layoutModule: 'masonry',
        masonry: {
            columnWidth: 280,
            rowHeight: 440,
            isFitWidth: true
        },
    });

    $('.filter').click(function(){
        var filtro = $(this).attr('data-filter');
        iContainer.isotope({ filter: filtro });
    });    
    
});

