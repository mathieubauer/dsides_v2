let jQueryBridget = require('jquery-bridget');
let Isotope = require('isotope-layout');
jQueryBridget('isotope', Isotope, $);

//initialisation de Isotope
let $grid = $('#homeViewArticle').isotope({
    itemSelector: '#cardView',
    layoutMode:'fitRows'
});

//Configuration du filtre
$("#list-filter a").click(function () {
    let filterVal = $(this).attr('data-filter');
    let options = {
        filter: filterVal,
        stagger: 40
    }
    $grid.isotope(options)
});

$('#attch_img').isotope({
    itemSelector: '#imgGrid-item',
    percentPosition: true,
    masonry: {
        columnWidth: 'imgGrid-size'
    }
})
