
// functions for displaying countries and regions on lists / dropdowns etc.

$(document).ready(function () {

    // Some exampels of accessing the country and region data structures
/*
    console.log("Countries codes and Regions \n");
    for(var key in all_countries_sdg){
        var country_code = all_countries_sdg[key][0];
        var country_region = all_countries_sdg[key][1];
        var country_code_2 = all_countries_3_to_2[country_code];
        if(typeof country_code_2 === "undefined"){
            alert("Undefined country code 2: " + key + " : " + country_code);
        }
        console.log(key  + " : " + country_code + " (" + country_code_2 + ") : " + country_region);
    }


    // list the regions and their countries
    console.log("Regions \n");
    for(var key in all_regions_sdg){
        console.log("-- Region ------------ " + key);

        var this_region = all_regions_sdg[key];
        // list the countries
        for(var i = 0; i < this_region.length; i++){
            console.log(this_region[i] + ", ");
        }
    }
    */
    // --- Finished examples

    // Functions for operation on the data to display on the page //region?
    function populate_country_select_dropdown(){
        // Populates the region dropdown
        var select_options = get_regions_select_options();
        $("#region_select").html(select_options);
    }

    function get_regions_select_options(){
        var select_options = "";
        //select_options += "<option >---------------------------</option>\n";
        for(var key in all_regions_sdg){
            //var this_region_countries = all_regions_sdg[key];
            //what is this notation doing?
            select_options += "<option value='" + key + "'>" + key + "</option>\n";
        }
        // And one special one
        select_options += "<option disabled>---------------------------</option>\n";
        select_options += "<option value='world'>The World (all countries)</option>\n";

        return select_options;
    }

    function get_countries_select_options_by_region(region){
        var select_options = "";
        if(region != "world") {
            var this_region = all_regions_sdg[region];

            // list the countries
            for (var i = 0; i < this_region.length; i++) {
                var this_country = this_region[i];
                if(this_country in all_countries_sdg) {
                    var this_country_code = all_countries_sdg[this_country][0];
                    select_options += "<option value='" + this_country_code + "'>" + this_country + "</option>\n";
                }
            }
        }else{
            // All countries
            for(var key in all_countries_sdg){
                select_options += "<option value='" + all_countries_sdg[key][0] + "'>" + key + "</option>\n";
            }
        }
        return select_options;
    }

    function get_country_name_from_code(country_code){
        var code;
        for(var country_name in all_countries_sdg){
            if(country_name in all_countries_sdg) {
                code = all_countries_sdg[country_name][0];
                if (code == country_code) {
                    return country_name;
                }
            }
        }

        return "No county found matching this code: " + country_code;
    }

    function get_country_data(){
        // Takes the all_cities object and construct the array of data
        // that is the unique list of countries
        var data = [];
        var country_codes = [];
        var country_codes_unique;
        var country_code, country_name;
        var i;

        for(i = 0 ; i < all_cities_arr.length; i++){
            country_code = all_cities_arr[i].country_code;
            country_codes.push(country_code);
        }
        country_codes_unique  = country_codes.filter(function(item, i, ar){ return ar.indexOf(item) === i; });

        for(i = 0; i < country_codes_unique.length ; i++){
            country_code = country_codes_unique[i];
            country_name = get_country_name_from_code(country_code);

            var country_obj = {
                code3: country_code,
                name: country_name,
                value: 50
            };

            data.push(country_obj);
        }

        return data;
    }
    // End of functions -----------------------------

    // Set the on-change event function for the region
    $('#region_select').change(function() {
        event.preventDefault();

        var region_text = $(this).children("option:selected").text();
        // what is this value, actually the key to all_regions?
        var region_value = this.value;

        var select_options = get_countries_select_options_by_region(region_value);
        //populate country dropdown
        $("#country_select").html(select_options);

        // Make the country selector visible (the containing div)
        $('#country_select_div').show();

        //clears chosen country
        $("p").html("");

    });

    // Set the on-change event function for the country
    $('#country_select').change(function() {
        event.preventDefault();

        var country = $(this).children("option:selected").text();
        var country_code = this.value;

        //alert("You chose: " + country + " (" + country_code + ")");
        var chosenCountry = $("p");
        var text = "You chose: " + country + " (" + country_code + ")"
        /*
        chosenCountry
            .html(text)
            .css("font-size","18px")
            .prependTo("div #top-of-map");
            */
        $('#message_div').html(text).css("font-size","18px");


        // Cant get this zoom in to a selected country to work
        var country_code_2 = all_countries_3_to_2[country_code];
        //theChart.get(country_code_2).zoomTo(); //zoom to the country using "id" from data serie
        //theChart.mapZoom(5);
    });

    // Call the function to populate the region and country selects
    // why do we populate region select box this late?
    populate_country_select_dropdown();

    // Get the country data from the cities list
    // This function creates a uniq list of countries and then makes the data structure
    var data = get_country_data();

    // Put canada on the end of the data for effect
    data.push({code3: "CAN",
        name: "Canada",
        value: 500});

    // put the cities into an appropriate data structure
    var cities_data = all_cities_arr;
/*
    var data = [
        {
        code3: "BGD",
        name: "Bangladesh",
        value: 50
    }, {
        code3: "GHA",
        name: "Ghana",
        value: 50
    }, {
        code3: "SEN",
        name: "Senegal",
        value: 50
    }, {
        code3: "KEN",
        name: "Kenya",
        value: 50
    }, {
        code3: "MOZ",
        name: "Mozambique",
        value: 50
    }, {
        code3: "ZAF",
        name: "South Africa",
        value: 50
    }, {
        code3: "LKA",
        name: "Sri Lanka",
        value: 50
    }, {
        code3: "UGA",
        name: "Uganda",
        value: 50
    }, {
        code3: "ZMB",
        name: "Zambia",
        value: 50
    }, {
        code3: "CAN",
        name: "Canada",
        value: 500
    }];
*/


     var myBaseMap = {

        chart: {
            map: 'custom/world'
        },

        mapNavigation: {
            enabled: true,
            enableDoubleClickZoomTo: true,
            buttonOptions: {
                verticalAlign: 'top'
            }
        },
        //colorAxis
        colorAxis: {
            min: 1,
            max: 1000,
            type: 'logarithmic'
        },

        legend: {
            enabled: false
        },

         title: {
             text: 'World Map',
             style: {
                 color: '#3042ff',
                 fontWeight: 'bold',
                 fontFamily: "monospace",
                 fontSize: "20px"
             }

         },

        series: [
            {
                data: data,
                joinBy: ['iso-a3', 'code3'],
                name: 'Sanitation',
                states: {
                    hover: {
                        color: 'purple'
                    }
                },
                tooltip: {
                    headerFormat: 'Country<br>',
                    useHTML: true,
                    //headerFormat: '<em>Date: {point.key}</em><br/>',
                    pointFormatter: function(){
                        var text;
                        text = '<em>' + this.series.name + '</em><br/>'
                            + 'Country: <b>' + this.name + '</b><br/>'
                            + 'Country Code: <b>' + this.code3 + '</b><br/>'
                            + 'Value : <b>' + this.value + '</b>';
                        return  text;
                    },
                    shared: true
                }
            },
            {
                type: 'mappoint',
                name: 'Cities',
                color: 'purple',
                data: cities_data,
                tooltip: {
                    headerFormat: 'Cities<br>',
                    useHTML: true,
                    pointFormatter: function(){
                        var text;
                        var completed_text = "YES";
                        if(this.completed < 1){completed_text = "NO";}
                        text = '<em>' + this.name + '</em><br/>'
                            + 'Country Code: <b>' + this.country_code + '</b><br/>'
                            + 'latitude : <b>' + this.lat + '</b><br/>'
                            + 'longitude: <b>' + this.lon + '</b><br/>'
                            + 'Survey ccompleted: <b>' + completed_text+ '</b><br/>'
                        ;

                        return  text;
                    }
                },
            }
        ]

     };
    myBaseMap.series[0].states.hover.color = "rgba(255,255,0,0.2)";// "yellow";

    theChart = $('#container').highcharts("Map",myBaseMap);


});