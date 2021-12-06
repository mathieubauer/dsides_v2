console.log('isotope javascript');
let $ = require('jquery');
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
    console.log(filterVal);
    let options = {
        filter: filterVal,
        stagger: 40
    }
    $grid.isotope(options)
});
