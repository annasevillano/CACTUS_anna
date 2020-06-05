var all_datapoint_data = null;
var current_study_data = null;
var ppp_array = null;
var cpi_array = null;

var cost_type2_costs = {capex: [], opex: [], tot_capex_annualised: [], tot_opex_annualised: [], tot_annualised: [], tot_annualised_sum: 0 };
var category1_costs = {capex: [], opex: [], tot_capex_annualised: [], tot_opex_annualised: [], tot_annualised: [], tot_annualised_sum: 0 };
var category2_costs = {capex: [], opex: [], tot_capex_annualised: [], tot_opex_annualised: [], tot_annualised: [], tot_annualised_sum: 0 };
var category3_costs = {capex: [], opex: [], tot_capex_annualised: [], tot_opex_annualised: [], tot_annualised: [], tot_annualised_sum: 0 };
var services_costs = {service_value: [], tot_annual_service: []};

var target_year = "2016";
var OPEX_lifetime = 40;
var discount_rate_global = 0.05;

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
    "Manual (no specialised equipment)",
    "Human-powered with specialised equipment",
    "Machine powered",
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
    "Wheels - human-powered (transport only)",
    "Wheels - machine-powered (transport only)",
    "Wheels - human- and/or machine-powered with transfer station (transport only)",
    "Passive aerobic waste water",
    "Machine-powered aerobic waste water",
    "Anaerobic wastewater",
    "Aerobic FSM",
    "Anaerobic FSM"
];
var all_new_element_components = [
    {
    name: "Containment",
    categories : [
        "Direct",
        "Sealed tank (no outlet)",
        "Sealed tank (with outlet)",
        "Infiltrating pit",
        "Container"
        ]
    },
    {
    name: "Emptying",
    categories: [
        "Manual (no specialised equipment)",
        "Human-powered with specialised equipment",
        "Machine powered"
        ]
    },
    {
    name: "Emptying and Transport",
    categories : [
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
        "Wheels - human- and/or machine-powered with transfer station"
        ]
    },
    {
    name: "Transport",
    categories : [
        "Wheels - human-powered (transport only)",
        "Wheels - machine-powered (transport only)",
        "Wheels - human- and/or machine-powered with transfer station (transport only)"
        ]
    },
    {
    name: "Treatment",
    categories : [
        "Passive aerobic waste water",
        "Machine-powered aerobic waste water",
        "Anaerobic wastewater",
        "Aerobic FSM",
        "Anaerobic FSM"
        ]
    }
];
var all_cost_type1 = [
    "CAPEX",
    "OPEX"
];
var all_cost_type2 = [
    "Direct - Variable",
    "Direct - Fix",
    "Indirect - Variable",
    "Indirect - Fix"
];
var all_category1 = [
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
var all_category2 = [
    "Utilities",
    "Fuel",
    "Chemicals",
    "Services",
    "Other Consumables"
];
var all_category3 = [
    "Consulting/Advisory",
    "Legal",
    "Insurance",
    "Regular Maintenance",
    "Other Services"
];
var all_service_drivers = [
    "People Served",
    "Households Served",
    "Number of People per Household"
];

var function_return_value; // A global general value to use for many things

//$(document).ready(function () {


    /**
     * Creates two arrays.
     * One with all the data about PPP in different countries in different years and one with all that data about CPI.
     */
    function get_cpi_ppp_arrays() {
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

    function get_cactus_data(){
        $.ajax({
            type: 'post',
            url: 'fetch_datapoints_data_from_db.php',
            async: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (mydata) {
                // ajax success callback
                //console.log(mydata);
                all_datapoint_data = mydata;

                var push_to_db_flag = 0;
                calc_all_datapoints(push_to_db_flag);
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
    function adjust_value2(source_value, source_country_code, source_year, this_target_year) {
        // Does the adjust calc but usig the arrays
        // source country code gives country code of currency used
        // Check we have the data in the array, if not go an get it (this is very slow)
        if (cpi_array === null || ppp_array === null) {
            get_cpi_ppp_arrays();
        }

        var value_adjusted = null;

        var ppp_years = ppp_array[source_country_code];
        var ppp_target = ppp_array[source_country_code][this_target_year];
        var cpi_origin = cpi_array[source_country_code][source_year];
        var cpi_target = cpi_array[source_country_code][this_target_year];

        if (ppp_target < 0 || cpi_origin < 0 || cpi_target < 0) {
            return value_adjusted;
        }

        var denom = ppp_target * cpi_origin;
        if (Math.abs(denom) > 0.00001) {
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
    function Annualise(value, serviceLife, actuationRate) {
        value = parseFloat(value);
        serviceLife = parseFloat(serviceLife);
        actuationRate = parseFloat(actuationRate);
        var compound = Math.pow(1 + actuationRate, serviceLife);
        var value_annualised = null;

        value_annualised = value * actuationRate * (compound / (compound - 1));

        function_return_value = value_annualised;
        return value_annualised;
    }

    function process_current_datapoint2(datapoint_data) {
        var resources = datapoint_data.resources;
        var services = datapoint_data.services;
        var master = datapoint_data.master;
        var results = datapoint_data.results;

        // clear capex and opex arrays
        cost_type2_costs.capex = [];
        cost_type2_costs.opex = [];
        cost_type2_costs.tot_capex_annualised = [];
        cost_type2_costs.tot_opex_annualised = [];
        cost_type2_costs.tot_annualised = [];
        cost_type2_costs.tot_annualised_sum = 0;
        category1_costs.capex = [];
        category1_costs.opex = [];
        category1_costs.tot_capex_annualised = [];
        category1_costs.tot_opex_annualised = [];
        category1_costs.tot_annualised = [];
        category1_costs.tot_annualised_sum = 0;
        category2_costs.capex = [];
        category2_costs.opex = [];
        category2_costs.tot_capex_annualised = [];
        category2_costs.tot_opex_annualised = [];
        category2_costs.tot_annualised = [];
        category2_costs.tot_annualised_sum = 0;
        category3_costs.capex = [];
        category3_costs.opex = [];
        category3_costs.tot_capex_annualised = [];
        category3_costs.tot_opex_annualised = [];
        category3_costs.tot_annualised = [];
        category3_costs.tot_annualised_sum = 0;

        for (var k = 0; k < all_cost_type1.length; k++) {
            var my_cost_type1 = all_cost_type1[k]; //CAPEX or OPEX

            // Cost Type 2
            for (var m = 0; m < all_cost_type2.length; m++) {
                var my_cost_type2 = all_cost_type2[m];  // a Category 1
                var my_total = 0;
                var my_total_annual = 0;
                var num_resources = resources.length;

                for (var j = 0; j < num_resources; j++) {
                    var this_res = resources[j];
                    var cost_type2 = this_res.cost_type_2;
                    var cost_type1 = this_res.cost_type_1; // CAPEX or OPEX
                    var one_val_cost = this_res.one_value_cost;
                    var adjusted_val;

                    if (one_val_cost > 0.001) {
                        var currency_country_code = this_res.currency;
                        if (currency_country_code === "") {
                            currency_country_code = this_res.country_code;
                        }
                        adjusted_val = adjust_value2(one_val_cost, currency_country_code, this_res.year_cost, target_year);
                    } else {
                        adjusted_val = 0;
                    }

                    if (cost_type2 === my_cost_type2 && cost_type1 === my_cost_type1) {
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
                if (my_cost_type1 === "CAPEX") {
                    cost_type2_costs.capex.push(my_total);
                    cost_type2_costs.tot_capex_annualised.push(my_total_annual);
                } else {
                    cost_type2_costs.opex.push(my_total);
                }
            }

            // Category 1
            for (m = 0; m < all_category1.length; m++) {
                var my_cat1 = all_category1[m];
                var my_total1 = 0;
                var my_total_annual1 = 0;
                var num_resources1 = resources.length;

                for (j = 0; j < num_resources1; j++) {
                    var this_res1 = resources[j];
                    var cat_1 = this_res1.category_1;
                    var cost_type1 = this_res1.cost_type_1;
                    var one_val_cost1 = this_res1.one_value_cost;
                    var adjusted_val1;

                    if (one_val_cost1 > 0.001) {
                        var currency_country_code1 = this_res1.currency;
                        if (currency_country_code1 === "") {
                            currency_country_code1 = this_res1.country_code;
                        }
                        adjusted_val1 = adjust_value2(one_val_cost1, currency_country_code1, this_res1.year_cost, target_year);
                    } else {
                        adjusted_val1 = 0;
                    }

                    if (cat_1 === my_cat1 && cost_type1 === my_cost_type1) {
                        my_total1 += adjusted_val1;
                        var annualised_val1;
                        // if it has a lifetime it should be a CAPEX
                        if (this_res1.lifetime > 0) {
                            annualised_val1 = Annualise(adjusted_val1, this_res1.lifetime, this_res1.discount_rate);
                            my_total_annual1 += annualised_val1;
                        } else {
                            annualised_val1 = 0;
                            my_total_annual1 += annualised_val1;
                        }
                    }
                }
                if (my_cost_type1 === "CAPEX") {
                    category1_costs.capex.push(my_total1);
                    category1_costs.tot_capex_annualised.push(my_total_annual1);
                } else {
                    category1_costs.opex.push(my_total1);
                }
            }

            // Category 2
            for (m = 0; m < all_category2.length; m++) {
                var my_cat2 = all_category2[m];
                var my_total2 = 0;
                var num_resources2 = resources.length;

                for (j = 0; j < num_resources2; j++) {
                    var this_res2 = resources[j];

                    if (this_res2.category_1 === "Consumables") {
                        var cat_2 = this_res2.category_2;
                        var cost_type1 = this_res2.cost_type_1;
                        var one_val_cost2 = this_res2.one_value_cost;
                        var adjusted_val2;

                        if (one_val_cost2 > 0.001) {
                            var currency_country_code2 = this_res2.currency;
                            if (currency_country_code2 === "") {
                                currency_country_code2 = this_res2.country_code;
                            }
                            adjusted_val2 = adjust_value2(one_val_cost2, currency_country_code2, this_res2.year_cost, target_year);
                        } else {
                            adjusted_val2 = 0;
                        }
                        if (cat_2 === my_cat2 && cost_type1 === my_cost_type1) {
                            my_total2 += adjusted_val2;
                        }

                    } else {
                        my_total2 += 0;
                    }
                }

                if (my_cost_type1 === "CAPEX") {
                    category2_costs.capex.push(my_total2); // 0
                    category2_costs.tot_capex_annualised.push(0);
                } else {
                    category2_costs.opex.push(my_total2);
                }
            }

            // Category 3
            for (m = 0; m < all_category3.length; m++) {
                var my_cat3 = all_category3[m];
                var my_total3 = 0;
                var num_resources3 = resources.length;

                for (j = 0; j < num_resources3; j++) {
                    var this_res3 = resources[j];
                    if (this_res3.category_1 === "Consumables") {
                        if (this_res3.category_2 === "Services") {
                            var cat_3 = this_res3.category_3;
                            var cost_type1 = this_res3.cost_type_1;
                            var one_val_cost3 = this_res3.one_value_cost;
                            var adjusted_val3;

                            if (one_val_cost3 > 0.001) {
                                var currency_country_code3 = this_res3.currency;
                                if (currency_country_code3 === "") {
                                    currency_country_code3 = this_res3.country_code;
                                }
                                adjusted_val3 = adjust_value2(one_val_cost3, currency_country_code3, this_res3.year_cost, target_year);
                            } else {
                                adjusted_val3 = 0;
                            }
                            if (cat_3 === my_cat3 && cost_type1 === my_cost_type1) {
                                my_total3 += adjusted_val3;
                            }

                        } else {
                            my_total3 += 0;
                        }
                    } else {
                        my_total3 += 0;
                    }
                }

                if (my_cost_type1 === "CAPEX") {
                    category3_costs.capex.push(my_total3); // 0
                    category3_costs.tot_capex_annualised.push(0);
                } else {
                    category3_costs.opex.push(my_total3);
                }
            }
        }

        // Adds total annualised OPEX value to the annualised CAPEX values
        // Sums all complete annualised values
        for (var i = 0; i < cost_type2_costs.tot_capex_annualised.length; i++) {
            var total_opex_adjusted = cost_type2_costs.opex[i];
            cost_type2_costs.tot_opex_annualised[i] = total_opex_adjusted;//Annualise(total_opex_adjusted, OPEX_lifetime, discount_rate_global);

            cost_type2_costs.tot_annualised[i] = cost_type2_costs.tot_capex_annualised[i] + cost_type2_costs.tot_opex_annualised[i];
            cost_type2_costs.tot_annualised_sum += cost_type2_costs.tot_annualised[i];
        }
        for (i = 0; i < category1_costs.tot_capex_annualised.length; i++) {
            var total_opex_adjusted1 = category1_costs.opex[i];
            category1_costs.tot_opex_annualised[i] = total_opex_adjusted1;//Annualise(total_opex_adjusted1, OPEX_lifetime, discount_rate_global);

            category1_costs.tot_annualised[i] = category1_costs.tot_capex_annualised[i] + category1_costs.tot_opex_annualised[i];
            category1_costs.tot_annualised_sum += category1_costs.tot_annualised[i];
        }
        for (i = 0; i < category2_costs.tot_capex_annualised.length; i++) {
            var total_opex_adjusted2 = category2_costs.opex[i];
            category2_costs.tot_opex_annualised[i] = total_opex_adjusted2;//Annualise(total_opex_adjusted2, OPEX_lifetime, discount_rate_global);

            category2_costs.tot_annualised[i] = category2_costs.tot_capex_annualised[i] + category2_costs.tot_opex_annualised[i];
            category2_costs.tot_annualised_sum += category2_costs.tot_annualised[i];
        }
        for (i = 0; i < category3_costs.tot_capex_annualised.length; i++) {
            var total_opex_adjusted3 = category3_costs.opex[i];
            category3_costs.tot_opex_annualised[i] = total_opex_adjusted3;//Annualise(total_opex_adjusted3, OPEX_lifetime, discount_rate_global);

            category3_costs.tot_annualised[i] = category3_costs.tot_capex_annualised[i] + category3_costs.tot_opex_annualised[i];
            category3_costs.tot_annualised_sum += category3_costs.tot_annualised[i];
        }

        // Services
        services_costs.service_value = [];
        services_costs.tot_annual_service = [];

        for (k = 0; k < all_service_drivers.length; k++) {
            var my_service_driver = all_service_drivers[k];
            var my_s_total = 0;
            var num_services = services.length;

            for (j = 0; j < num_services; j++) {
                var this_ser = services[j];
                var service_driver = this_ser.service_category;
                var one_val_count = parseFloat(this_ser.one_value_cost);

                if (service_driver === my_service_driver) {
                    my_s_total += one_val_count;
                } else {
                    my_s_total += 0;
                }
            }
            services_costs.service_value.push(my_s_total);
            var this_annual_service = 0;

            if (my_s_total === 0) {
                services_costs.tot_annual_service.push(0);
            } else {
                this_annual_service = (cost_type2_costs.tot_annualised_sum) / (services_costs.service_value[services_costs.service_value.length - 1]);
                services_costs.tot_annual_service.push(this_annual_service);
            }
        }

        // PAS:
        // These two calls should be done after ALL of the datapoints have been updated
        // Or in a routine that does them all
        // They are useful here to check that they work on individual datapoints
        //---------------------------------------------------
        // Update calculation data in global variables
        store_global_results_data(master.datapoint_id);
    }

    function calc_all_datapoints(push_to_db_flag){
        for(var i = 0; i < all_datapoint_data.study_data.length; i++){
            var datapoint_data = all_datapoint_data.study_data[i];
            process_current_datapoint2(datapoint_data);
        }
        // Push to the database if necessary (i.e. not if already in the db)
        // use the first datapoint
        if(all_datapoint_data.study_data[0].results.total_cost.no_data_flag == 1){
            if(push_to_db_flag == 1){
                push_results_data_to_db();
            }
        }
    }

    function store_global_results_data(datapoint_id){
        // Currently this is only part done
        // TODO
        //-----------------------------------
        // Puts the calculation data into the all_datapoint_data structure
        var i = datapoint_id;
        // Cat 1
        // The array of results is in this order
        /*  [0] "Land",
            [1] "Infrastructure and Buildings",
            [2] "Equipment",
            [3] "Major and Extraordinary Repairs",
            [4] "Staff Development",
            [5] "Other CAPEX",
            [6] "Staffing",
            [7] "Consumables",
            [8] "Other OPEX",
            [9] "Administrative Charges",
            [10] "Financing",
            [11] "Taxes"
            */
        // all_datapoints_data
        all_datapoint_data.study_data[i].results.total_cost.capex_land = category1_costs.capex[0];
        all_datapoint_data.study_data[i].results.total_cost.capex_infrastructure = category1_costs.capex[1];
        all_datapoint_data.study_data[i].results.total_cost.capex_equipment = category1_costs.capex[2];
        all_datapoint_data.study_data[i].results.total_cost.capex_extraordinary = category1_costs.capex[3];
        all_datapoint_data.study_data[i].results.total_cost.capex_staff_develop = category1_costs.capex[4];
        all_datapoint_data.study_data[i].results.total_cost.capex_other = category1_costs.capex[5];
        all_datapoint_data.study_data[i].results.total_cost.capex_administration = category1_costs.capex[9];
        all_datapoint_data.study_data[i].results.total_cost.capex_finance = category1_costs.capex[10];
        all_datapoint_data.study_data[i].results.total_cost.capex_taxes = category1_costs.capex[11];
        all_datapoint_data.study_data[i].results.total_cost.opex_land = category1_costs.opex[0];
        all_datapoint_data.study_data[i].results.total_cost.opex_infrastructure = category1_costs.opex[1];
        all_datapoint_data.study_data[i].results.total_cost.opex_equipment = category1_costs.opex[2];
        all_datapoint_data.study_data[i].results.total_cost.opex_staff = category1_costs.opex[6];
        all_datapoint_data.study_data[i].results.total_cost.opex_staff_develop = category1_costs.opex[4]; // TODO done
        all_datapoint_data.study_data[i].results.total_cost.opex_consumables_utilities = category2_costs.opex[0];
        all_datapoint_data.study_data[i].results.total_cost.opex_consumables_fuel = category2_costs.opex[1];
        all_datapoint_data.study_data[i].results.total_cost.opex_consumables_chemicals = category2_costs.opex[2];
        all_datapoint_data.study_data[i].results.total_cost.opex_consumables_other = category2_costs.opex[4];
        all_datapoint_data.study_data[i].results.total_cost.opex_consumables_service_consultant = category3_costs.opex[0];
        all_datapoint_data.study_data[i].results.total_cost.opex_consumables_service_legal = category3_costs.opex[1];
        all_datapoint_data.study_data[i].results.total_cost.opex_consumables_service_insurance = category3_costs.opex[2];
        all_datapoint_data.study_data[i].results.total_cost.opex_consumables_service_maint = category3_costs.opex[3];
        all_datapoint_data.study_data[i].results.total_cost.opex_consumables_service_other = category3_costs.opex[4];
        all_datapoint_data.study_data[i].results.total_cost.opex_other = category1_costs.opex[8];
        all_datapoint_data.study_data[i].results.total_cost.opex_administration = category1_costs.opex[9];
        all_datapoint_data.study_data[i].results.total_cost.opex_finance = category1_costs.opex[10];
        all_datapoint_data.study_data[i].results.total_cost.opex_taxes = category1_costs.opex[11];

        var datapoint = all_datapoint_data.study_data[i].results.total_cost;

        //TODO
        all_datapoint_data.study_data[i].results.total_cost.opex_all_consumables = datapoint.opex_consumables_utilities +
            datapoint.opex_consumables_fuel + datapoint.opex_consumables_chemicals +
            datapoint.opex_consumables_other + datapoint.opex_consumables_service_consultant +
            datapoint.opex_consumables_service_legal + datapoint.opex_consumables_service_insurance +
            datapoint.opex_consumables_service_maint + datapoint.opex_consumables_service_other;
        //TODO
        all_datapoint_data.study_data[i].results.total_cost.opex_all_services = datapoint.opex_consumables_service_consultant +
            datapoint.opex_consumables_service_legal + datapoint.opex_consumables_service_insurance +
            datapoint.opex_consumables_service_maint + datapoint.opex_consumables_service_other;

        //TODO
        all_datapoint_data.study_data[i].results.total_cost.total_capex_cost = datapoint.capex_land +
            datapoint.capex_infrastructure + datapoint.capex_equipment +
            datapoint.capex_extraordinary + datapoint.capex_staff_develop +
            datapoint.capex_other + datapoint.capex_administration +
            datapoint.capex_finance + datapoint.capex_taxes;
        //TODO
        all_datapoint_data.study_data[i].results.total_cost.total_opex_cost = datapoint.opex_land +
            datapoint.opex_infrastructure + datapoint.opex_equipment +
            datapoint.opex_staff_develop + datapoint.opex_staff +
            datapoint.opex_other + datapoint.opex_administration +
            datapoint.opex_finance + datapoint.opex_taxes +
            datapoint.opex_all_consumables;
        //TODO
        all_datapoint_data.study_data[i].results.total_cost.total_cost = datapoint.total_capex_cost + datapoint.total_opex_cost;


        // Cat 1 Annulaised
        all_datapoint_data.study_data[i].results.annualised_cost.capex_land = category1_costs.tot_capex_annualised[0];
        all_datapoint_data.study_data[i].results.annualised_cost.capex_infrastructure = category1_costs.tot_capex_annualised[1];
        all_datapoint_data.study_data[i].results.annualised_cost.capex_equipment = category1_costs.tot_capex_annualised[2];
        all_datapoint_data.study_data[i].results.annualised_cost.capex_extraordinary = category1_costs.tot_capex_annualised[3];
        all_datapoint_data.study_data[i].results.annualised_cost.capex_staff_develop = category1_costs.tot_capex_annualised[4];
        all_datapoint_data.study_data[i].results.annualised_cost.capex_other = category1_costs.tot_capex_annualised[5];
        all_datapoint_data.study_data[i].results.annualised_cost.capex_administration = category1_costs.tot_capex_annualised[9];
        all_datapoint_data.study_data[i].results.annualised_cost.capex_finance = category1_costs.tot_capex_annualised[10];
        all_datapoint_data.study_data[i].results.annualised_cost.capex_taxes = category1_costs.tot_capex_annualised[11];
        all_datapoint_data.study_data[i].results.annualised_cost.opex_land = category1_costs.tot_opex_annualised[0];
        all_datapoint_data.study_data[i].results.annualised_cost.opex_infrastructure = category1_costs.tot_opex_annualised[1];
        all_datapoint_data.study_data[i].results.annualised_cost.opex_equipment = category1_costs.tot_opex_annualised[2];
        all_datapoint_data.study_data[i].results.annualised_cost.opex_staff = category1_costs.tot_opex_annualised[6];
        all_datapoint_data.study_data[i].results.annualised_cost.opex_staff_develop = category1_costs.tot_opex_annualised[4]; // TODO done
        all_datapoint_data.study_data[i].results.annualised_cost.opex_consumables_utilities = category2_costs.tot_opex_annualised[0];
        all_datapoint_data.study_data[i].results.annualised_cost.opex_consumables_fuel = category2_costs.tot_opex_annualised[1];
        all_datapoint_data.study_data[i].results.annualised_cost.opex_consumables_chemicals = category2_costs.tot_opex_annualised[2];
        all_datapoint_data.study_data[i].results.annualised_cost.opex_consumables_other = category2_costs.tot_opex_annualised[4];
        all_datapoint_data.study_data[i].results.annualised_cost.opex_consumables_service_consultant = category3_costs.tot_opex_annualised[0];
        all_datapoint_data.study_data[i].results.annualised_cost.opex_consumables_service_legal = category3_costs.tot_opex_annualised[1];
        all_datapoint_data.study_data[i].results.annualised_cost.opex_consumables_service_insurance = category3_costs.tot_opex_annualised[2];
        all_datapoint_data.study_data[i].results.annualised_cost.opex_consumables_service_maint = category3_costs.tot_opex_annualised[3];
        all_datapoint_data.study_data[i].results.annualised_cost.opex_consumables_service_other = category3_costs.tot_opex_annualised[4];
        all_datapoint_data.study_data[i].results.annualised_cost.opex_other = category1_costs.tot_opex_annualised[8];
        all_datapoint_data.study_data[i].results.annualised_cost.opex_administration = category1_costs.tot_opex_annualised[9];
        all_datapoint_data.study_data[i].results.annualised_cost.opex_finance = category1_costs.tot_opex_annualised[10];
        all_datapoint_data.study_data[i].results.annualised_cost.opex_taxes = category1_costs.tot_opex_annualised[11];

        var datapoint = all_datapoint_data.study_data[i].results.annualised_cost;

        //TODO
        all_datapoint_data.study_data[i].results.annualised_cost.opex_all_consumables = datapoint.opex_consumables_utilities +
            datapoint.opex_consumables_fuel + datapoint.opex_consumables_chemicals +
            datapoint.opex_consumables_other + datapoint.opex_consumables_service_consultant +
            datapoint.opex_consumables_service_legal + datapoint.opex_consumables_service_insurance +
            datapoint.opex_consumables_service_maint + datapoint.opex_consumables_service_other;
        //TODO
        all_datapoint_data.study_data[i].results.annualised_cost.opex_all_services = datapoint.opex_consumables_service_consultant +
            datapoint.opex_consumables_service_legal + datapoint.opex_consumables_service_insurance +
            datapoint.opex_consumables_service_maint + datapoint.opex_consumables_service_other;

        //TODO
        all_datapoint_data.study_data[i].results.annualised_cost.total_capex_cost = datapoint.capex_land +
            datapoint.capex_infrastructure + datapoint.capex_equipment +
            datapoint.capex_extraordinary + datapoint.capex_staff_develop +
            datapoint.capex_other + datapoint.capex_administration +
            datapoint.capex_finance + datapoint.capex_taxes;
        //TODO
        all_datapoint_data.study_data[i].results.annualised_cost.total_opex_cost = datapoint.opex_land +
            datapoint.opex_infrastructure + datapoint.opex_equipment +
            datapoint.opex_staff_develop + datapoint.opex_staff +
            datapoint.opex_other + datapoint.opex_administration +
            datapoint.opex_finance + datapoint.opex_taxes +
            datapoint.opex_all_consumables;
        //TODO
        all_datapoint_data.study_data[i].results.annualised_cost.total_cost = datapoint.total_capex_cost + datapoint.total_opex_cost;
        //TODO
        all_datapoint_data.study_data[i].results.annualised_cost.tot_annualised_sum = category1_costs.tot_annualised_sum;

        // Cost 2 types
        all_datapoint_data.study_data[i].results.cost_type_cost.capex_direct_variable = cost_type2_costs.capex[0];
        all_datapoint_data.study_data[i].results.cost_type_cost.capex_direct_fixed = cost_type2_costs.capex[1];
        all_datapoint_data.study_data[i].results.cost_type_cost.capex_indirect_variable = cost_type2_costs.capex[2];
        all_datapoint_data.study_data[i].results.cost_type_cost.capex_indirect_fixed = cost_type2_costs.capex[3];
        all_datapoint_data.study_data[i].results.cost_type_cost.opex_direct_variable = cost_type2_costs.opex[0];
        all_datapoint_data.study_data[i].results.cost_type_cost.opex_direct_fixed = cost_type2_costs.opex[1];
        all_datapoint_data.study_data[i].results.cost_type_cost.opex_indirect_variable = cost_type2_costs.opex[2];
        all_datapoint_data.study_data[i].results.cost_type_cost.opex_indirect_fixed = cost_type2_costs.opex[3];
        all_datapoint_data.study_data[i].results.cost_type_cost.total_direct_variable = cost_type2_costs.tot_annualised[0];
        all_datapoint_data.study_data[i].results.cost_type_cost.total_direct_fixed = cost_type2_costs.tot_annualised[1];
        all_datapoint_data.study_data[i].results.cost_type_cost.total_indirect_variable = cost_type2_costs.tot_annualised[2];
        all_datapoint_data.study_data[i].results.cost_type_cost.total_indirect_fixed = cost_type2_costs.tot_annualised[3];
        all_datapoint_data.study_data[i].results.cost_type_cost.total = cost_type2_costs.tot_annualised_sum;

        // The service data and totals that are in the master section
        all_datapoint_data.study_data[i].master.num_people_served = services_costs.service_value[0];
        all_datapoint_data.study_data[i].master.num_hh_served = services_costs.service_value[1];
        all_datapoint_data.study_data[i].master.num_people_per_hh = services_costs.service_value[2];
        all_datapoint_data.study_data[i].master.tach = 0;
        if (services_costs.service_value[1] > 0.01) {
            all_datapoint_data.study_data[i].master.tach = (cost_type2_costs.tot_annualised_sum) / (services_costs.service_value[1]);
        }
        all_datapoint_data.study_data[i].master.tacc = 0;
        if (services_costs.service_value[0] > 0.01) {
            all_datapoint_data.study_data[i].master.tacc = (cost_type2_costs.tot_annualised_sum) / (services_costs.service_value[0]);
        }
        //TODO
        all_datapoint_data.study_data[i].master.tch = 0;
        if (services_costs.service_value[1] > 0.01) {
            all_datapoint_data.study_data[i].master.tch = (all_datapoint_data.study_data[i].results.total_cost.total_cost) / (services_costs.service_value[1]);
        }
        //TODO
        all_datapoint_data.study_data[i].master.tcc = 0;
        if (services_costs.service_value[0] > 0.01) {
            all_datapoint_data.study_data[i].master.tcc = (all_datapoint_data.study_data[i].results.total_cost.total_cost) / (services_costs.service_value[0]);
        }
    }

    function push_results_data_to_db(){
        // TODO
        var form_data = new FormData();
        form_data.append('all_datapoint_data', JSON.stringify(all_datapoint_data));
        $.ajax({
            type: 'post',
            url: 'push_results_data_to_db.php',
            data: form_data,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (mydata) {
                // reset all arrays
                //console.log(JSON.stringify(mydata));


                // No need to do anything with the returned data
                // It should have all been pushed into the database
                // could inform the user that it has been entered
                if(mydata.success == 1){
                    console.log("Success sending results data to db\n" + mydata.message);
                }

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



//});