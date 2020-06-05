$(document).ready(function () {
   // Load the cactus dat from the database as soon as the page is loaded
    get_cpi_ppp_arrays();
    get_cactus_data();

    /*
    console.log("Got cactus data: There are " + all_datapoint_data.studies.length + " datapoints");
    for(var i = 0 ; i < all_datapoint_data.studies.length; i++){
        console.log(all_datapoint_data.studies[i]);
    }
*/
    populate_component_select_dropdown();
    populate_cities_select_dropdown();
    populate_datapoint_select_dropdown();

    draw_overall_chart($("input[name='tac_radio_overall']:checked").val());

    // Set the on-change event function for the bubble split
    $("input[name='tac_radio_overall']").change(function() {
        event.preventDefault();

        var data_flag = $("input[name='tac_radio_overall']:checked").val();

        draw_overall_chart(data_flag);
    });

    draw_overall_more_chart($("input[name='tac_radio_overall_more']:checked").val(), $("input[name='overall_radio']:checked").val());

    // Set the on-change event function for Total Costs by Component (chart 2)
    $("input[name='tac_radio_overall_more'], input[name='overall_radio']").change(function() {
        event.preventDefault();

        var data_flag = $("input[name='tac_radio_overall_more']:checked").val();
        if(data_flag == "TCH" || data_flag == "TCC"){
            $("input[name='overall_radio'][value='CAPEX']").prop("checked",true);
        }
        var capex_opex_flag = $("input[name='overall_radio']:checked").val();

        draw_overall_more_chart(data_flag, capex_opex_flag);
    });

    draw_component_chart($("#component_select").val(), $("input[name='tac_radio']:checked").val());
    draw_city_chart($("#city_select").val(), $("input[name='tac_radio_city']:checked").val());

    // Set the on-change event function for the component
    $("#component_select, input[name='tac_radio']").change(function() {
        event.preventDefault();

        var component_value = $("#component_select").val();
        var data_flag = $("input[name='tac_radio']:checked").val();

        draw_component_chart(component_value, data_flag);
    });

    // Set the on-change event function for the city
    $("#city_select, input[name='tac_radio_city']").change(function() {
        event.preventDefault();

        var city_value = $("#city_select").val();
        var data_flag = $("input[name='tac_radio_city']:checked").val();

        draw_city_chart(city_value, data_flag);
    });

    draw_bubble_chart($("input[name='tac_radio_bubble']:checked").val(), $("#component_bubble_select").val());
    draw_bubble_split_chart($("input[name='tac_radio_bubble_split']:checked").val());

    // Set the on-change event function for the bubble
    $("input[name='tac_radio_bubble'], #component_bubble_select").change(function() {
        event.preventDefault();

        var data_flag = $("input[name='tac_radio_bubble']:checked").val();
        var component = $("#component_bubble_select").val();

        draw_bubble_chart(data_flag, component);
    });

    // Set the on-change event function for the bubble split
    $("input[name='tac_radio_bubble_split']").change(function() {
        event.preventDefault();

        var data_flag = $("input[name='tac_radio_bubble_split']:checked").val();

        draw_bubble_split_chart(data_flag);
    });

    draw_category_split_chart($("input[name='tac_radio_category_split']:checked").val(), $("input[name='capex_opex_radio']:checked").val());

    // Set the on-change event function for the category split
    $("input[name='tac_radio_category_split'], input[name='capex_opex_radio']").change(function() {
        event.preventDefault();

        var data_flag = $("input[name='tac_radio_category_split']:checked").val();
        var capex_opex = $("input[name='capex_opex_radio']:checked").val();

        draw_category_split_chart(data_flag, capex_opex);
    });

    $('#download_overall_chart_data').on('click', function(event) {
        event.preventDefault(); // To prevent following the link (optional)
        //alert("clicked");
        var filename ="total_annualised_costs_by_component_chart_data.csv";
        var string_body_of_file = overall_chart_data_csv_str;
        download_text_string_as_file(string_body_of_file,filename);
    });
    $('#download_overall_more_chart_data').on('click', function(event) {
        event.preventDefault(); // To prevent following the link (optional)
        //alert("clicked");
        var filename ="total_costs_by_component_chart_data.csv";
        var string_body_of_file = overall_more_chart_data_csv_str;
        download_text_string_as_file(string_body_of_file,filename);
    });



    var elements_chosen = [];
    if ($("#chk_containment").is(':checked')) {elements_chosen.push("Containment");}
    if ($("#chk_emptying").is(':checked')) {elements_chosen.push("Emptying");}
    if ($("#chk_transport").is(':checked')) {elements_chosen.push("Transport");}
    if ($("#chk_emptying_transport").is(':checked')) {elements_chosen.push("Emptying and Transport");}
    if ($("#chk_treatment").is(':checked')) {elements_chosen.push("Treatment");}

    draw_category_split_more_chart($("input[name='tac_radio_split_more']:checked").val(), elements_chosen);

    // Set the on-change event function for the category split
    $("input[name='tac_radio_split_more'], input[name='element_tickboxes']").change(function() {
        event.preventDefault();

        var elements_chosen = [];
        var data_flag = $("input[name='tac_radio_split_more']:checked").val();

        if ($("#chk_containment").is(':checked')) {elements_chosen.push("Containment");}
        if ($("#chk_emptying").is(':checked')) {elements_chosen.push("Emptying");}
        if ($("#chk_transport").is(':checked')) {elements_chosen.push("Transport");}
        if ($("#chk_emptying_transport").is(':checked')) {elements_chosen.push("Emptying and Transport");}
        if ($("#chk_treatment").is(':checked')) {elements_chosen.push("Treatment");}

        draw_category_split_more_chart(data_flag, elements_chosen);
    });

    // 9th charts not used
    //draw_datapoint_split_chart($("#datapoint1_select").val(), $("#datapoint2_select").val(), $("input[name='tac_radio_datapoint_split']:checked").val());

    // Set the on-change event function for the component
    $("#datapoint1_select, #datapoint2_select, input[name='tac_radio_datapoint_split']").change(function() {
        event.preventDefault();

        var datapoint1_value = $("#datapoint1_select").val();
        var datapoint2_value = $("#datapoint2_select").val();
        var data_flag = $("input[name='tac_radio_datapoint_split']:checked").val();

        draw_datapoint_split_chart(datapoint1_value, datapoint2_value, data_flag);
    });

    function populate_component_select_dropdown(){
        // Populates the component dropdown
        var select_options = get_component_select_options();
        $("#component_select").html(select_options);

        var select_bubble_options = "<option value='ALL'>All Components</option>\n";
        select_bubble_options += select_options;
        $("#component_bubble_select").html(select_bubble_options);
    }
    function get_component_select_options(){
        var select_options = "";
        //select_options += "<option >---------------------------</option>\n";
        for(var i = 0; i < all_new_components.length; i++){
            select_options += "<option value='" + all_new_components[i] + "'>" + all_new_components[i] + "</option>\n";
        }
        return select_options;
    }

    function populate_cities_select_dropdown(){
        // Populates the city dropdown
        var select_options = get_city_select_options();
        $("#city_select").html(select_options);
    }
    function get_city_select_options(){
        var select_options = "";
        //select_options += "<option >---------------------------</option>\n";
        var cities_unique = get_unique_cities_list();
        for(var i = 0; i < cities_unique.length; i++){
            select_options += "<option value='" + cities_unique[i] + "'>" + cities_unique[i] + "</option>\n";
        }
        return select_options;
    }
    function get_unique_cities_list(){
        var cities = [];
        for (var i=0; i < all_datapoint_data.study_data.length; i ++) {
            cities.push(all_datapoint_data.study_data[i].master.city);
        }
        cities.sortUnique();
        return cities;
    }

    function populate_datapoint_select_dropdown() {
        // Populates the datapoint dropdown
        var select_options = get_datapoint_select_options();
        $("#datapoint1_select").html(select_options);
        $("#datapoint2_select").html(select_options);
    }
    function get_datapoint_select_options() {
        var select_options = "";
        for(var i = 0; i < all_datapoint_data.study_data.length; i++){
            select_options += "<option value='" + all_datapoint_data.study_data[i].master.datapoint_name + "'>" + all_datapoint_data.study_data[i].master.city + " - " + all_datapoint_data.study_data[i].master.datapoint_name + "</option>\n";
        }
        return select_options;
    }

    // 1
    function draw_overall_chart(data_flag) {
        var base_summary_chart = my_base_summary_chart;
        var tac_type = data_flag;
        var selected_base_data = get_overall_data(tac_type);

        //var chart_xaxis = [];
        //for (var i=0; i < selected_base_data.length; i ++) {
        //    chart_xaxis.push(selected_base_data[i].component_name);
        //}
        //chart_xaxis = get_component_element_axis_labels();
        var chart_xaxis = get_grouped_by_element_axis_data(selected_base_data);

        var  base_data_cat = [];
        for(var i = 0 ; i < chart_xaxis.length ; i++){
            var cat_name = chart_xaxis[i].name;
            for( var j = 0 ; j < chart_xaxis[i].categories.length ; j++){
                base_data_cat.push(cat_name);
            }
        }

        base_summary_chart.title.text = 'CACTUS$ Costing';
        base_summary_chart.subtitle.text = tac_type + ' Range by Component. US$ 2016';
        base_summary_chart.series[0] = {name : tac_type, data : selected_base_data};
        if (tac_type === "TACC") {base_summary_chart.series[0].color = 'tomato';}
        base_summary_chart.xAxis.categories = chart_xaxis;
        base_summary_chart.xAxis.labels.rotation = 90;
        base_summary_chart.xAxis.labels.align = 'left';
        base_summary_chart.yAxis.title.text = tac_type + " (US$ 2016)";
        base_summary_chart.yAxis.max = null;//5000; // lots of data not shown as variation of numbers is too large
        // if count=1 don't show the min value??

        base_summary_chart.tooltip.formatter = function(){
            var text;
            text = '<em>' + this.x + '</em><br />Max: <b>$' + Highcharts.numberFormat(this.point.y,2,'.',',') + '</b><br />Min: <b>$' + Highcharts.numberFormat(this.point.low,2,'.',',') + '</b><br />Count: <b>' + this.point.n + '</b>' ;
            return  text;
        };

        //base_summary_chart.exporting.filename = 'cactus_costing_tach_' + (new Date()).getFullYear();
        // is this necessary?
        if (tac_type === "TACH") {
            base_summary_chart.exporting.filename = 'cactus_costing_tach_' + (new Date()).getFullYear();
        } else {
            base_summary_chart.exporting.filename = 'cactus_costing_tacc_' + (new Date()).getFullYear();
        }


        $('#overall_chart').show();
        $('#overall_chart').highcharts(base_summary_chart);

        //console.log(selected_base_data);
        var sep = '\t';
        sep = ',';
        var c_str = tac_type+ '\n';
        c_str += "component" +  sep +  "lower cost" + sep + "upper cost" + sep + "number" + sep + "category" +'\n';
        var cat_count = 0;
        for (index = 0; index < selected_base_data.length; index++) {
            c_obj = selected_base_data[index];
            c_str += '"' + c_obj.component_name + '"' +  sep +  c_obj.low + sep + c_obj.y + sep + c_obj.n + sep + base_data_cat[index] +'\n';
        }
        //console.log(c_str);
        overall_chart_data_csv_str = c_str;

    }
    // 1
    function get_overall_data(data_flag) {
        var overall_data = new Array();
        var tac_type = data_flag;

        for (var i = 0; i < all_new_components.length; i++) {
            var current_component = all_new_components[i];
            var current_min = 1e10;
            var current_max = -current_min;
            var current_total = 0;
            var count = 0;
            var checker = 0;

            for (var j = 0; j < all_datapoint_data.study_data.length; j++) {
                var this_component = all_datapoint_data.study_data[j].master.component;

                if (this_component === current_component) {

                    if (tac_type === "TACH") {
                        var value = all_datapoint_data.study_data[j].master.tach;
                    } else {
                        var value = all_datapoint_data.study_data[j].master.tacc;
                    }
                    if (value < current_min) {current_min = value;}
                    if (value > current_max) {current_max = value;}
                    current_total += value;
                    count ++;
                }
            }
            // if that component type doesn't exist, hides bar
            if (current_total === 0) {
                current_min = 0;
                current_max = 0;
            }
            // if only one of that component type this makes it more visible
            if (count === 1){
                current_min = current_max - 10;
                if (current_min < 0 ) {current_min = 0}
            }

            var data = {component_name: current_component, low: current_min, y: current_max, n: count};
            overall_data.push(data);
        }
        return overall_data;
    }

    // function get_component_element_axis_labels()
    // {
    //     /*
    //     for(var i = 0 ; i < all_new_element_components.length; i++){
    //         Object.keys(all_new_element_components[i]).forEach(function (element) {
    //             console.log(element); // key (elemenet)
    //             console.log(all_new_element_components[i][element]); // value (component)
    //         });
    //     }
    //     */
    //     return all_new_element_components;
    // }


    // 2
    function draw_overall_more_chart(data_flag, capex_opex_flag) {
        var base_summary_chart = my_base_summary_chart;
        var tac_type = data_flag;
        var cost_type_1 = capex_opex_flag;
        var selected_base_data = get_overall_more_data(tac_type, cost_type_1);

        //var chart_xaxis = [];
        //for (var i=0; i < selected_base_data.length; i ++) {
        //    chart_xaxis.push(selected_base_data[i].component_name);
        //}
        var chart_xaxis = get_grouped_by_element_axis_data(selected_base_data);

        var  base_data_cat = [];
        for(var i = 0 ; i < chart_xaxis.length ; i++){
            var cat_name = chart_xaxis[i].name;
            for( var j = 0 ; j < chart_xaxis[i].categories.length ; j++){
                base_data_cat.push(cat_name);
            }
        }
        base_summary_chart.title.text = 'CACTUS$ Costing';
        base_summary_chart.subtitle.text = 'Cost by component';//tac_type + ' Range by Component. US$ 2016';
        base_summary_chart.series[0] = {name : tac_type, data : selected_base_data};
        if (tac_type === "TACC") {base_summary_chart.series[0].color = 'tomato';}
        if (tac_type === "TCH") {base_summary_chart.series[0].color = 'lime';}
        if (tac_type === "TCC") {base_summary_chart.series[0].color = 'blueviolet';}
        base_summary_chart.xAxis.categories = chart_xaxis;
        base_summary_chart.xAxis.labels.rotation = 90;
        base_summary_chart.xAxis.labels.align = 'left';
        base_summary_chart.yAxis.title.text = tac_type + " (US$ 2016)";
        base_summary_chart.yAxis.max = null;//5000; // lots of data not shown as variation of numbers is too large
        // if count=1 don't show the min value??

        base_summary_chart.tooltip.formatter = function(){
            var text;
            text = '<em>' + this.x + '</em><br />Max: <b>$' + Highcharts.numberFormat(this.point.y,2,'.',',') + '</b><br />Min: <b>$' + Highcharts.numberFormat(this.point.low,2,'.',',') + '</b><br />Count: <b>' + this.point.n + '</b>' ;
            return  text;
        };

        //base_summary_chart.exporting.filename = 'cactus_costing_tach_' + (new Date()).getFullYear();
        // is this necessary?
        if (tac_type === "TACH") {
            base_summary_chart.exporting.filename = 'cactus_costing_tach_' + (new Date()).getFullYear();
        } if (tac_type === "TACC") {
            base_summary_chart.exporting.filename = 'cactus_costing_tacc_' + (new Date()).getFullYear();
        } if (tac_type === "TCH") {
            base_summary_chart.exporting.filename = 'cactus_costing_tch_' + (new Date()).getFullYear();
        } else {
            base_summary_chart.exporting.filename = 'cactus_costing_tcc_' + (new Date()).getFullYear();
        }


        $('#overall_more_chart').show();
        $('#overall_more_chart').highcharts(base_summary_chart);

        //console.log(all_cactus_data);
        //console.log(selected_base_data);
        if(cost_type_1 == 'BOTH'){
            cost_type_1 = 'CAPEX and OPEX';
        }
        var sep = '\t';
        sep = ',';
        var c_str = tac_type + sep + cost_type_1 + '\n';
        c_str += "component" +  sep +  "lower cost" + sep + "upper cost" + sep + "number" + sep + "category" +'\n';
        var cat_count = 0;
        for (index = 0; index < selected_base_data.length; index++) {
            c_obj = selected_base_data[index];
            c_str += '"' + c_obj.component_name + '"' +  sep +  c_obj.low + sep + c_obj.y + sep + c_obj.n + sep + base_data_cat[index] +'\n';
        }
        //console.log(c_str);
        overall_more_chart_data_csv_str = c_str;
    }
    function get_grouped_by_element_axis_data(component_data_arr)
    {
        var element_grouped_axis_arr = [];

        // Loop through all of the elements
        for(var i = 0 ; i <all_elements.length; i++){
            var this_element = all_elements[i];

            var components_in_element = [];
            // gather the components that are in this element
            for(var j = 0 ; j < component_data_arr.length ; j++){
                var this_component_name = component_data_arr[j].component_name;
                if(isComponentInElement(this_element, this_component_name)){
                    components_in_element.push(this_component_name);
                }
            }

            // If one or more components are in this element then it eed to be in the axis
            if(components_in_element.length >= 1){
                var axis_entry = {name: this_element, categories: components_in_element};
                element_grouped_axis_arr.push(axis_entry);
            }
        }

        return element_grouped_axis_arr;
    }

    function isComponentInElement(element_name, component_name){
        // is the component in the element
        // all_new_element_components contains the link of element and conponent

        for(var i = 0 ; i < all_new_element_components.length; i++){
            //console.log(all_new_element_components[i]['name']); // key (elemenet)
            //console.log(all_new_element_components[i]['categories']); // value (component)
            var element = all_new_element_components[i]['name'];

            if(element == element_name){
                var components = all_new_element_components[i]['categories'];
                for(var j = 0 ; j < components.length ; j++){
                    if(components[j] == component_name){
                        return true;
                    }
                }
            }
        }

        return false;
    }

    // 2
    function get_overall_more_data(data_flag, capex_opex_type) {
        var overall_data = new Array();
        var tac_type = data_flag;
        var cost_type_1 = capex_opex_type;

        for (var i = 0; i < all_new_components.length; i++) {
            var current_component = all_new_components[i];
            var current_min = 1e10;
            var current_max = -current_min;
            var current_total = 0;
            var count = 0;
            var checker = 0;

            for (var j = 0; j < all_datapoint_data.study_data.length; j++) {
                var this_component = all_datapoint_data.study_data[j].master.component;

                if (this_component === current_component) {
                    // total cost
                    var total_cost_capex = all_datapoint_data.study_data[j].results.total_cost.total_capex_cost
                    var total_cost_opex = all_datapoint_data.study_data[j].results.total_cost.total_opex_cost;
                     // annualised cost
                    var annualised_cost_capex = all_datapoint_data.study_data[j].results.annualised_cost.total_capex_cost;
                    var annualised_cost_opex = all_datapoint_data.study_data[j].results.annualised_cost.total_opex_cost;
                    // services
                    var num_hh_served = all_datapoint_data.study_data[j].master.num_hh_served;
                    var num_people_served = all_datapoint_data.study_data[j].master.num_people_served;


                    if (cost_type_1 === "CAPEX") {
                        if (tac_type === "TACH") {
                            var value = annualised_cost_capex / num_hh_served;
                        } if (tac_type ==="TACC") {
                            var value = annualised_cost_capex / num_people_served;
                        } if (tac_type === "TCH") {
                            var value = total_cost_capex / num_hh_served;
                        } if (tac_type === "TCC") {
                            var value = total_cost_capex / num_people_served;
                        }
                    } if (cost_type_1 === "OPEX") {
                        if (tac_type === "TACH") {
                            var value = annualised_cost_opex / num_hh_served;
                        } if (tac_type ==="TACC") {
                            var value = annualised_cost_opex / num_people_served;
                        } if (tac_type === "TCH") {
                            var value = total_cost_opex / num_hh_served;
                        } if (tac_type === "TCC") {
                            var value = total_cost_opex / num_people_served;
                        }
                    } if (cost_type_1 === "BOTH") {
                        if (tac_type === "TACH") {
                            var value = all_datapoint_data.study_data[j].master.tach;
                        } if (tac_type ==="TACC") {
                            var value = all_datapoint_data.study_data[j].master.tacc;
                        } if (tac_type === "TCH") {
                            var value = all_datapoint_data.study_data[j].master.tch;
                        } if (tac_type === "TCC") {
                            var value = all_datapoint_data.study_data[j].master.tcc;
                        }
                    }

                    if (value < current_min) {current_min = value;}
                    if (value > current_max) {current_max = value;}
                    current_total += value;
                    count ++;
                }
            }
            // if that component type doesn't exist, hides bar
            if (current_total === 0) {
                current_min = 0;
                current_max = 0;
            }
            // if only one of that component type this makes it more visible
            if (count === 1){
                current_min = current_max - 100;
                if (current_min < 0 ) {current_min = 0}
            }
            if (current_total > 0.0001) {
                var data = {component_name: current_component, low: current_min, y: current_max, n: count};
                overall_data.push(data);
            }
        }
        return overall_data;
    }

    // 3
    function draw_component_chart(component, data_flag) {
        var base_summary_chart = my_base_summary_chart;
        var component_type = component;
        var tac_type = data_flag;
        var selected_base_data = get_component_data(component_type,tac_type);

        var chart_data = [];
        var chart_xaxis = [];
        for (var i=0; i < selected_base_data.length; i ++) {
            if (selected_base_data[i] > 0.001) {
                chart_data.push(selected_base_data[i]);
                var datapoint_name = all_datapoint_data.study_data[i].master.city + " - " + all_datapoint_data.study_data[i].master.datapoint_name;
                //chart_xaxis.push(all_datapoint_data.study_data[i].master.case_description);
                chart_xaxis.push(datapoint_name);
            }
        }

        base_summary_chart.title.text = 'CACTUS$ Costing - Component: ' + component_type;
        base_summary_chart.subtitle.text = tac_type + ' value per case';
        base_summary_chart.series[0] = {name : tac_type, data : chart_data};
        if (tac_type === "TACC") {base_summary_chart.series[0].color = 'tomato';}
        base_summary_chart.xAxis.categories = chart_xaxis;
        base_summary_chart.xAxis.labels.rotation = null;
        base_summary_chart.xAxis.labels.align = 'center';
        base_summary_chart.yAxis.title.text = tac_type + " (US$ 2016)";
        base_summary_chart.yAxis.max = null;

        base_summary_chart.tooltip.formatter = function(){
            var text;
            //text = '<em>' + this.x + '</em><br />Min: <b>$' + this.point.low + '</b><br />Max: <b>$' + Highcharts.numberFormat(this.point.y,2) + '</b><br />Count: <b>' + this.point.n + '</b>' ;
            text = '<em>' + this.x + '</em><br />Value: <b>$' + Highcharts.numberFormat(this.point.y,2,'.',',') + '</b>' ;
            return  text;
        };
        //base_summary_chart.exporting.filename = 'cactus_costing_tach_' + (new Date()).getFullYear();
        // is this necessary?
        if (tac_type === "TACH") {
            base_summary_chart.exporting.filename = 'cactus_costing_tach_' + (new Date()).getFullYear();
        } else {
            base_summary_chart.exporting.filename = 'cactus_costing_tacc_' + (new Date()).getFullYear();
        }

        $('#component_chart').show();
        $('#component_chart').highcharts(base_summary_chart);

        //console.log(all_cactus_data);
    }
    // 3
    function get_component_data(component_type,data_flag) {
        var selected_component = component_type;
        var selected_tac = data_flag;
        var num_datapoints = all_datapoint_data.study_data.length;
        var data_array = [];
        for (var i = 0; i < num_datapoints; i++) {

            var this_comoponent = all_datapoint_data.study_data[i].master.component;
            var comp_counter = 0;
            if (this_comoponent === selected_component) {comp_counter ++;}

            if (comp_counter === 0) {
                data_array.push(0);
            } else {
                if (selected_tac === "TACH") {
                    data_array.push(all_datapoint_data.study_data[i].master.tach);
                } else {
                    data_array.push(all_datapoint_data.study_data[i].master.tacc);
                }
            }
        }
        //console.log(data_array);
        return data_array;
    }

    // 4
    function draw_city_chart(city, data_flag) {
        var base_summary_chart = my_base_summary_chart;
        var city_type = city;
        var tac_type = data_flag;
        var selected_base_data = get_city_data(city_type, tac_type);

        var chart_data = [];
        var chart_xaxis = [];
        for (var i=0; i < selected_base_data.length; i ++) {
            if (selected_base_data[i].y > 0.001) {
                chart_data.push(selected_base_data[i]);
                var datapoint_name = all_datapoint_data.study_data[i].master.datapoint_name;
                //chart_xaxis.push(all_datapoint_data.study_data[i].master.case_description);
                chart_xaxis.push({categories: [datapoint_name], name: selected_base_data[i].element_name});
            }
        }

        base_summary_chart.title.text = 'CACTUS$ Costing - City: ' + city_type;
        base_summary_chart.subtitle.text = null;// tac_type + ' value per case';
        base_summary_chart.series[0] = {name : tac_type, data : chart_data};
        if (tac_type === "TACC") {base_summary_chart.series[0].color = 'tomato';}
        base_summary_chart.xAxis.categories = chart_xaxis;
        base_summary_chart.xAxis.labels.rotation = null;
        base_summary_chart.yAxis.title.text = tac_type + " (US$ 2016)";
        base_summary_chart.yAxis.max = null;

        base_summary_chart.tooltip.formatter = function(){
            var text;
            //text = '<em>' + this.x + '</em><br />Min: <b>$' + this.point.low + '</b><br />Max: <b>$' + Highcharts.numberFormat(this.point.y,2) + '</b><br />Count: <b>' + this.point.n + '</b>' ;
            text = '<em>' + this.x.name + '</em><br> (Component: ' + this.point.component_name + ')<br>' + 'Value: <b>$' + Highcharts.numberFormat(this.point.y,2,'.',',') + '</b>' ;
            return  text;
        };
        // is this necessary?
        if (tac_type === "TACH") {
            base_summary_chart.exporting.filename = 'cactus_costing_tach_' + (new Date()).getFullYear();
        } else {
            base_summary_chart.exporting.filename = 'cactus_costing_tacc_' + (new Date()).getFullYear();
        }

        $('#city_chart').show();
        $('#city_chart').highcharts(base_summary_chart);

        //console.log(all_cactus_data);
    }
    // 4
    function get_city_data(city_type, data_flag) {
        var selected_city = city_type;
        var selected_tac = data_flag;
        var num_datapoints = all_datapoint_data.study_data.length;
        var data_array = [];
        var tac;
        var component;
        var element;
        for (var i = 0; i < num_datapoints; i++) {

            var datapoint_city = all_datapoint_data.study_data[i].master.city;

            if (datapoint_city === selected_city) {
                if (selected_tac === "TACH") {
                    //data_array.push(all_datapoint_data.study_data[i].master.tach);
                    tac = all_datapoint_data.study_data[i].master.tach;
                    component = all_datapoint_data.study_data[i].master.component;
                    element = all_datapoint_data.study_data[i].master.element;
                } else {
                    //data_array.push(all_datapoint_data.study_data[i].master.tacc);
                    tac = all_datapoint_data.study_data[i].master.tacc;
                    component = all_datapoint_data.study_data[i].master.component;
                    element = all_datapoint_data.study_data[i].master.element;
                }
            } else {
                //data_array.push(0);
                component = '';
                element = '';
                tac = 0;
            }
            var data = {component_name: component, element_name: element, y: tac};
            data_array.push(data);

        }
        //console.log(data_array);
        return data_array;
    }

    // 5
    function draw_bubble_chart(data_flag, selected_component) {
        var bubble_base_summary_chart = my_bubble_base_summary_chart;
        var tac_type = data_flag;
        var component_type = selected_component;

        if (component_type === "ALL") {
            var selected_bubble_base_data = get_bubble_data(tac_type);
        } else {
            var selected_bubble_base_data = get_bubble_component_data(tac_type, component_type);
        }
        bubble_base_summary_chart.title.text = 'CACTUS$ Costing';// : Bubble chart (Coloured by Region)';
        bubble_base_summary_chart.subtitle.text = tac_type + ' US$ 2016';
        bubble_base_summary_chart.series = selected_bubble_base_data;
        bubble_base_summary_chart.plotOptions.packedbubble.layoutAlgorithm.splitSeries = false;
        bubble_base_summary_chart.plotOptions.packedbubble.layoutAlgorithm.gravitationalConstant = 0.03;

        bubble_base_summary_chart.tooltip.formatter = function(){
            var text;
            //text = '<em>' + this.x + '</em><br />Min: <b>$' + this.point.low + '</b><br />Max: <b>$' + Highcharts.numberFormat(this.point.y,2) + '</b><br />Count: <b>' + this.point.n + '</b>' ;
            text = '<em>' + this.point.name + '</em><br /><em>' + this.series.name + '</em><br />Value: <b>$' + Highcharts.numberFormat(this.point.y,2,'.',',') + '</b>' ;
            return  text;
        };
        // is this necessary?
        if (tac_type === "TACH") {
            bubble_base_summary_chart.exporting.filename = 'cactus_costing_bubble_tach_' + (new Date()).getFullYear();
        } else {
            bubble_base_summary_chart.exporting.filename = 'cactus_costing_bubble_tacc_' + (new Date()).getFullYear();
        }

        $('#bubble_chart').show();
        $('#bubble_chart').highcharts(bubble_base_summary_chart);

        //console.log(all_cactus_data);
    }
    // 5
    function get_bubble_component_data(data_flag, selected_component){
        var bubble_base_data = new Array();
        var tac_type = data_flag;
        var component_type = selected_component;

        var Australia_and_New_Zealand = new Array();
        var Central_and_Southern_Asia = new Array();
        var Eastern_and_South_Eastern_Asia = new Array();
        var Europe = new Array();
        var Latin_America_and_the_Caribbean = new Array();
        var Northern_Africa_and_Western_Asia = new Array();
        var North_America = new Array();
        var Oceania = new Array();
        var Sub_Saharan_Africa = new Array();

        for(var i = 0; i < all_datapoint_data.study_data.length ; i++){
            var region = all_datapoint_data.study_data[i].master.region;
            var datapoint_name = all_datapoint_data.study_data[i].master.datapoint_name;
            var city = all_datapoint_data.study_data[i].master.city;
            var this_component = all_datapoint_data.study_data[i].master.component;
            var value = 0;
            var visibility = true;
            if (tac_type === "TACH") {
                value = parseFloat(all_datapoint_data.study_data[i].master.tach);
            } else {
                value = parseFloat(all_datapoint_data.study_data[i].master.tacc);
            }

            data = {name: datapoint_name, city: city, value: value};

            if (this_component === component_type) {
                if (region.toUpperCase() == "AUSTRALIA AND NEW ZEALAND") {
                    Australia_and_New_Zealand.push(data);
                }
                if (region.toUpperCase() == "CENTRAL AND SOUTHERN ASIA") {
                    Central_and_Southern_Asia.push(data);
                }
                if (region.toUpperCase() == "EASTERN AND SOUTH-EASTERN ASIA") {
                    Eastern_and_South_Eastern_Asia.push(data);
                }
                if (region.toUpperCase() == "EUROPE") {
                    Europe.push(data);
                }
                if (region.toUpperCase() == "LATIN AMERICA AND THE CARIBBEAN") {
                    Latin_America_and_the_Caribbean.push(data);
                }
                if (region.toUpperCase() == "NORTHERN AFRICA AND WESTERN ASIA") {
                    Northern_Africa_and_Western_Asia.push(data);
                }if (region.toUpperCase() == "NORTH AMERICA") {
                    North_America.push(data);
                }
                if (region.toUpperCase() == "OCEANIA") {
                    Oceania.push(data);
                }
                if (region.toUpperCase() == "SUB-SAHARAN AFRICA") {
                    Sub_Saharan_Africa.push(data);
                }
            }
        }

        if(Australia_and_New_Zealand.length == 0){visibility =  false;}else{visibility = true;}
        data = {name: "Australia and New Zealand", data: Australia_and_New_Zealand, visible: visibility};
        bubble_base_data.push(data);
        if(Central_and_Southern_Asia.length == 0){visibility =  false;}else{visibility = true;}
        data = {name: "Central and Southern Asia", data: Central_and_Southern_Asia, visible: visibility};
        bubble_base_data.push(data);
        if(Eastern_and_South_Eastern_Asia.length == 0){visibility =  false;}else{visibility = true;}
        data = {name: "Eastern and South-Eastern Asia", data: Eastern_and_South_Eastern_Asia, visible: visibility};
        bubble_base_data.push(data);
        if(Europe.length == 0){visibility =  false;}else{visibility = true;}
        data = {name: "Europe", data: Europe, visible: visibility};
        bubble_base_data.push(data);
        if(Latin_America_and_the_Caribbean.length == 0){visibility =  false;}else{visibility = true;}
        data = {name: "Latin America and the Caribbean", data: Latin_America_and_the_Caribbean, visible: visibility};
        bubble_base_data.push(data);
        if(Northern_Africa_and_Western_Asia.length == 0){visibility =  false;}else{visibility = true;}
        data = {name: "Northern Africa and Western Asia", data: Northern_Africa_and_Western_Asia, visible: visibility};
        bubble_base_data.push(data);
        if(North_America.length == 0){visibility =  false;}else{visibility = true;}
        data = {name: "North America", data: North_America, visible: visibility};
        bubble_base_data.push(data);
        if(Oceania.length == 0){visibility =  false;}else{visibility = true;}
        data = {name: "Oceania", data: Oceania, visible: visibility};
        bubble_base_data.push(data);
        if(Sub_Saharan_Africa.length == 0){visibility =  false;}else{visibility = true;}
        data = {name: "Sub-Saharan Africa", data: Sub_Saharan_Africa, visible: visibility};
        bubble_base_data.push(data);

        return bubble_base_data;
    }

    // 6
    function draw_bubble_split_chart(data_flag) {
        var bubble_base_summary_chart = my_bubble_base_summary_chart;
        var tac_type = data_flag;

        var selected_bubble_base_data = get_bubble_data(tac_type);
        bubble_base_summary_chart.title.text = 'CACTUS$ Costing' ;//: Bubble chart (Split by Region)';
        bubble_base_summary_chart.subtitle.text = tac_type + ' US$ 2016';
        bubble_base_summary_chart.series = selected_bubble_base_data;
        bubble_base_summary_chart.plotOptions.packedbubble.layoutAlgorithm.splitSeries = true;
        bubble_base_summary_chart.plotOptions.packedbubble.layoutAlgorithm.gravitationalConstant = 0.02;

        bubble_base_summary_chart.tooltip.formatter = function(){
            var text;
            //text = '<em>' + this.x + '</em><br />Min: <b>$' + this.point.low + '</b><br />Max: <b>$' + Highcharts.numberFormat(this.point.y,2) + '</b><br />Count: <b>' + this.point.n + '</b>' ;
            text = '<em>' + this.point.name + '</em><br /><em>' + this.series.name + '</em><br />Value: <b>$' + Highcharts.numberFormat(this.point.y,2,'.',',') + '</b>' ;
            return  text;
        };

        // is this necessary?
        if (tac_type === "TACH") {
            bubble_base_summary_chart.exporting.filename = 'cactus_costing_bubble_tach_' + (new Date()).getFullYear();
        } else {
            bubble_base_summary_chart.exporting.filename = 'cactus_costing_bubble_tacc_' + (new Date()).getFullYear();
        }

        $('#bubble_split_chart').show();
        $('#bubble_split_chart').highcharts(bubble_base_summary_chart);

        //console.log(all_cactus_data);
    }
    // 5 and 6
    function get_bubble_data(data_flag){
        var bubble_base_data = new Array();
        var tac_type = data_flag;

        var Australia_and_New_Zealand = new Array();
        var Central_and_Southern_Asia = new Array();
        var Eastern_and_South_Eastern_Asia = new Array();
        var Europe = new Array();
        var Latin_America_and_the_Caribbean = new Array();
        var Northern_Africa_and_Western_Asia = new Array();
        var North_America = new Array();
        var Oceania = new Array();
        var Sub_Saharan_Africa = new Array();

        for(var i = 0; i < all_datapoint_data.study_data.length ; i++){
            var region = all_datapoint_data.study_data[i].master.region;
            var datapoint_name = all_datapoint_data.study_data[i].master.datapoint_name;
            var city = all_datapoint_data.study_data[i].master.city;
            var value = 0;
            var visibility = true;
            if (tac_type === "TACH") {
                value = parseFloat(all_datapoint_data.study_data[i].master.tach);
            } else {
                value = parseFloat(all_datapoint_data.study_data[i].master.tacc);
            }

            data = {name: datapoint_name, city: city, value: value};

            if (region.toUpperCase() == "AUSTRALIA AND NEW ZEALAND") {
                Australia_and_New_Zealand.push(data);
            }
            if (region.toUpperCase() == "CENTRAL AND SOUTHERN ASIA") {
                Central_and_Southern_Asia.push(data);
            }
            if (region.toUpperCase() == "EASTERN AND SOUTH-EASTERN ASIA") {
                Eastern_and_South_Eastern_Asia.push(data);
            }
            if (region.toUpperCase() == "EUROPE") {
                Europe.push(data);
            }
            if (region.toUpperCase() == "LATIN AMERICA AND THE CARIBBEAN") {
                Latin_America_and_the_Caribbean.push(data);
            }
            if (region.toUpperCase() == "NORTHERN AFRICA AND WESTERN ASIA") {
                Northern_Africa_and_Western_Asia.push(data);
            }if (region.toUpperCase() == "NORTH AMERICA") {
                North_America.push(data);
            }
            if (region.toUpperCase() == "OCEANIA") {
                Oceania.push(data);
            }
            if (region.toUpperCase() == "SUB-SAHARAN AFRICA") {
                Sub_Saharan_Africa.push(data);
            }
        }

        if(Australia_and_New_Zealand.length == 0){visibility =  false;}else{visibility = true;}
        data = {name: "Australia and New Zealand", data: Australia_and_New_Zealand, visible: visibility};
        bubble_base_data.push(data);
        if(Central_and_Southern_Asia.length == 0){visibility =  false;}else{visibility = true;}
        data = {name: "Central and Southern Asia", data: Central_and_Southern_Asia, visible: visibility};
        bubble_base_data.push(data);
        if(Eastern_and_South_Eastern_Asia.length == 0){visibility =  false;}else{visibility = true;}
        data = {name: "Eastern and South-Eastern Asia", data: Eastern_and_South_Eastern_Asia, visible: visibility};
        bubble_base_data.push(data);
        if(Europe.length == 0){visibility =  false;}else{visibility = true;}
        data = {name: "Europe", data: Europe, visible: visibility};
        bubble_base_data.push(data);
        if(Latin_America_and_the_Caribbean.length == 0){visibility =  false;}else{visibility = true;}
        data = {name: "Latin America and the Caribbean", data: Latin_America_and_the_Caribbean, visible: visibility};
        bubble_base_data.push(data);
        if(Northern_Africa_and_Western_Asia.length == 0){visibility =  false;}else{visibility = true;}
        data = {name: "Northern Africa and Western Asia", data: Northern_Africa_and_Western_Asia, visible: visibility};
        bubble_base_data.push(data);
        if(North_America.length == 0){visibility =  false;}else{visibility = true;}
        data = {name: "North America", data: North_America, visible: visibility};
        bubble_base_data.push(data);
        if(Oceania.length == 0){visibility =  false;}else{visibility = true;}
        data = {name: "Oceania", data: Oceania, visible: visibility};
        bubble_base_data.push(data);
        if(Sub_Saharan_Africa.length == 0){visibility =  false;}else{visibility = true;}
        data = {name: "Sub-Saharan Africa", data: Sub_Saharan_Africa, visible: visibility};
        bubble_base_data.push(data);

        return bubble_base_data;
    }

    // 7
    function draw_category_split_chart(data_flag, capex_opex) {
        var base_summary_chart = my_base_summary_split_chart;
        var tac_type = data_flag;
        var capex_opex_type = capex_opex;
        if (capex_opex_type === "BOTH") {
            var selected_base_data = get_category_split_data(tac_type);
        } else {
            var selected_base_data = get_cost_type_1_split_data(tac_type,capex_opex_type);
        }

        base_summary_chart.title.text = 'CACTUS$ Costing';
        base_summary_chart.subtitle.text = tac_type + ' split by Category for each Case.  US$ 2016';
        base_summary_chart.series = selected_base_data.base_data;
        base_summary_chart.xAxis.categories = selected_base_data.datapoint_name;
        base_summary_chart.xAxis.labels.rotation = 90;
        base_summary_chart.xAxis.labels.align = 'left';
        base_summary_chart.yAxis.title.text = tac_type + " (US$ 2016)";
        base_summary_chart.yAxis.max = null;//2000; // does not all fit
        base_summary_chart.plotOptions.column.dataLabels.enabled = true;
        base_summary_chart.yAxis.stackLabels.enabled = false; // see total
        base_summary_chart.legend.align = 'left';
        base_summary_chart.legend.verticalAlign = 'top';
        base_summary_chart.legend.x = 100;
        base_summary_chart.tooltip.formatter = function(){
            var text;
            text = '<strong>' + this.series.name + '</strong><br /> '+ tac_type +' US$: <b>' + Highcharts.numberFormat(this.point.y,2,'.',',') + '</b><br/> Total: <b>' + Highcharts.numberFormat(this.point.stackTotal,2,'.',',') + '</b>';
            return  text;
        };
        if (tac_type === "TACH") {
            base_summary_chart.exporting.filename = 'cactus_costing_tach_' + (new Date()).getFullYear();
        } else {
            base_summary_chart.exporting.filename = 'cactus_costing_tacc_' + (new Date()).getFullYear();
        }

        $('#category_split_chart').show();
        $('#category_split_chart').highcharts(base_summary_chart);

        //console.log(all_cactus_data);
    }
    // 7
    function get_category_split_data(data_flag){
        var tac_type = data_flag;
        var base_data = new Array();

        var datapoint_names = [];
        // Get list of Case Names
        for (var i = 0; i < all_datapoint_data.study_data.length; i++) {
            datapoint_names.push(all_datapoint_data.study_data[i].master.datapoint_name);
        }

        var Land = [];
        var Infrastructure_and_Buildings = [];
        var Equipment = [];
        var Major_and_Extraordinary_Repairs = [];
        var Staff_Development = [];
        var Other_CAPEX = [];
        var Staffing = [];
        var Consumables = [];
        var Other_OPEX = [];
        var Administrative_Charges = [];
        var Financing = [];
        var Taxes = [];

        for( j = 0 ; j < all_datapoint_data.study_data.length; j++) {
            var current_datapoint = all_datapoint_data.study_data[j];
            var current_datapoint_ac = current_datapoint.results.annualised_cost;

            var tot_land = current_datapoint_ac.capex_land + current_datapoint_ac.opex_land;
            if (tac_type === "TACH") {
                var tac_land = tot_land / current_datapoint.master.num_hh_served;
            } else {
                var tac_land = tot_land / current_datapoint.master.num_people_served;
            }
            if (tac_land < 0.00001) {tac_land = null}
            var data = {y: tac_land};
            Land.push(data);

            var tot_infrastructure = current_datapoint_ac.capex_infrastructure + current_datapoint_ac.opex_infrastructure;
            if (tac_type === "TACH") {
                var tac_infrastructure = tot_infrastructure / current_datapoint.master.num_hh_served;
            } else {
                var tac_infrastructure = tot_infrastructure / current_datapoint.master.num_people_served;
            }
            if (tac_infrastructure < 0.00001) {tac_infrastructure = null}
            data = {y: tac_infrastructure};
            Infrastructure_and_Buildings.push(data);

            var tot_equipment = current_datapoint_ac.capex_equipment + current_datapoint_ac.opex_equipment;
            if (tac_type === "TACH") {
                var tac_equipment = tot_equipment / current_datapoint.master.num_hh_served;
            } else {
                var tac_equipment = tot_equipment / current_datapoint.master.num_people_served;
            }
            if (tac_equipment < 0.00001) {tac_equipment = null}
            data = {y: tac_equipment};
            Equipment.push(data);

            var tot_major_repairs = current_datapoint_ac.capex_extraordinary;
            if (tac_type === "TACH") {
                var tac_major_repairs = tot_major_repairs / current_datapoint.master.num_hh_served;
            } else {
                var tac_major_repairs = tot_major_repairs / current_datapoint.master.num_people_served;
            }
            if (tac_major_repairs < 0.00001) {tac_major_repairs = null}
            data = {y: tac_major_repairs};
            Major_and_Extraordinary_Repairs.push(data);

            var tot_staff_develop = current_datapoint_ac.capex_staff_develop + current_datapoint_ac.opex_staff_develop;
            if (tac_type === "TACH") {
                var tac_staff_develop = tot_staff_develop / current_datapoint.master.num_hh_served;
            } else {
                var tac_staff_develop = tot_staff_develop / current_datapoint.master.num_people_served;
            }
            if (tac_staff_develop < 0.00001) {tac_staff_develop = null}
            data = {y: tac_staff_develop};
            Staff_Development.push(data);

            var tot_other_capex = current_datapoint_ac.capex_other;
            if (tac_type === "TACH") {
                var tac_other_capex = tot_other_capex / current_datapoint.master.num_hh_served;
            } else {
                var tac_other_capex = tot_other_capex / current_datapoint.master.num_people_served;
            }
            if (tac_other_capex < 0.00001) {tac_other_capex = null}
            data = {y: tac_other_capex};
            Other_CAPEX.push(data);

            var tot_staffing = current_datapoint_ac.opex_staff;
            if (tac_type === "TACH") {
                var tac_staffing = tot_staffing / current_datapoint.master.num_hh_served;
            } else {
                var tac_staffing = tot_staffing / current_datapoint.master.num_people_served;
            }
            if (tac_staffing < 0.00001) {tac_staffing = null}
            data = {y: tac_staffing};
            Staffing.push(data);

            var tot_consumables = current_datapoint_ac.opex_all_consumables;
            if (tac_type === "TACH") {
                var tac_consumables = tot_consumables / current_datapoint.master.num_hh_served;
            } else {
                var tac_consumables = tot_consumables / current_datapoint.master.num_people_served;
            }
            if (tac_consumables < 0.00001) {tac_consumables = null}
            data = {y: tac_consumables};
            Consumables.push(data);

            var tot_other_opex = current_datapoint_ac.opex_other;
            if (tac_type === "TACH") {
                var tac_other_opex = tot_other_opex / current_datapoint.master.num_hh_served;
            } else {
                var tac_other_opex = tot_other_opex / current_datapoint.master.num_people_served;
            }
            if (tac_other_opex < 0.00001) {tac_other_opex = null}
            data = {y: tac_other_opex};
            Other_OPEX.push(data);

            var tot_admin = current_datapoint_ac.capex_administration + current_datapoint_ac.opex_administration;
            if (tac_type === "TACH") {
                var tac_admin = tot_admin / current_datapoint.master.num_hh_served;
            } else {
                var tac_admin = tot_admin / current_datapoint.master.num_people_served;
            }
            if (tac_admin < 0.00001) {tac_admin = null}
            var data = {y: tac_admin};
            Administrative_Charges.push(data);

            var tot_finance = current_datapoint_ac.capex_finance + current_datapoint_ac.opex_finance;
            if (tac_type === "TACH") {
                var tac_finance = tot_finance / current_datapoint.master.num_hh_served;
            } else {
                var tac_finance = tot_finance / current_datapoint.master.num_people_served;
            }
            if (tac_finance < 0.00001) {tac_finance = null}
            data = {y: tac_finance};
            Financing.push(data);

            var tot_taxes = current_datapoint_ac.capex_taxes + current_datapoint_ac.opex_taxes;
            if (tac_type === "TACH") {
                var tac_taxes = tot_taxes / current_datapoint.master.num_hh_served;
            } else {
                var tac_taxes = tot_taxes / current_datapoint.master.num_people_served;
            }
            if (tac_taxes < 0.00001) {tac_taxes = null}
            data = {y: tac_taxes};
            Taxes.push(data);
        }

        data = {name: all_category1[0], data: Land};
        base_data.push(data);
        data = {name: all_category1[1], data: Infrastructure_and_Buildings};
        base_data.push(data);
        data = {name: all_category1[2], data: Equipment};
        base_data.push(data);
        data = {name: all_category1[3], data: Major_and_Extraordinary_Repairs};
        base_data.push(data);
        data = {name: all_category1[4], data: Staff_Development};
        base_data.push(data);
        data = {name: all_category1[5], data: Other_CAPEX};
        base_data.push(data);
        data = {name: all_category1[6], data: Staffing};
        base_data.push(data);
        data = {name: all_category1[7], data: Consumables};
        base_data.push(data);
        data = {name: all_category1[8], data: Other_OPEX};
        base_data.push(data);
        data = {name: all_category1[9], data: Administrative_Charges};
        base_data.push(data);
        data = {name: all_category1[10], data: Financing};
        base_data.push(data);
        data = {name: all_category1[11], data: Taxes};
        base_data.push(data);

        return {base_data: base_data, datapoint_name: datapoint_names};
    }
    // 7
    function get_cost_type_1_split_data(data_flag,capex_opex) {
        var tac_type = data_flag;
        var capex_opex_type = capex_opex;
        var base_data = new Array();

        var datapoint_names = [];
        // Get list of Case Names
        for (var i = 0; i < all_datapoint_data.study_data.length; i++) {
            datapoint_names.push(all_datapoint_data.study_data[i].master.datapoint_name);
        }

        var Land = [];
        var Infrastructure_and_Buildings = [];
        var Equipment = [];
        var Major_and_Extraordinary_Repairs = [];
        var Staff_Development = [];
        var Other_CAPEX = [];
        var Staffing = [];
        var Consumables = [];
        var Other_OPEX = [];
        var Administrative_Charges = [];
        var Financing = [];
        var Taxes = [];

        if (capex_opex_type === "CAPEX") {
            for( j = 0 ; j < all_datapoint_data.study_data.length; j++) {
                var current_datapoint = all_datapoint_data.study_data[j];
                var current_datapoint_ac = current_datapoint.results.annualised_cost;

                var tot_land = current_datapoint_ac.capex_land;
                if (tac_type === "TACH") {
                    var tac_land = tot_land / current_datapoint.master.num_hh_served;
                } else {
                    var tac_land = tot_land / current_datapoint.master.num_people_served;
                }
                if (tac_land < 0.00001) {tac_land = null}
                var data = {y: tac_land};
                Land.push(data);

                var tot_infrastructure = current_datapoint_ac.capex_infrastructure;
                if (tac_type === "TACH") {
                    var tac_infrastructure = tot_infrastructure / current_datapoint.master.num_hh_served;
                } else {
                    var tac_infrastructure = tot_infrastructure / current_datapoint.master.num_people_served;
                }
                if (tac_infrastructure < 0.00001) {tac_infrastructure = null}
                data = {y: tac_infrastructure};
                Infrastructure_and_Buildings.push(data);

                var tot_equipment = current_datapoint_ac.capex_equipment;
                if (tac_type === "TACH") {
                    var tac_equipment = tot_equipment / current_datapoint.master.num_hh_served;
                } else {
                    var tac_equipment = tot_equipment / current_datapoint.master.num_people_served;
                }
                if (tac_equipment < 0.00001) {tac_equipment = null}
                data = {y: tac_equipment};
                Equipment.push(data);

                var tot_major_repairs = current_datapoint_ac.capex_extraordinary;
                if (tac_type === "TACH") {
                    var tac_major_repairs = tot_major_repairs / current_datapoint.master.num_hh_served;
                } else {
                    var tac_major_repairs = tot_major_repairs / current_datapoint.master.num_people_served;
                }
                if (tac_major_repairs < 0.00001) {tac_major_repairs = null}
                data = {y: tac_major_repairs};
                Major_and_Extraordinary_Repairs.push(data);

                var tot_staff_develop = current_datapoint_ac.capex_staff_develop;
                if (tac_type === "TACH") {
                    var tac_staff_develop = tot_staff_develop / current_datapoint.master.num_hh_served;
                } else {
                    var tac_staff_develop = tot_staff_develop / current_datapoint.master.num_people_served;
                }
                if (tac_staff_develop < 0.00001) {tac_staff_develop = null}
                data = {y: tac_staff_develop};
                Staff_Development.push(data);

                var tot_other_capex = current_datapoint_ac.capex_other;
                if (tac_type === "TACH") {
                    var tac_other_capex = tot_other_capex / current_datapoint.master.num_hh_served;
                } else {
                    var tac_other_capex = tot_other_capex / current_datapoint.master.num_people_served;
                }
                if (tac_other_capex < 0.00001) {tac_other_capex = null}
                data = {y: tac_other_capex};
                Other_CAPEX.push(data);

                data = {y: null};
                Staffing.push(data);

                data = {y: null};
                Consumables.push(data);

                data = {y: null};
                Other_OPEX.push(data);

                var tot_admin = current_datapoint_ac.capex_administration;
                if (tac_type === "TACH") {
                    var tac_admin = tot_admin / current_datapoint.master.num_hh_served;
                } else {
                    var tac_admin = tot_admin / current_datapoint.master.num_people_served;
                }
                if (tac_admin < 0.00001) {tac_admin = null}
                var data = {y: tac_admin};
                Administrative_Charges.push(data);

                var tot_finance = current_datapoint_ac.capex_finance;
                if (tac_type === "TACH") {
                    var tac_finance = tot_finance / current_datapoint.master.num_hh_served;
                } else {
                    var tac_finance = tot_finance / current_datapoint.master.num_people_served;
                }
                if (tac_finance < 0.00001) {tac_finance = null}
                data = {y: tac_finance};
                Financing.push(data);

                var tot_taxes = current_datapoint_ac.capex_taxes;
                if (tac_type === "TACH") {
                    var tac_taxes = tot_taxes / current_datapoint.master.num_hh_served;
                } else {
                    var tac_taxes = tot_taxes / current_datapoint.master.num_people_served;
                }
                if (tac_taxes < 0.00001) {tac_taxes = null}
                data = {y: tac_taxes};
                Taxes.push(data);
            }
        } else { // for only opex
            for( j = 0 ; j < all_datapoint_data.study_data.length; j++) {
                var current_datapoint = all_datapoint_data.study_data[j];
                var current_datapoint_ac = current_datapoint.results.annualised_cost;

                var tot_land = current_datapoint_ac.opex_land;
                if (tac_type === "TACH") {
                    var tac_land = tot_land / current_datapoint.master.num_hh_served;
                } else {
                    var tac_land = tot_land / current_datapoint.master.num_people_served;
                }
                if (tac_land < 0.00001) {tac_land = null}
                var data = {y: tac_land};
                Land.push(data);

                var tot_infrastructure = current_datapoint_ac.opex_infrastructure;
                if (tac_type === "TACH") {
                    var tac_infrastructure = tot_infrastructure / current_datapoint.master.num_hh_served;
                } else {
                    var tac_infrastructure = tot_infrastructure / current_datapoint.master.num_people_served;
                }
                if (tac_infrastructure < 0.00001) {tac_infrastructure = null}
                data = {y: tac_infrastructure};
                Infrastructure_and_Buildings.push(data);

                var tot_equipment = current_datapoint_ac.opex_equipment;
                if (tac_type === "TACH") {
                    var tac_equipment = tot_equipment / current_datapoint.master.num_hh_served;
                } else {
                    var tac_equipment = tot_equipment / current_datapoint.master.num_people_served;
                }
                if (tac_equipment < 0.00001) {tac_equipment = null}
                data = {y: tac_equipment};
                Equipment.push(data);

                data = {y: null};
                Major_and_Extraordinary_Repairs.push(data);

                var tot_staff_develop = current_datapoint_ac.opex_staff_develop;
                if (tac_type === "TACH") {
                    var tac_staff_develop = tot_staff_develop / current_datapoint.master.num_hh_served;
                } else {
                    var tac_staff_develop = tot_staff_develop / current_datapoint.master.num_people_served;
                }
                if (tac_staff_develop < 0.00001) {tac_staff_develop = null}
                data = {y: tac_staff_develop};
                Staff_Development.push(data);

                data = {y: null};
                Other_CAPEX.push(data);

                var tot_staffing = current_datapoint_ac.opex_staff;
                if (tac_type === "TACH") {
                    var tac_staffing = tot_staffing / current_datapoint.master.num_hh_served;
                } else {
                    var tac_staffing = tot_staffing / current_datapoint.master.num_people_served;
                }
                if (tac_staffing < 0.00001) {tac_staffing = null}
                data = {y: tac_staffing};
                Staffing.push(data);

                var tot_consumables = current_datapoint_ac.opex_all_consumables;
                if (tac_type === "TACH") {
                    var tac_consumables = tot_consumables / current_datapoint.master.num_hh_served;
                } else {
                    var tac_consumables = tot_consumables / current_datapoint.master.num_people_served;
                }
                if (tac_consumables < 0.00001) {tac_consumables = null}
                data = {y: tac_consumables};
                Consumables.push(data);

                var tot_other_opex = current_datapoint_ac.opex_other;
                if (tac_type === "TACH") {
                    var tac_other_opex = tot_other_opex / current_datapoint.master.num_hh_served;
                } else {
                    var tac_other_opex = tot_other_opex / current_datapoint.master.num_people_served;
                }
                if (tac_other_opex < 0.00001) {tac_other_opex = null}
                data = {y: tac_other_opex};
                Other_OPEX.push(data);

                var tot_admin = current_datapoint_ac.opex_administration;
                if (tac_type === "TACH") {
                    var tac_admin = tot_admin / current_datapoint.master.num_hh_served;
                } else {
                    var tac_admin = tot_admin / current_datapoint.master.num_people_served;
                }
                if (tac_admin < 0.00001) {tac_admin = null}
                var data = {y: tac_admin};
                Administrative_Charges.push(data);

                var tot_finance = current_datapoint_ac.opex_finance;
                if (tac_type === "TACH") {
                    var tac_finance = tot_finance / current_datapoint.master.num_hh_served;
                } else {
                    var tac_finance = tot_finance / current_datapoint.master.num_people_served;
                }
                if (tac_finance < 0.00001) {tac_finance = null}
                data = {y: tac_finance};
                Financing.push(data);

                var tot_taxes = current_datapoint_ac.opex_taxes;
                if (tac_type === "TACH") {
                    var tac_taxes = tot_taxes / current_datapoint.master.num_hh_served;
                } else {
                    var tac_taxes = tot_taxes / current_datapoint.master.num_people_served;
                }
                if (tac_taxes < 0.00001) {tac_taxes = null}
                data = {y: tac_taxes};
                Taxes.push(data);
            }
        }

        data = {name: all_category1[0], data: Land};
        base_data.push(data);
        data = {name: all_category1[1], data: Infrastructure_and_Buildings};
        base_data.push(data);
        data = {name: all_category1[2], data: Equipment};
        base_data.push(data);
        data = {name: all_category1[3], data: Major_and_Extraordinary_Repairs};
        base_data.push(data);
        data = {name: all_category1[4], data: Staff_Development};
        base_data.push(data);
        data = {name: all_category1[5], data: Other_CAPEX};
        base_data.push(data);
        data = {name: all_category1[6], data: Staffing};
        base_data.push(data);
        data = {name: all_category1[7], data: Consumables};
        base_data.push(data);
        data = {name: all_category1[8], data: Other_OPEX};
        base_data.push(data);
        data = {name: all_category1[9], data: Administrative_Charges};
        base_data.push(data);
        data = {name: all_category1[10], data: Financing};
        base_data.push(data);
        data = {name: all_category1[11], data: Taxes};
        base_data.push(data);

        return {base_data: base_data, datapoint_name: datapoint_names};
    }

    // 8
    function draw_category_split_more_chart(data_flag, elements_chosen) {
        var base_summary_chart = my_base_summary_split_chart;
        var tac_type = data_flag;
        var element_array = elements_chosen;
        var selected_base_data = get_category_split_more_data(tac_type, element_array);

        base_summary_chart.title.text = 'CACTUS$ Costing';
        base_summary_chart.subtitle.text = tac_type + ' split by Category for each Case.  US$ 2016';
        base_summary_chart.series = selected_base_data.base_data;
        base_summary_chart.xAxis.categories = selected_base_data.datapoint_name;
        base_summary_chart.yAxis.title.text = tac_type + " (US$ 2016)";
        base_summary_chart.yAxis.max = null;//2000; // does not all fit
        base_summary_chart.plotOptions.column.dataLabels.enabled = true;
        base_summary_chart.yAxis.stackLabels.enabled = false; // see total
        base_summary_chart.legend.align = 'left';
        base_summary_chart.legend.verticalAlign = 'top';
        base_summary_chart.legend.x = 100;
        base_summary_chart.tooltip.formatter = function(){
            var text;
            text = '<strong>' + this.series.name + '</strong><br /> '+ tac_type +' US$: <b>' + Highcharts.numberFormat(this.point.y,2,'.',',') + '</b><br/> Total: <b>' + Highcharts.numberFormat(this.point.stackTotal,2,'.',',') + '</b>';
            return  text;
        };
        if (tac_type === "TACH") {
            base_summary_chart.exporting.filename = 'cactus_costing_tach_' + (new Date()).getFullYear();
        } else {
            base_summary_chart.exporting.filename = 'cactus_costing_tacc_' + (new Date()).getFullYear();
        }

        $('#category_split_more_chart').show();
        $('#category_split_more_chart').highcharts(base_summary_chart);

        //console.log(all_cactus_data);
    }
    // 8
    function get_category_split_more_data(data_flag, elements_chosen){
        var tac_type = data_flag;
        var element_array = elements_chosen;
        var base_data = new Array();
        var datapoint_names = [];

        var Land = [];
        var Infrastructure_and_Buildings = [];
        var Equipment = [];
        var Major_and_Extraordinary_Repairs = [];
        var Staff_Development = [];
        var Other_CAPEX = [];
        var Staffing = [];
        var Consumables = [];
        var Other_OPEX = [];
        var Administrative_Charges = [];
        var Financing = [];
        var Taxes = [];

        for (j = 0; j < all_datapoint_data.study_data.length; j++) {
            var current_datapoint = all_datapoint_data.study_data[j];
            var current_datapoint_ac = current_datapoint.results.annualised_cost;
            var this_element = current_datapoint.master.element;
            var tester = false;

            for (var i = 0; i < element_array.length; i++) {
                if (this_element === element_array[i]) {tester = true;}
            }

            if (tester) {
                datapoint_names.push(all_datapoint_data.study_data[j].master.datapoint_name);

                var tot_land = current_datapoint_ac.capex_land + current_datapoint_ac.opex_land;
                if (tac_type === "TACH") {
                    var tac_land = tot_land / current_datapoint.master.num_hh_served;
                } else {
                    var tac_land = tot_land / current_datapoint.master.num_people_served;
                }
                if (tac_land < 0.00001) {
                    tac_land = null
                }
                var data = {y: tac_land};
                Land.push(data);

                var tot_infrastructure = current_datapoint_ac.capex_infrastructure + current_datapoint_ac.opex_infrastructure;
                if (tac_type === "TACH") {
                    var tac_infrastructure = tot_infrastructure / current_datapoint.master.num_hh_served;
                } else {
                    var tac_infrastructure = tot_infrastructure / current_datapoint.master.num_people_served;
                }
                if (tac_infrastructure < 0.00001) {
                    tac_infrastructure = null
                }
                data = {y: tac_infrastructure};
                Infrastructure_and_Buildings.push(data);

                var tot_equipment = current_datapoint_ac.capex_equipment + current_datapoint_ac.opex_equipment;
                if (tac_type === "TACH") {
                    var tac_equipment = tot_equipment / current_datapoint.master.num_hh_served;
                } else {
                    var tac_equipment = tot_equipment / current_datapoint.master.num_people_served;
                }
                if (tac_equipment < 0.00001) {
                    tac_equipment = null
                }
                data = {y: tac_equipment};
                Equipment.push(data);

                var tot_major_repairs = current_datapoint_ac.capex_extraordinary;
                if (tac_type === "TACH") {
                    var tac_major_repairs = tot_major_repairs / current_datapoint.master.num_hh_served;
                } else {
                    var tac_major_repairs = tot_major_repairs / current_datapoint.master.num_people_served;
                }
                if (tac_major_repairs < 0.00001) {
                    tac_major_repairs = null
                }
                data = {y: tac_major_repairs};
                Major_and_Extraordinary_Repairs.push(data);

                var tot_staff_develop = current_datapoint_ac.capex_staff_develop + current_datapoint_ac.opex_staff_develop;
                if (tac_type === "TACH") {
                    var tac_staff_develop = tot_staff_develop / current_datapoint.master.num_hh_served;
                } else {
                    var tac_staff_develop = tot_staff_develop / current_datapoint.master.num_people_served;
                }
                if (tac_staff_develop < 0.00001) {
                    tac_staff_develop = null
                }
                data = {y: tac_staff_develop};
                Staff_Development.push(data);

                var tot_other_capex = current_datapoint_ac.capex_other;
                if (tac_type === "TACH") {
                    var tac_other_capex = tot_other_capex / current_datapoint.master.num_hh_served;
                } else {
                    var tac_other_capex = tot_other_capex / current_datapoint.master.num_people_served;
                }
                if (tac_other_capex < 0.00001) {
                    tac_other_capex = null
                }
                data = {y: tac_other_capex};
                Other_CAPEX.push(data);

                var tot_staffing = current_datapoint_ac.opex_staff;
                if (tac_type === "TACH") {
                    var tac_staffing = tot_staffing / current_datapoint.master.num_hh_served;
                } else {
                    var tac_staffing = tot_staffing / current_datapoint.master.num_people_served;
                }
                if (tac_staffing < 0.00001) {
                    tac_staffing = null
                }
                data = {y: tac_staffing};
                Staffing.push(data);

                var tot_consumables = current_datapoint_ac.opex_all_consumables;
                if (tac_type === "TACH") {
                    var tac_consumables = tot_consumables / current_datapoint.master.num_hh_served;
                } else {
                    var tac_consumables = tot_consumables / current_datapoint.master.num_people_served;
                }
                if (tac_consumables < 0.00001) {
                    tac_consumables = null
                }
                data = {y: tac_consumables};
                Consumables.push(data);

                var tot_other_opex = current_datapoint_ac.opex_other;
                if (tac_type === "TACH") {
                    var tac_other_opex = tot_other_opex / current_datapoint.master.num_hh_served;
                } else {
                    var tac_other_opex = tot_other_opex / current_datapoint.master.num_people_served;
                }
                if (tac_other_opex < 0.00001) {
                    tac_other_opex = null
                }
                data = {y: tac_other_opex};
                Other_OPEX.push(data);

                var tot_admin = current_datapoint_ac.capex_administration + current_datapoint_ac.opex_administration;
                if (tac_type === "TACH") {
                    var tac_admin = tot_admin / current_datapoint.master.num_hh_served;
                } else {
                    var tac_admin = tot_admin / current_datapoint.master.num_people_served;
                }
                if (tac_admin < 0.00001) {
                    tac_admin = null
                }
                var data = {y: tac_admin};
                Administrative_Charges.push(data);

                var tot_finance = current_datapoint_ac.capex_finance + current_datapoint_ac.opex_finance;
                if (tac_type === "TACH") {
                    var tac_finance = tot_finance / current_datapoint.master.num_hh_served;
                } else {
                    var tac_finance = tot_finance / current_datapoint.master.num_people_served;
                }
                if (tac_finance < 0.00001) {
                    tac_finance = null
                }
                data = {y: tac_finance};
                Financing.push(data);

                var tot_taxes = current_datapoint_ac.capex_taxes + current_datapoint_ac.opex_taxes;
                if (tac_type === "TACH") {
                    var tac_taxes = tot_taxes / current_datapoint.master.num_hh_served;
                } else {
                    var tac_taxes = tot_taxes / current_datapoint.master.num_people_served;
                }
                if (tac_taxes < 0.00001) {
                    tac_taxes = null
                }
                data = {y: tac_taxes};
                Taxes.push(data);
            }
        }

        data = {name: all_category1[0], data: Land};
        base_data.push(data);
        data = {name: all_category1[1], data: Infrastructure_and_Buildings};
        base_data.push(data);
        data = {name: all_category1[2], data: Equipment};
        base_data.push(data);
        data = {name: all_category1[3], data: Major_and_Extraordinary_Repairs};
        base_data.push(data);
        data = {name: all_category1[4], data: Staff_Development};
        base_data.push(data);
        data = {name: all_category1[5], data: Other_CAPEX};
        base_data.push(data);
        data = {name: all_category1[6], data: Staffing};
        base_data.push(data);
        data = {name: all_category1[7], data: Consumables};
        base_data.push(data);
        data = {name: all_category1[8], data: Other_OPEX};
        base_data.push(data);
        data = {name: all_category1[9], data: Administrative_Charges};
        base_data.push(data);
        data = {name: all_category1[10], data: Financing};
        base_data.push(data);
        data = {name: all_category1[11], data: Taxes};
        base_data.push(data);

        return {base_data: base_data, datapoint_name: datapoint_names};
    }

    // 9
    function draw_datapoint_split_chart(datapoint1, datapoint2, data_flag) {
        var base_summary_chart = my_base_summary_split_chart;
        var tac_type = data_flag;
        var selected_base_data = get_datapoint_split_data(datapoint1, datapoint2, tac_type);

        base_summary_chart.title.text = 'CACTUS$ Costing';
        base_summary_chart.subtitle.text = tac_type + ' split by category for chosen datapoints.  US$ 2016';
        base_summary_chart.series = selected_base_data.base_data;
        base_summary_chart.xAxis.categories = selected_base_data.datapoint_name;
        base_summary_chart.yAxis.title.text = tac_type + " (US$ 2016)";
        base_summary_chart.yAxis.max = null;//2000; // does not all fit
        base_summary_chart.plotOptions.column.dataLabels.enabled = true;
        base_summary_chart.legend.align = 'left';
        base_summary_chart.legend.verticalAlign = 'top';
        base_summary_chart.legend.x = 100;
        base_summary_chart.tooltip.formatter = function(){
            var text;
            text = '<strong>' + this.series.name + '</strong><br/> '+ tac_type +' US$: <b>' + Highcharts.numberFormat(this.point.y,4,'.',',') + '</b><br/> Total: <b>' + Highcharts.numberFormat(this.point.stackTotal,4,'.',',') + '</b>';
            return  text;
        };
        if (tac_type === "TACH") {
            base_summary_chart.exporting.filename = 'cactus_costing_tach_' + (new Date()).getFullYear();
        } else {
            base_summary_chart.exporting.filename = 'cactus_costing_tacc_' + (new Date()).getFullYear();
        }

        $('#datapoint_split_chart').show();
        $('#datapoint_split_chart').highcharts(base_summary_chart);

        //console.log(all_cactus_data);
    }
    // 9
    function get_datapoint_split_data(datapoint1, datapoint2, data_flag){
        var tac_type = data_flag;
        var datapoint_1 = datapoint1;
        var datapoint_2 = datapoint2;
        var base_data = new Array();

        var datapoint_names = [datapoint_1, datapoint_2];

        var code_1 = 100;
        var code_2 = 100;
        for (var i = 0; i < all_datapoint_data.study_data.length; i++) {
            this_datapoint = all_datapoint_data.study_data[i].master.datapoint_name;
            if (datapoint_1 === this_datapoint) {code_1 = i;}
            if (datapoint_2 === this_datapoint) {code_2 = i;}
        }
        var codes_list = [code_1, code_2];

        var Land = [];
        var Infrastructure_and_Buildings = [];
        var Equipment = [];
        var Major_and_Extraordinary_Repairs = [];
        var Staff_Development = [];
        var Other_CAPEX = [];
        var Staffing = [];
        var Consumables = [];
        var Other_OPEX = [];
        var Administrative_Charges = [];
        var Financing = [];
        var Taxes = [];

        for( j = 0 ; j < codes_list.length; j++) {
            var current_datapoint = all_datapoint_data.study_data[codes_list[j]];
            var current_datapoint_ac = current_datapoint.results.annualised_cost;

            var tot_land = current_datapoint_ac.capex_land + current_datapoint_ac.opex_land;
            if (tac_type === "TACH") {
                var tac_land = tot_land / current_datapoint.master.num_hh_served;
            } else {
                var tac_land = tot_land / current_datapoint.master.num_people_served;
            }
            if (tac_land < 0.00001) {tac_land = null}
            var data = {y: tac_land};
            Land.push(data);

            var tot_infrastructure = current_datapoint_ac.capex_infrastructure + current_datapoint_ac.opex_infrastructure;
            if (tac_type === "TACH") {
                var tac_infrastructure = tot_infrastructure / current_datapoint.master.num_hh_served;
            } else {
                var tac_infrastructure = tot_infrastructure / current_datapoint.master.num_people_served;
            }
            if (tac_infrastructure < 0.00001) {tac_infrastructure = null}
            data = {y: tac_infrastructure};
            Infrastructure_and_Buildings.push(data);

            var tot_equipment = current_datapoint_ac.capex_equipment + current_datapoint_ac.opex_equipment;
            if (tac_type === "TACH") {
                var tac_equipment = tot_equipment / current_datapoint.master.num_hh_served;
            } else {
                var tac_equipment = tot_equipment / current_datapoint.master.num_people_served;
            }
            if (tac_equipment < 0.00001) {tac_equipment = null}
            data = {y: tac_equipment};
            Equipment.push(data);

            var tot_major_repairs = current_datapoint_ac.capex_extraordinary;
            if (tac_type === "TACH") {
                var tac_major_repairs = tot_major_repairs / current_datapoint.master.num_hh_served;
            } else {
                var tac_major_repairs = tot_major_repairs / current_datapoint.master.num_people_served;
            }
            if (tac_major_repairs < 0.00001) {tac_major_repairs = null}
            data = {y: tac_major_repairs};
            Major_and_Extraordinary_Repairs.push(data);

            var tot_staff_develop = current_datapoint_ac.capex_staff_develop + current_datapoint_ac.opex_staff_develop;
            if (tac_type === "TACH") {
                var tac_staff_develop = tot_staff_develop / current_datapoint.master.num_hh_served;
            } else {
                var tac_staff_develop = tot_staff_develop / current_datapoint.master.num_people_served;
            }
            if (tac_staff_develop < 0.00001) {tac_staff_develop = null}
            data = {y: tac_staff_develop};
            Staff_Development.push(data);

            var tot_other_capex = current_datapoint_ac.capex_other;
            if (tac_type === "TACH") {
                var tac_other_capex = tot_other_capex / current_datapoint.master.num_hh_served;
            } else {
                var tac_other_capex = tot_other_capex / current_datapoint.master.num_people_served;
            }
            if (tac_other_capex < 0.00001) {tac_other_capex = null}
            data = {y: tac_other_capex};
            Other_CAPEX.push(data);

            var tot_staffing = current_datapoint_ac.opex_staff;
            if (tac_type === "TACH") {
                var tac_staffing = tot_staffing / current_datapoint.master.num_hh_served;
            } else {
                var tac_staffing = tot_staffing / current_datapoint.master.num_people_served;
            }
            if (tac_staffing < 0.00001) {tac_staffing = null}
            data = {y: tac_staffing};
            Staffing.push(data);

            var tot_consumables = current_datapoint_ac.opex_all_consumables;
            if (tac_type === "TACH") {
                var tac_consumables = tot_consumables / current_datapoint.master.num_hh_served;
            } else {
                var tac_consumables = tot_consumables / current_datapoint.master.num_people_served;
            }
            if (tac_consumables < 0.00001) {tac_consumables = null}
            data = {y: tac_consumables};
            Consumables.push(data);

            var tot_other_opex = current_datapoint_ac.opex_other;
            if (tac_type === "TACH") {
                var tac_other_opex = tot_other_opex / current_datapoint.master.num_hh_served;
            } else {
                var tac_other_opex = tot_other_opex / current_datapoint.master.num_people_served;
            }
            if (tac_other_opex < 0.00001) {tac_other_opex = null}
            data = {y: tac_other_opex};
            Other_OPEX.push(data);

            var tot_admin = current_datapoint_ac.capex_administration + current_datapoint_ac.opex_administration;
            if (tac_type === "TACH") {
                var tac_admin = tot_admin / current_datapoint.master.num_hh_served;
            } else {
                var tac_admin = tot_admin / current_datapoint.master.num_people_served;
            }
            if (tac_admin < 0.00001) {tac_admin = null}
            var data = {y: tac_admin};
            Administrative_Charges.push(data);

            var tot_finance = current_datapoint_ac.capex_finance + current_datapoint_ac.opex_finance;
            if (tac_type === "TACH") {
                var tac_finance = tot_finance / current_datapoint.master.num_hh_served;
            } else {
                var tac_finance = tot_finance / current_datapoint.master.num_people_served;
            }
            if (tac_finance < 0.00001) {tac_finance = null}
            data = {y: tac_finance};
            Financing.push(data);

            var tot_taxes = current_datapoint_ac.capex_taxes + current_datapoint_ac.opex_taxes;
            if (tac_type === "TACH") {
                var tac_taxes = tot_taxes / current_datapoint.master.num_hh_served;
            } else {
                var tac_taxes = tot_taxes / current_datapoint.master.num_people_served;
            }
            if (tac_taxes < 0.00001) {tac_taxes = null}
            data = {y: tac_taxes};
            Taxes.push(data);
        }

        data = {name: all_category1[0], data: Land};
        base_data.push(data);
        data = {name: all_category1[1], data: Infrastructure_and_Buildings};
        base_data.push(data);
        data = {name: all_category1[2], data: Equipment};
        base_data.push(data);
        data = {name: all_category1[3], data: Major_and_Extraordinary_Repairs};
        base_data.push(data);
        data = {name: all_category1[4], data: Staff_Development};
        base_data.push(data);
        data = {name: all_category1[5], data: Other_CAPEX};
        base_data.push(data);
        data = {name: all_category1[6], data: Staffing};
        base_data.push(data);
        data = {name: all_category1[7], data: Consumables};
        base_data.push(data);
        data = {name: all_category1[8], data: Other_OPEX};
        base_data.push(data);
        data = {name: all_category1[9], data: Administrative_Charges};
        base_data.push(data);
        data = {name: all_category1[10], data: Financing};
        base_data.push(data);
        data = {name: all_category1[11], data: Taxes};
        base_data.push(data);

        return {base_data: base_data, datapoint_name: datapoint_names};
    }
});