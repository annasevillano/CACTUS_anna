
var current_study_data = null;
var ppp_array = null;
var cpi_array = null;

var cat1_costs = {capex: [], opex: [], tot_annualised: [], tot_annualised_sum: 0 };
var cat2_costs = {capex: [], opex: [], tot_annualised: [], tot_annualised_sum: 0 };
var service_costs = {service_value:[], tot_annual_service: [], tot_annual_service_sum: 0 };
var target_year = "2016";

var cat1s = [
    "Direct - Variable",
    "Direct - Fix",
    "Indirect - Fix",
    "Indirect - Variable"
];
var cat2s = [
    "Land",
    "Labour",
    "Input material, consumables and services",
    "Capital",
    "Taxes",
    "Financing",
    "Other Expenses"
];
var all_cost_types = [
    "CAPEX",
    "OPEX"
];
var all_service_drivers = [
    "Material Treated",
    "Number of Trips",
    "Containments Served",
    "Households Served",
    "People Served",
    "Number of People per Household",
    "No. of HHs per Septic Tank (10m3)"
];

var all_old_components = [
    "Direct",
    "Sealed tank",
    "Infiltrating pit",
    "Container",
    "Mechanical",
    "Manual",
    "Pipe (e.g. Simplified Sewerage)",
    "Pipe (e.g. Conventional Sewerage)",
    "Pipe (e.g. Simplified Sewerage with pumping)",
    "Pipe (e.g. Conventional Sewerage with pumping)",
    "Road Mechanical",
    "Road Manual",
    "Road Manual Transfer Station Mechanical",
    "Composting FS",
    "Ponds & Wetlands",
    "Anaerobic Digestions",
    "Aerated systems"
];

var all_systems = [
    "FSM",
    "Sewerage"
];
var all_elements = [
    "Containment",
    "Emptying",
    "Emptying and Transport",
    "Transport",
    "Treatment"
];
var all_new_components = [
    "Direct",
    "Sealed tank (no outlet)",
    "Sealed tank (with outlet)",
    "Infiltrating pit",
    "Container",
    "Pipes - conventional, separate, with pumping",
    "Pipes - conventional, separate, no pumping",
    "Pipes - conventional, combined, with pumping",
    "Pipes - conventional, combined, no pumping",
    "Pipes - simplified, separate, with pumping",
    "Pipes - simplified, separate, no pumping",
    "Pipes - simplified, combined, with pumping",
    "Pipes - simplified, combined, no pumping",
    "Wheels - human-powered",
    "Wheels - machine-powered",
    "Wheels - human- and/or machine-powered with transfer station",
    "Manual (no specialised equipment)",
    "Human-powered with specialised equipment",
    "Machine powered",
    "Passive aerobic waste water",
    "Machine-powered aerobic waste water",
    "Anaerobic wastewater",
    "Aerobic FSM",
    "Anaerobic FSM"
];

var new_cost_type1 = [
    "CAPEX",
    "OPEX"
];
var new_cost_type2 = [
    "Direct - Variable",
    "Direct - Fix",
    "Indirect - Fix",
    "Indirect - Variable"
];

var new_category1 = [
    "Land",
    "Infrastructure and Buildings",
    "Equipment",
    "Major and Extraordinary Repairs",
    "Staff Development",
    "Other CAPEX",
    "Staffing",
    "Consumables",
    "Other OPEX",
    "Administrative Charges",
    "Financing",
    "Taxes"
];
var new_category2 = [
    "Utilities",
    "Fuel",
    "Chemicals",
    "Services",
    "Other Consumables"
];
var new_category3 = [
    "Consulting/Advisory",
    "Legal",
    "Insurance",
    "Regular Maintenance",
    "Other Services"
];

var function_return_value; // A global general value to use for many things

