import './styles/produit.css';

if (typeof L !== 'undefined') {
    var mymap = L.map('mapid').setView([51.505, -0.09], 13);
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: 'pk.eyJ1IjoiY2hhcmxlc2FuZyIsImEiOiJja2psd2FlZHcwY3dtMnpxcHZqMndoNzcxIn0.QLuISkLVhz-4Ev3KHeCvSw'
    }).addTo(mymap);
}

$('input[type=range]').on("change", function() {
    let value = $(this).val();
    let text = value + ' €';
    if (value > 75) {
        text += ' <i class="fas fa-heart"></i>';
    }
    if (value > 50) {
        text += ' <i class="fas fa-heart"></i>';
    }
    if (value > 25) {
        text += ' <i class="fas fa-heart"></i>';
    }
    $('.rangeInputValue').html(text);
});