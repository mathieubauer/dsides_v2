/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
import 'bootstrap';

// start the Stimulus application
import './bootstrap';
let $ = require('jquery');
let jQueryBridget = require('jquery-bridget');
let Isotope = require('isotope-layout');
jQueryBridget('isotope', Isotope, $);

let $grid = $('.grid').isotope({
    itemSelector: '.grid-item',
    layoutMode:'fitRows'
});

$("#list-filter a").click(function () {
    let filterVal = $(this).attr('data-filter');
    $grid.isotope({
        filter: filterVal,
        stagger: 50
    })
});
