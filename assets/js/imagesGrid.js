console.log('images gird')
const Masonry = require('masonry-layout');
let jQueryBridget = require('jquery-bridget');
let imagesloaded = require('imagesloaded');
jQueryBridget('masonry',Masonry,$);

let $imgGrid = $('.imgGrid').masonry({
        itemSelector: '.imgGrid-item',
        columnWidth: 160,
        transitionDuration: '0.3s',
        stagger: 20,
});
imagesloaded('.imgGrid-item', function () { $imgGrid.masonry('layout') });



$('.imgGrid-item').click( function() {
    $( this ).toggleClass('grid-item--gigante');
    $imgGrid.masonry('layout');
});
