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
//Jquery;
import 'jquery';
import 'isotope-layout'

$(document).ready(function () {
    $("#list-filter a").click(function () {
        let listitem = $(this).data("id");
        if (listitem === 'all') {
           $("#row #cardView").show(1000,"swing");
        }else {
            $("#row #cardView").hide();
            $("." + listitem).show();
        }
    });
})//jquery