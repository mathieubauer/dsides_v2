const Masonry = require('masonry-layout');
let jQueryBridget = require('jquery-bridget');
let imagesloaded = require('imagesloaded');
jQueryBridget('masonry',Masonry,$);
let grid_item = '.imgGrid-item';
let grid_sizer = '.imgGrid-size'

let $imgGrid = $('.imgGrid').masonry({
        itemSelector: grid_item,
        columnWidth: grid_sizer,
        transitionDuration: '0.3s',
        percentPosition: true,
        gutter:0
});

imagesloaded('.imgGrid-item', function () { $imgGrid.masonry('layout') });

$('.imgGrid-item').click( function() {
    $( this ).toggleClass('grid-item--gigante');
    $imgGrid.masonry('layout');
});