$(document).ready(function () {

    /**
     * Sends a form when that form is chosen.
     */
    $('#base_data_xlsx_file').change(function () {
        // 'base_data_xlsx_file' is the id of the input button

        // 'post_base_data_xlsx' is the id of the form
        $('#post_base_data_xlsx').submit();

    });

    /**
     * When a form is submitted this function gets called to get the database from a php file.
     */
    $('#post_base_data_xlsx').on('submit', function (event) {
        event.preventDefault();
        var file_data = $('#base_data_xlsx_file').prop('files')[0];
        var form_data = new FormData();
        form_data.append('base_data_xlsx_file', file_data);
        //alert(file_data.name);
        $('#result').empty();
        $("#base_data_filename").text(file_data.name);
        $.ajax({
            type: 'post',
            url: 'fetch_base_data_xlsx.php',
            data: form_data,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (mydata) {
                // reset all arrays
                //console.log(JSON.stringify(mydata));
                $('#result').html('<H2>AJAX RESULT:</H2>' + JSON.stringify(mydata));

                // No need to do anything with the returned data
                // It should have all been pushed into the database
                // could inform the user that it has been entered
                alert("City Summary base data file uploaded ");

            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('An error occurred... Look at the console (F12 or Ctrl+Shift+I, Console tab) for more information!');

                //$('#result').html('<p>status code: ' + jqXHR.status + '</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>' + jqXHR.responseText + '</div>');
                console.log('jqXHR:');
                console.log(jqXHR);
                console.log(jqXHR.responseText);
                console.log('textStatus:');
                console.log(textStatus);
                console.log('errorThrown:');
                console.log(errorThrown);
            }
        });
    });

    $('#master_data_xlsx_file').change(function () {
        // 'master_data_xlsx_file' is the id of the input button

        // 'post_master_data_xlsx' is the id of the form
        $('#post_master_data_xlsx').submit();

    });

    $('#post_master_data_xlsx').on('submit', function (event) {
        event.preventDefault();
        var file_data = $('#master_data_xlsx_file').prop('files')[0];
        var form_data = new FormData();
        form_data.append('master_data_xlsx_file', file_data);
        //alert(file_data.name);
        $('#result').empty();
        $("#master_data_filename").text(file_data.name);
        $.ajax({
            type: 'post',
            url: 'fetch_master_data_old_xlsx.php',
            data: form_data,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (mydata) {
                // reset all arrays
                //console.log(JSON.stringify(mydata));
                $('#result').html('<H2>AJAX RESULT:</H2>' + JSON.stringify(mydata));

                // No need to do anything with the returned data
                // It should have all been pushed into the datamaster
                // could inform the user that it has been entered
                alert("Master data file uploaded ");
                console.log(JSON.stringify(mydata.raw_data_obj));
                location.reload(true);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('An error occurred... Look at the console (F12 or Ctrl+Shift+I, Console tab) for more information!');

                //$('#result').html('<p>status code: ' + jqXHR.status + '</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>' + jqXHR.responseText + '</div>');
                console.log('jqXHR:');
                console.log(jqXHR);
                console.log(jqXHR.responseText);
                console.log('textStatus:');
                console.log(textStatus);
                console.log('errorThrown:');
                console.log(errorThrown);
            }
        });
    });

    $('#cpi_data_xlsx_file').change(function () {
        // 'cpi_data_xlsx_file' is the id of the input button

        // 'post_cpi_data_xlsx' is the id of the form
        $('#post_cpi_data_xlsx').submit();

    });

    $('#post_cpi_data_xlsx').on('submit', function (event) {
        event.preventDefault();
        var file_data = $('#cpi_data_xlsx_file').prop('files')[0];
        var form_data = new FormData();
        form_data.append('cpi_data_xlsx_file', file_data);
        //alert(file_data.name);
        $('#result').empty();
        $("#cpi_data_filename").text(file_data.name);
        $.ajax({
            type: 'post',
            url: 'fetch_cpi_data_xlsx.php',
            data: form_data,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (mydata) {
                // reset all arrays
                //console.log(JSON.stringify(mydata));
                $('#result').html('<H2>AJAX RESULT:</H2>' + JSON.stringify(mydata));

                // No need to do anything with the returned data
                // It should have all been pushed into the database
                // could inform the user that it has been entered
                alert("CPI data file uploaded ");

            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('An error occurred... Look at the console (F12 or Ctrl+Shift+I, Console tab) for more information!');

                //$('#result').html('<p>status code: ' + jqXHR.status + '</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>' + jqXHR.responseText + '</div>');
                console.log('jqXHR:');
                console.log(jqXHR);
                console.log(jqXHR.responseText);
                console.log('textStatus:');
                console.log(textStatus);
                console.log('errorThrown:');
                console.log(errorThrown);
            }
        });
    });

    $('#ppp_data_xlsx_file').change(function () {
        // 'ppp_data_xlsx_file' is the id of the input button

        // 'post_ppp_data_xlsx' is the id of the form
        $('#post_ppp_data_xlsx').submit();

    });

    $('#post_ppp_data_xlsx').on('submit', function (event) {
        event.preventDefault();
        var file_data = $('#ppp_data_xlsx_file').prop('files')[0];
        var form_data = new FormData();
        form_data.append('ppp_data_xlsx_file', file_data);
        //alert(file_data.name);
        $('#result').empty();
        $("#ppp_data_filename").text(file_data.name);
        $.ajax({
            type: 'post',
            url: 'fetch_ppp_data_xlsx.php',
            data: form_data,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (mydata) {
                // reset all arrays
                //console.log(JSON.stringify(mydata));
                $('#result').html('<H2>AJAX RESULT:</H2>' + JSON.stringify(mydata));

                // No need to do anything with the returned data
                // It should have all been pushed into the database
                // could inform the user that it has been entered
                alert("PPP data file uploaded ");

            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('An error occurred... Look at the console (F12 or Ctrl+Shift+I, Console tab) for more information!');

                //$('#result').html('<p>status code: ' + jqXHR.status + '</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>' + jqXHR.responseText + '</div>');
                console.log('jqXHR:');
                console.log(jqXHR);
                console.log(jqXHR.responseText);
                console.log('textStatus:');
                console.log(textStatus);
                console.log('errorThrown:');
                console.log(errorThrown);
            }
        });
        //fetch_xlsx_data(val);
    });

    $('#cpi_button').on('click', function (e) {
        e.preventDefault(); // disable the default form submit event

        // manually get the data
        var country_code = $('#CPICountyID').val();
        var year = $('#CPIYearID').val();
        var which_calc = "cpi";
        var form_data = new FormData();
        form_data.append('country_code', country_code);
        form_data.append('year', year);
        form_data.append('which_calc', which_calc);

        $.ajax({
            type: 'post',
            url: 'get_cpi_ppp_calcs.php',
            data: form_data,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (mydata) {
                //alert('response received');
                // ajax success callback
                console.log(mydata);
                var value = parseFloat(mydata.value);
                var value_str;
                if (isNaN(value) || value < 0) {
                    value_str = "undefined";
                } else {
                    value_str = value;
                }
                $('#cpi_value').val(value_str);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('An error occurred... Look at the console (F12 or Ctrl+Shift+I, Console tab) for more information!');

                //$('#result').html('<p>status code: ' + jqXHR.status + '</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>' + jqXHR.responseText + '</div>');
                console.log('jqXHR:');
                console.log(jqXHR);
                console.log(jqXHR.responseText);
                console.log('textStatus:');
                console.log(textStatus);
                console.log('errorThrown:');
                console.log(errorThrown);
            }
        });
    });
    $('#ppp_button').on('click', function (e) {
        e.preventDefault(); // disable the default form submit event

        // manually get the data
        var country_code = $('#PPPCountyID').val();
        var year = $('#PPPYearID').val();
        var which_calc = "ppp";
        var form_data = new FormData();
        form_data.append('country_code', country_code);
        form_data.append('year', year);
        form_data.append('which_calc', which_calc);

        $.ajax({
            type: 'post',
            url: 'get_cpi_ppp_calcs.php',
            data: form_data,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (mydata) {
                //alert('response received');
                // ajax success callback
                console.log(mydata);
                var value = parseFloat(mydata.value);
                var value_str;
                if (isNaN(value) || value < 0) {
                    value_str = "undefined";
                } else {
                    value_str = value;
                }
                $('#ppp_value').val(value_str);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('An error occurred... Look at the console (F12 or Ctrl+Shift+I, Console tab) for more information!');

                //$('#result').html('<p>status code: ' + jqXHR.status + '</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>' + jqXHR.responseText + '</div>');
                console.log('jqXHR:');
                console.log(jqXHR);
                console.log(jqXHR.responseText);
                console.log('textStatus:');
                console.log(textStatus);
                console.log('errorThrown:');
                console.log(errorThrown);
            }
        });
    });
    $('#get_cpi_ppp_button').on('click', function (e) {
        e.preventDefault(); // disable the default form submit event

        // get the data from the db and put in ppp and cpi
        get_cpi_ppp_arrays();

    });

    /**
     * Creates two arrays.
     * One with all the data about PPP in different countries in different years and one with all that data about CPI.
     */
    function get_cpi_ppp_arrays(){
        $.ajax({
            type: 'post',
            url: 'fetch_ppp_data_db.php',
            async: false,
            data: null,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (mydata) {
                //console.log(mydata);
                ppp_array = mydata.ppp_array;

                //var country_code = "ABW";
                //var year = 1990;
                //var val = ppp_array[country_code][year];

                //alert("Country code " + country_code + " Year " + year + " ppp value: " + val);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('An error occurred... Look at the console (F12 or Ctrl+Shift+I, Console tab) for more information!');

                //$('#result').html('<p>status code: ' + jqXHR.status + '</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>' + jqXHR.responseText + '</div>');
                console.log('jqXHR:');
                console.log(jqXHR);
                console.log(jqXHR.responseText);
                console.log('textStatus:');
                console.log(textStatus);
                console.log('errorThrown:');
                console.log(errorThrown);
            }
        });

        $.ajax({
            type: 'post',
            url: 'fetch_cpi_data_db.php',
            async: false,
            data: null,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (mydata) {
                //console.log(mydata);
                cpi_array = mydata.cpi_array;

                //var country_code = "ABW";
                //var year = 1990;
                //var val = cpi_array[country_code][year];

                //alert("Country code " + country_code + " Year " + year + " cpi value: " + val);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('An error occurred... Look at the console (F12 or Ctrl+Shift+I, Console tab) for more information!');

                //$('#result').html('<p>status code: ' + jqXHR.status + '</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>' + jqXHR.responseText + '</div>');
                console.log('jqXHR:');
                console.log(jqXHR);
                console.log(jqXHR.responseText);
                console.log('textStatus:');
                console.log(textStatus);
                console.log('errorThrown:');
                console.log(errorThrown);
            }
        });

    }

    /**
     * Adjusts a cost value from a currency and year to that cost value in US dollars in a target year.
     *
     * @param {number} source_value The initial value of the cost.
     * @param {string} source_country_code The country code of the place with that currency.
     * @param {string} source_year The year that the cost occurred.
     * @param {string} target_year The year that the value needs to be adjusted to.
     * @return {number} The original value but now adjusted to $ in 2016.
     */
    function adjust_value2(source_value, source_country_code, source_year, target_year){
        // Does the adjust calc but usig the arrays
        // source country code gives country code of currency used
        // Check we have the data in the array, if not go an get it (this is very slow)
        if(cpi_array === null || ppp_array === null){
            get_cpi_ppp_arrays();
        }

        var value_adjusted = null;

        var ppp_years = ppp_array[source_country_code];
        var ppp_target = ppp_array[source_country_code][target_year];
        var cpi_origin = cpi_array[source_country_code][source_year];
        var cpi_target = cpi_array[source_country_code][target_year];

        if(ppp_target < 0 || cpi_origin < 0 || cpi_target < 0){
            return value_adjusted;
        }

        var denom = ppp_target * cpi_origin;
        if(Math.abs(denom) > 0.00001){
            value_adjusted = source_value * cpi_target / denom;
        }

        function_return_value = value_adjusted;
        return value_adjusted;
    }

    /**
     * Annualises an initially cost with a formula that uses a lifetime and a discount rate.
     *
     * @param {number} value The initial value of the cost.
     * @param {number} serviceLife The lifetime of the CAPEX cost.
     * @param {number} actuationRate The discount rate.
     * @return {number} The original value but now annualised.
     */
    function Annualise(value, serviceLife, actuationRate){
        value = parseFloat(value);
        serviceLife = parseFloat(serviceLife);
        actuationRate = parseFloat(actuationRate);
        var compound = Math.pow(1 + actuationRate, serviceLife);
        var value_annualised = null;

        value_annualised = value*actuationRate*(compound / (compound - 1));

        function_return_value = value_annualised;
        return value_annualised;
    }

    $('#adjust_button').on('click', function (e) {
        e.preventDefault(); // disable the default form submit event

        // manually get the data
        var source_value = $('#currency_value').val();
        var source_country_code = $('#ValueCountyID').val();
        var source_year = $('#SourceYearID').val();
        var target_year = $('#TargetYearID').val();

        //value = adjust_value(source_value, source_country_code, source_year, target_year);
        value = adjust_value2(source_value, source_country_code, source_year, target_year);

        var value = function_return_value;
        var value_str;
        if (isNaN(value) || value < 0) {
            value_str = "undefined";
        } else {
            value_str = value.toFixed(2);
        }
        $('#adjusted_value').val(value_str);
    });

    $('#base_data_table_div').toggle();
    $('#base_data_table_chk').on('click', function (e) {
        $('#base_data_table_div').toggle();
    });
    $('#master_data_table_chk').on('click', function (e) {
        $('#master_data_table_div').toggle();
    });

    $('input[type=radio][name=study_radio]').change(function() {
        //alert("Study selected: " + this.value);
        var study_id = this.value;
        var num_components_id = '#num_components_' + study_id;
        var num_components = $(num_components_id).val();

        var form_data = new FormData();
        form_data.append('study_id', study_id);
        $('#study_summary').html('Study id = ' + this.value + ' Num components = ' + num_components);

        $.ajax({
            type: 'post',
            url: 'fetch_raw_data_old_from_db.php',
            data: form_data,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (mydata) {
                // ajax success callback
                //console.log(mydata);
                current_study_data = mydata;
                process_current_study();
                //$('#study_summary').html('<H2>AJAX RESULT:</H2>' + JSON.stringify(mydata));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('An error occurred... Look at the console (F12 or Ctrl+Shift+I, Console tab) for more information!');

                //$('#result').html('<p>status code: ' + jqXHR.status + '</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>' + jqXHR.responseText + '</div>');
                console.log('jqXHR:');
                console.log(jqXHR);
                console.log(jqXHR.responseText);
                console.log('textStatus:');
                console.log(textStatus);
                console.log('errorThrown:');
                console.log(errorThrown);
            }
        });
    });

    /**
     * Builds table of cities are there characteristics. Gets information from the database.
     *
     * @return {string} A string of HTML to be put into the cities table.
     */
    function get_datapoint_detail_table_body(){
        var study_id = $('input[type=radio][name=study_radio]:checked').val();
        var study_index = study_id - 1;

        var html = "";
        for(var i = 0; i < current_study_data.study_data.length; i++){
            var study = current_study_data.study_data[i].resources[0];

            var input = "<input type='radio' id='datapoints_radio' name='datapoints_radio' value='" + i + "'>";
            var input_dp = "<input type='hidden' id='datapoint_id_" + i + "' value='" + study.datapoint_id + "'>";

            html += "<tr>";
            html += "<td>" + input + "</td>";
            html += "<td>" + study_id + ":" + (i+1) + "</td>";
            html += "<td>" + study.datapoint_id + input_dp + "</td>";
            html += "<td>" + study.element + "</td>";
            html += "<td>" + study.system + "</td>";
            html += "<td>" + study.component + "</td>";
            html += "<td>" + study.case_desc + "</td>";
            html += "<td>" + study.data_source + "</td>";
            //html += "<td>" + study.resource_service + "</td>";
            //html += "<td>" + study.item_desc + "</td>";
            html += "</tr>\n";
        }

        return html;
    }

    $('#datapoint_detail_table').on("change", "input[type=radio]", function() {
        var study_id = $('input[type=radio][name=study_radio]:checked').val();
        var study_index = study_id - 1;

        var data_index_of_study = this.value;
        var data_id_of_study = parseInt(data_index_of_study) + 1;

        var datapoint_id_str = "#datapoint_id_" + data_index_of_study;
        var datapoint_id = $(datapoint_id_str).val();

        var data_resources = current_study_data.study_data[data_index_of_study].resources;
        var data_services = current_study_data.study_data[data_index_of_study].services;

        //alert("Study id: " + study_id + " data counter: " + data_id_of_study + " datapoint_id: " + datapoint_id);

        // Is this how to call the function or does it need to be in ajax?
        process_current_datapoint(data_resources,data_services);

    });

    /**
     * Function called when radio button of a specific data point within a city is clicked.
     * Loops through data structure making calculations that are stored in global variables
     * that are then pushed into a table.
     */
    function process_current_datapoint(resources,services) {
        // clear capex and opex arrays
        cat1_costs.capex = [];
        cat1_costs.opex = [];
        cat1_costs.tot_annualised = [];
        cat1_costs.tot_annualised_sum = 0;
        cat2_costs.capex = [];
        cat2_costs.opex = [];
        cat2_costs.tot_annualised = [];
        cat2_costs.tot_annualised_sum = 0;

        for (var k = 0; k < all_cost_types.length; k++) {
            var my_cost_type = all_cost_types[k]; //CAPEX or OPEX

            // Category 1
            for (var m = 0; m < cat1s.length; m++) {
                var my_cat1 = cat1s[m];  // a Category 1
                var my_total = 0;
                var my_total_annual = 0;

                var num_resources = resources.length;

                for (var j = 0; j < num_resources; j++) {
                    var this_res = resources[j];
                    var cat_1 = this_res.category_1;
                    var cost_type = this_res.cost_type;
                    var one_val_cost = this_res.one_value_cost;
                    var adjusted_val;

                    if (one_val_cost > 0.001) {
                        var currency_country_code = this_res.currency;
                        if (currency_country_code === ""){currency_country_code = this_res.country;}

                        adjusted_val = adjust_value2(one_val_cost, currency_country_code, this_res.year_cost, target_year);
                    } else {
                        adjusted_val = 0;
                    }

                    if (cat_1 === my_cat1 && cost_type === my_cost_type) {
                        my_total += adjusted_val;
                        var annualised_val;
                        // if it has a lifetime it should be a CAPEX
                        if (this_res.lifetime > 0) {
                            annualised_val = Annualise(adjusted_val, this_res.lifetime, this_res.discount_rate);
                            my_total_annual += annualised_val;
                        } else {
                            annualised_val = 0;
                            my_total_annual += annualised_val;
                        }
                    }
                }
                if (my_cost_type === "CAPEX") {
                    cat1_costs.capex.push(my_total);
                    cat1_costs.tot_annualised.push(my_total_annual);
                }else{
                    cat1_costs.opex.push(my_total);
                }
            }

            // Category 2
            for (m = 0; m < cat2s.length; m++) {
                var my_cat2 = cat2s[m];
                var my_total2 = 0;
                var my_total_annual2 = 0;

                var num_resources2 = resources.length;

                for (j = 0; j < num_resources2; j++) {
                    var this_res2 = resources[j];
                    var cat_2 = this_res2.category_2;
                    var cost_type2 = this_res2.cost_type;
                    var one_val_cost2 = this_res2.one_value_cost;
                    var adjusted_val2;

                    if (one_val_cost2 > 0.001) {
                        var currency_country_code2 = this_res2.currency;
                        if (currency_country_code2 === ""){currency_country_code2 = this_res2.country;}

                        adjusted_val2 = adjust_value2(one_val_cost2, currency_country_code2, this_res2.year_cost, target_year);
                    } else {
                        adjusted_val2 = 0;
                    }

                    if (cat_2 === my_cat2 && cost_type2 === my_cost_type) {
                        my_total2 += adjusted_val2;

                        var annualised_val2;
                        // if it has a lifetime it should be a CAPEX
                        if (this_res2.lifetime > 0) {
                            annualised_val2 = Annualise(adjusted_val2, this_res2.lifetime, this_res2.discount_rate);
                            my_total_annual2 += annualised_val2;
                        } else {
                            annualised_val2 = 0;
                            my_total_annual2 += annualised_val2;
                        }
                    }
                }
                if (my_cost_type === "CAPEX") {
                    cat2_costs.capex.push(my_total2);
                    cat2_costs.tot_annualised.push(my_total_annual2);
                } else {
                    cat2_costs.opex.push(my_total2);
                }
            }
        }

        // Adds total OPEX value to the annualised CAPEX values
        // Sums all complete annualised values
        for(var i = 0; i < cat1_costs.tot_annualised.length; i++) {
            cat1_costs.tot_annualised[i] = cat1_costs.tot_annualised[i] + cat1_costs.opex[i];
            cat1_costs.tot_annualised_sum += cat1_costs.tot_annualised[i];
        }
        for(i = 0; i < cat2_costs.tot_annualised.length; i++) {
            cat2_costs.tot_annualised[i] = cat2_costs.tot_annualised[i] + cat2_costs.opex[i];
            cat2_costs.tot_annualised_sum += cat2_costs.tot_annualised[i];
        }

        // Services
        service_costs.service_value = [];
        service_costs.tot_annual_service = [];
        service_costs.tot_annual_service_sum = 0;

        for ( k = 0; k < all_service_drivers.length; k++) {
            var my_service_driver = all_service_drivers[k];
            var my_s_total = 0;
            var num_services = services.length;

            for ( j = 0; j < num_services; j++) {
                var this_ser = services[j];
                var service_driver = this_ser.item_desc;
                var one_val_count = parseFloat(this_ser.one_value_count);

                if (service_driver === my_service_driver) {
                    my_s_total += one_val_count;
                } else {
                    my_s_total += 0;
                }
            }
            service_costs.service_value.push(my_s_total);
            var this_annual_service = 0;

            if (my_s_total === 0) {
                service_costs.tot_annual_service.push(0);
            } else {
                this_annual_service = (cat1_costs.tot_annualised_sum) / (service_costs.service_value[service_costs.service_value.length - 1]);
                service_costs.tot_annual_service.push(this_annual_service);
            }
        }
        // Sum total annualised service costs
        for (i = 0; i < service_costs.tot_annual_service.length; i++) {
            service_costs.tot_annual_service_sum += service_costs.tot_annual_service[i];
        }

        // Update tables - Does it need this first block or not?
        // Cat1 table
        //-----------------
        // Destroy the datatables if necessary
        if ($.fn.DataTable.isDataTable('#cat1_summary_table')) {
            $('#cat1_summary_table').DataTable().destroy();
        }
        // Empty the body of the table
        $('#cat1_summary_table tbody').empty();
        // get the new body of the table and append it
        var cat1_table_html_body = get_cat1_summary_table_body();
        $('#cat1_summary_table > tbody:last').append(cat1_table_html_body);
        // Reattach the datatables functionality
        $("#cat1_summary_table").dataTable(cats_table_def);

        // Cat 2table
        //-----------------
        // Destroy the datatables if necessary
        if ($.fn.DataTable.isDataTable('#cat2_summary_table')) {
            $('#cat2_summary_table').DataTable().destroy();
        }
        // Empty the body of the table
        $('#cat2_summary_table tbody').empty();
        // get the new body of the table and append it
        var cat2_table_html_body = get_cat2_summary_table_body();
        $('#cat2_summary_table > tbody:last').append(cat2_table_html_body);
        // Reattach the datatables functionality
        $("#cat2_summary_table").dataTable(cats_table_def);

        // Services table
        //-----------------
        // Destroy the datatables if necessary
        if ($.fn.DataTable.isDataTable('#services_summary_table')) {
            $('#services_summary_table').DataTable().destroy();
        }
        // Empty the body of the table
        $('#services_summary_table tbody').empty();
        // get the new body of the table and append it
        var services_table_html_body = get_services_summary_table_body();
        $('#services_summary_table > tbody:last').append(services_table_html_body);
        // Reattach the datatables functionality
        $("#services_summary_table").dataTable(services_table_def);
    }

    /**
     * Builds the text to be put in the cost type 2 summary table (currently called category 1).
     *
     * @return {string} A string of HTML to be put into a table.
     */
    function get_cat1_summary_table_body(){
        // Builds the category 1 summary table
        var html = "";

        // The rows of the body
        for(var i = 0 ; i < cat1s.length ; i++) {
            html += "<tr>\n";
            html += "<td>" + cat1s[i] + "</td> <td class='text-right'>" +
                formatThousandNumber(cat1_costs.capex[i].toFixed(2)) + "</td> <td class='text-right'>" +
                formatThousandNumber(cat1_costs.opex[i].toFixed(2)) + "</td> <td class='text-right'>" +
                formatThousandNumber(cat1_costs.tot_annualised[i].toFixed(2)) + "</td>\n";
            html += "</tr>\n";
        }

        // The total row
        html += "<tr>\n";
        html += "<td>" +  "</td> <td>" +  "</td> <td>" + "</td> <td class='text-right' style='background: WhiteSmoke'>" +
            formatThousandNumber(cat1_costs.tot_annualised_sum.toFixed(2)) + "</td>\n";
        html += "</tr>\n";

        return html;
    }

    /**
     * Builds the text to be put in the category 1 summary table (currently called category 2).
     *
     * @return {string} A string of HTML to be put into a table.
     */
    function get_cat2_summary_table_body(){
        // Builds the category 1 summary table
        var html = "";

        // The rows of the body
        for(var i = 0 ; i < cat2s.length ; i++) {
            html += "<tr>\n";
            html += "<td>" + cat2s[i] + "</td> <td class='text-right'>" +
                formatThousandNumber(cat2_costs.capex[i].toFixed(2)) + "</td> <td class='text-right'>" +
                formatThousandNumber(cat2_costs.opex[i].toFixed(2)) + "</td> <td class='text-right'>" +
                formatThousandNumber(cat2_costs.tot_annualised[i].toFixed(2)) + "</td>\n";
            html += "</tr>\n";
        }

        // The total row
        html += "<tr>\n";
        html += "<td>" +  "</td> <td>" +  "</td> <td>" + "</td> <td class='text-right' style='background: WhiteSmoke'>" +
            formatThousandNumber(cat2_costs.tot_annualised_sum.toFixed(2)) + "</td>\n";
        html += "</tr>\n";

        return html;
    }

    /**
     * Builds the text to be put in the services summary table. Reads through array of service costs.
     *
     * @return {string} A string of HTML to be put into a table.
     */
    function get_services_summary_table_body(){
        // Builds the category 1 summary table
        var html = "";

        // The rows of the body
        for(var i = 0 ; i < all_service_drivers.length ; i++) {
            html += "<tr>\n";
            html += "<td>" + all_service_drivers[i] + "</td> <td class='text-right'>" +
                formatThousandNumber(service_costs.service_value[i].toFixed(2)) + "</td> <td class='text-right'>" +
                formatThousandNumber(service_costs.tot_annual_service[i].toFixed(2)) + "</td>\n";
            html += "</tr>\n";
        }

        // The total row
        html += "<tr>\n";
        html += "<td>" +  "</td> <td>" + "</td> <td class='text-right' style='background: WhiteSmoke'>" +
            formatThousandNumber(service_costs.tot_annual_service_sum.toFixed(2)) + "</td>\n";
        html += "</tr>\n";

        return html;
    }

    /**
     * Function called when radio button of a specific city is clicked.
     * Loops through data structure making calculations that are stored in global variables.
     */
    function process_current_study(){
        // current_study_data is a global variable
        //var mystring;
        //var mystring2;
        if(current_study_data !== null){
            // lets just write it out
            //$('#study_summary').html("<pre>" + JSON.stringify(current_study_data, undefined, 2) + "</pre>");

            //mystring = "<pre><strong><u>Resources</u></strong></pre>";
            //$('#study_summary').append(mystring);
            //mystring = "<u>Category 1</u> <BR>";
            //mystring2 = "<u>Category 2</u><BR>";

            var num_studies = current_study_data.study_data.length;

            // clear capex and opex arrays
            cat1_costs.capex = [];
            cat1_costs.opex = [];
            cat1_costs.tot_annualised = [];
            cat1_costs.tot_annualised_sum = 0;
            cat2_costs.capex = [];
            cat2_costs.opex = [];
            cat2_costs.tot_annualised = [];
            cat2_costs.tot_annualised_sum = 0;

            //var target_year = "2016";

            for (var k = 0; k < all_cost_types.length; k++) {
                var my_cost_type = all_cost_types[k]; //CAPEX or OPEX

                // Category 1
                for (var m = 0; m < cat1s.length; m++) {
                    var my_cat1 = cat1s[m];  // a Category 1
                    var my_total = 0;
                    var my_total_annual = 0;

                    for (var i = 0; i < num_studies; i++) {
                        var this_study = current_study_data.study_data[i];
                        var resources = this_study.resources;
                        var num_resources = resources.length;

                        for (var j = 0; j < num_resources; j++) {
                            var this_res = resources[j];
                            var cat_1 = this_res.category_1;
                            var cost_type = this_res.cost_type;
                            var one_val_cost = this_res.one_value_cost;
                            var adjusted_val;

                            if(one_val_cost>0.001) {
                                var currency_country_code = this_res.currency;
                                if (currency_country_code === ""){currency_country_code = this_res.country;}
                                adjusted_val = adjust_value2(one_val_cost, currency_country_code, this_res.year_cost, target_year);
                            }
                            else {
                                adjusted_val = 0;
                            }

                            if (cat_1 === my_cat1 && cost_type === my_cost_type) {
                                my_total += adjusted_val;
                                var annualised_val;
                                // if it has a lifetime it should be a CAPEX
                                if(this_res.lifetime > 0) {
                                    annualised_val = Annualise(adjusted_val,this_res.lifetime, this_res.discount_rate);
                                    my_total_annual += annualised_val;
                                }
                                else {
                                    annualised_val = 0;
                                    my_total_annual += annualised_val;
                                }
                            }
                        }
                    }
                    if(my_cost_type === "CAPEX"){
                        cat1_costs.capex.push(my_total);
                        cat1_costs.tot_annualised.push(my_total_annual);
                    }else{
                        cat1_costs.opex.push(my_total);
                    }
                    //mystring += "Total for <strong>" + my_cat1 + "</strong> and <strong>" + my_cost_type + "</strong> is: " + my_total.toFixed(0) + "<BR>";
                }

                // Category 2
                for (m = 0; m < cat2s.length; m++) {
                    var my_cat2 = cat2s[m];
                    var my_total2 = 0;
                    var my_total_annual2 = 0;

                    for (i = 0; i < num_studies; i++) {
                        var this_study2 = current_study_data.study_data[i];
                        var resources2 = this_study2.resources;
                        var num_resources2 = resources2.length;

                        for (j = 0; j < num_resources2; j++) {
                            var this_res2 = resources2[j];
                            var cat_2 = this_res2.category_2;
                            var cost_type2 = this_res2.cost_type;
                            var one_val_cost2 = this_res2.one_value_cost;
                            var adjusted_val2;

                            if(one_val_cost2>0.001) {
                                var currency_country_code2 = this_res2.currency;
                                if (currency_country_code2 === ""){currency_country_code2 = this_res2.country;}
                                adjusted_val2 = adjust_value2(one_val_cost2, currency_country_code2, this_res2.year_cost, target_year);
                            }
                            else {
                                adjusted_val2 = 0;
                            }

                            if (cat_2 === my_cat2 && cost_type2 === my_cost_type) {
                                my_total2 += adjusted_val2;

                                var annualised_val2;
                                // if it has a lifetime it should be a CAPEX
                                if(this_res2.lifetime > 0) {
                                    annualised_val2 = Annualise(adjusted_val2,this_res2.lifetime, this_res2.discount_rate);
                                    my_total_annual2 += annualised_val2;
                                }
                                else {
                                    annualised_val2 = 0;
                                    my_total_annual2 += annualised_val2;
                                }
                            }
                        }
                    }
                    if(my_cost_type === "CAPEX"){
                        cat2_costs.capex.push(my_total2);
                        cat2_costs.tot_annualised.push(my_total_annual2);
                    }else{
                        cat2_costs.opex.push(my_total2);
                    }
                    //mystring2 += "Total for <strong>" + my_cat2 + "</strong> and <strong>" + my_cost_type + "</strong> is: " + my_total2.toFixed(0) + "<BR>";
                }
            }

            //**********************************************************
            // Adds total OPEX value to the annualised CAPEX values
            // Sums all complete annualised values
            for(i = 0; i < cat1_costs.tot_annualised.length; i++) {
                cat1_costs.tot_annualised[i] = cat1_costs.tot_annualised[i] + cat1_costs.opex[i];
                cat1_costs.tot_annualised_sum += cat1_costs.tot_annualised[i];
            }
            for(i = 0; i < cat2_costs.tot_annualised.length; i++) {
                cat2_costs.tot_annualised[i] = cat2_costs.tot_annualised[i] + cat2_costs.opex[i];
                cat2_costs.tot_annualised_sum += cat2_costs.tot_annualised[i];
            }

            //$('#study_summary').append("<pre> "+mystring+"</pre>");
            //$('#study_summary').append("<pre> "+mystring2+"</pre>");

            // Services
            service_costs.service_value = [];
            service_costs.tot_annual_service = [];
            service_costs.tot_annual_service_sum = 0;

            for(k = 0; k < all_service_drivers.length; k ++) {
                var my_service_driver = all_service_drivers[k];
                var my_s_total = 0;

                for(i = 0; i < num_studies; i ++){
                    var this_s_study = current_study_data.study_data[i];
                    var services = this_s_study.services;
                    var num_services = services.length;

                    for(j = 0; j < num_services; j++){
                        var this_ser = services[j];
                        var service_driver = this_ser.item_desc;
                        var one_val_count = parseFloat(this_ser.one_value_count);

                        if (service_driver === my_service_driver) {
                            my_s_total += one_val_count;
                        }else {
                            my_s_total += 0;
                        }
                    }
                }

                service_costs.service_value.push(my_s_total);
                var this_annual_service = 0;

                if(my_s_total === 0) {
                    service_costs.tot_annual_service.push(0);
                }else {
                    this_annual_service =  (cat1_costs.tot_annualised_sum) / (service_costs.service_value[service_costs.service_value.length - 1]);
                    service_costs.tot_annual_service.push(this_annual_service);
                }
            }

            for(i = 0; i < service_costs.tot_annual_service.length; i++) {
                service_costs.tot_annual_service_sum += service_costs.tot_annual_service[i];
            }

            // datapoint table
            //-----------------
            // Destroy the datatables if necessary
            if ( $.fn.DataTable.isDataTable('#datapoint_detail_table') ) {
                $('#datapoint_detail_table').DataTable().destroy();
            }
            // Empty the body of the table
            $('#datapoint_detail_table tbody').empty();
            // get the new body of the table and append it
            var datapoint_detail_table_html_body = get_datapoint_detail_table_body();
            $('#datapoint_detail_table > tbody:last').append(datapoint_detail_table_html_body);
            // Reattach the datatables functionality
            $("#datapoint_detail_table").dataTable(datapoint_table_def);

            // We only want the datapoint table showing data
            // So don't draw the summary tables here, but clear their data from previous datapoints
            $('#cat1_summary_table tbody').empty();
            $('#cat2_summary_table tbody').empty();
            $('#services_summary_table tbody').empty();
            /*
            // Cat1 table
            //-----------------
            //var cat1_table_html = get_cat1_summary_table();
            //$('#cat1_summary_table').html(cat1_table_html);
            //$('#cat1_summary_table').DataTable().draw();

            // Destroy the datatables if necessary
            if ( $.fn.DataTable.isDataTable('#cat1_summary_table') ) {
                $('#cat1_summary_table').DataTable().destroy();
            }
            // Empty the body of the table
            $('#cat1_summary_table tbody').empty();
            // get the new body of the table and append it
            var cat1_table_html_body = get_cat1_summary_table_body();
            $('#cat1_summary_table > tbody:last').append(cat1_table_html_body);
            // Reattach the datatables functionality
            $("#cat1_summary_table").dataTable(cats_table_def);


            // Cat 2table
            //-----------------
            //var cat2_table_html = get_cat2_summary_table();
            //$('#cat2_summary_table').html(cat2_table_html);
            //$('#cat2_summary_table').DataTable().draw();

            // Destroy the datatables if necessary
            if ( $.fn.DataTable.isDataTable('#cat2_summary_table') ) {
                $('#cat2_summary_table').DataTable().destroy();
            }
            // Empty the body of the table
            $('#cat2_summary_table tbody').empty();
            // get the new body of the table and append it
            var cat2_table_html_body = get_cat2_summary_table_body();
            $('#cat2_summary_table > tbody:last').append(cat2_table_html_body);
            // Reattach the datatables functionality
            $("#cat2_summary_table").dataTable(cats_table_def);

            // Services table
            //-----------------
            //var services_table_html = get_services_summary_table();
            //$('#services_summary_table').html(services_table_html);
            
            // Destroy the datatables if necessary
            if ( $.fn.DataTable.isDataTable('#services_summary_table') ) {
                $('#services_summary_table').DataTable().destroy();
            }
            // Empty the body of the table
            $('#services_summary_table tbody').empty();
            // get the new body of the table and append it
            var services_table_html_body = get_services_summary_table_body();
            $('#services_summary_table > tbody:last').append(services_table_html_body);
            // Reattach the datatables functionality
            $("#services_summary_table").dataTable(services_table_def);
            */
        }
    }

    /**
     * Returns number with thousand separators or if number is 0 replaces it with a -.
     *
     * @param {number} num The number that needs to be reformatted.
     * @return {string} A string of the number in the new format.
     */
    function formatThousandNumber(num) {
        var return_val = "-";
        if(num >= 0.01){
            return_val = num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
        }
        return return_val;
    }

    /**
     * Adds currency symbol and thousand separators to number.
     *
     * @param {number} num The number that needs to be reformatted.
     * @return {string} A string of the number in the new format.
     */
    function currencyThousandFormat(num) {
        return '$' + num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }
});