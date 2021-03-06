//set map options
var myLatLng = {lat:28.3949, lng:84.1240};

var mapOptions = {
    center:myLatLng,
    zoom:8,
    mapTypeId: google.maps.MapTypeId.ROADMAP
};

var map = new google.maps.Map(document.getElementById("googleMap"),mapOptions);


//create a directions service object to use the route method and get a result for our request

var directionsService = new google.maps.DirectionsService();

//create a Directions render object which we will use to display

var directionsDisplay = new google.maps.DirectionsRenderer();

//bind the directionsRenderer to the map

directionsDisplay.setMap(map);

//function
function calcRoute(){
    //create request
    var request = {
        origin: document.getElementById("from").value,
        destination: document.getElementById("to").value,
        travelMode: google.maps.TravelMode.DRIVING, //WALKING, BYCYCLE and TRANSIT
        unitSystem: google.maps.UnitSystem.METRIC
    };

    //pass the request to the route method
    directionsService.route(request, (result,status) => {
        if (status == google.maps.DirectionsStatus.OK){
            //get distance and time
            const output = document.querySelector('#output');
            output.innerHTML = "<div class=\"form-group row\">\n" +
                "            <div class=\"col-6\">\n" +
                "                <label>Distance</label>\n"+
                "                <input required type=\"text\" class=\"form-control\" name=\"distance\" placeholder=\"Distance\" value=\"" + result.routes[0].legs[0].distance.text + "\">\n" +
                "            </div>\n" +
                "            <div class=\"col-6\">\n" +
                "                <label>Duration</label>\n"+
                "                <input required type=\"text\" class=\"form-control\" name=\"duration\" placeholder=\"Duration\" value=\"" + result.routes[0].legs[0].duration.text + "\">\n" +
                "            </div>\n" +
                "</div>";
            directionsDisplay.setDirections(result);
        }else{
            //delete route from map
            directionsDisplay.setDirections({routes: []});

            //center map in nepal
            map.setCenter(myLatLng);

            //show error message
            output.innerHTML = "<div class='alert-danger'><i class='fas fa-exclamation-triangle'></i>Could not retrieve driving distance.</div>"
        }
    })
}

//create autocomplete objects for all input
var options ={
    country: 'np',
    types: ['(cities)']
};

var input1 = document.getElementById("from");
var autocomplete1 = new google.maps.places.Autocomplete(input1, options);

var input2 = document.getElementById("to");
var autocomplete2 = new google.maps.places.Autocomplete(input2, options);



