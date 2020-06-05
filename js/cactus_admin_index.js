
//$(document).ready(function () {

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
            url: 'fetch_master_data_xlsx.php',
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

    $('#datapoint_detail_table2_hide_chk').on('click', function (e) {
        $('#datapoint_detail_table2').toggle();
    });

    $('#base_data_table_div').toggle();
    $('#base_data_table_chk').on('click', function (e) {
        $('#base_data_table_div').toggle();
    });
    $('#master_data_table_chk').on('click', function (e) {
        $('#master_data_table_div').toggle();
    });

    $('#btn_load_all_datapoints').on('click', function (e) {
        e.preventDefault(); // disable the default form submit event

        // manually get the data
        //alert("You clicked");
        $.ajax({
            type: 'post',
            url: 'fetch_datapoints_data_from_db.php',
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (mydata) {
                // ajax success callback
                console.log(mydata);
                all_datapoint_data = mydata;

                var push_to_db_flag = 1;
                calc_all_datapoints(push_to_db_flag);
                fill_datapoints_table();
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

    $('#btn_download_all_datapoints').on('click', function (e) {
        e.preventDefault(); // disable the default form submit event
        var filename ="all_cactus_datapoint_data.json";
        var string_body_of_file = JSON.stringify(all_datapoint_data);
        string_body_of_file = JSON.stringify(all_datapoint_data,undefined,2);
        download_text_string_as_file(string_body_of_file,filename);
    });

    function fill_datapoints_table() {
        // datapoint table
        //-----------------
        // Destroy the datatables if necessary
        if ($.fn.DataTable.isDataTable('#datapoint_detail_table2')) {
            $('#datapoint_detail_table2').DataTable().destroy();
        }
        // Empty the body of the table
        $('#datapoint_detail_table2 tbody').empty();
        // get the new body of the table and append it
        var datapoint_detail_table_html_body = get_datapoint_detail_table_body2();
        $('#datapoint_detail_table2 > tbody:last').append(datapoint_detail_table_html_body);
        // Reattach the datatables functionality
        $("#datapoint_detail_table2").dataTable(datapoint_table_def);
    }


    function get_datapoint_detail_table_body2(){
        var html = "";
        for(var i = 0; i < all_datapoint_data.study_data.length; i++){

            var master = all_datapoint_data.study_data[i].master;

            var input = "<input type='radio' id='datapoints_radio2' name='datapoints_radio2' value='" + master.datapoint_id + "'>";
            var input_dp = "<input type='hidden' id='datapoint_id2_" + i + "' value='" + master.datapoint_id + "'>";

            html += "<tr>";
            html += "<td>" + input + "</td>";
            html += "<td>" + master.datapoint_id + input_dp + "</td>";
            html += "<td>" + master.country + "</td>";
            html += "<td>" + master.country_code + "</td>";
            html += "<td>" + master.date + "</td>";
            html += "<td>" + master.city + "</td>";
            html += "<td>" + master.system + "</td>";
            html += "<td>" + master.element + "</td>";
            html += "<td>" + master.component + "</td>";
            html += "<td>" + master.case_description + "</td>";
            html += "</tr>\n";
        }

        return html;
    }
    $('#datapoint_detail_table2').on("change", "input[type=radio]", function() {
        var datapoint_id = this.value;

        var selected_datapoint_data = all_datapoint_data.study_data[datapoint_id];
        // Call the processing function
        //process_current_datapoint2(selected_datapoint_data);
        fill_table_with_selected_datapoint(datapoint_id);

    });

    function get_datapoint_detail_slected_table_body2(datapoint_id){
        var html = "";

        var master = all_datapoint_data.study_data[datapoint_id].master;

        var input = "<input type='radio' checked id='datapoints_radio2_selected' name='datapoints_radio2_selected' value='" + datapoint_id + "'>";

        html += "<tr>";
        html += "<td>" + input + "</td>";
        html += "<td>" + master.datapoint_id + "</td>";
        html += "<td>" + master.country + "</td>";
        html += "<td>" + master.country_code + "</td>";
        html += "<td>" + master.date + "</td>";
        html += "<td>" + master.city + "</td>";
        html += "<td>" + master.system + "</td>";
        html += "<td>" + master.element + "</td>";
        html += "<td>" + master.component + "</td>";
        html += "<td>" + master.case_description + "</td>";
        html += "</tr>\n";

        return html;
    }

    function fill_table_with_selected_datapoint(datapoint_id){
        var master = all_datapoint_data.study_data[datapoint_id].master;
        var master_data = '{"master":' + JSON.stringify(master) +'}' ;
        var i = all_datapoint_data.study_data[datapoint_id].resources.length-1;
        var resources_data = '{"resources":' + JSON.stringify(all_datapoint_data.study_data[datapoint_id].resources) + '}' ;
        //resources_data = '["a", 6, "b"]';
        var services_data = '{"services":' + JSON.stringify(all_datapoint_data.study_data[datapoint_id].services) +'}' ;
        var res_total_cost_data = '{"total_cost":' + JSON.stringify(all_datapoint_data.study_data[datapoint_id].results.total_cost) +'}' ;
        var res_annualised_cost_data = '{"annualised_cost":' + JSON.stringify(all_datapoint_data.study_data[datapoint_id].results.annualised_cost) +'}' ;
        var res_cost_type_data = '{"cost_type_cost":' + JSON.stringify(all_datapoint_data.study_data[datapoint_id].results.cost_type_cost) +'}' ;
        var target = '#datapoint_selected_tree';
        $(target).empty();
        jsonView.format(master_data, target);

        target = '#datapoint_selected_resources';
        $(target).empty();
        jsonView.format(resources_data, target);
        target = '#datapoint_selected_services';
        $(target).empty();
        jsonView.format(services_data, target);

        target = '#datapoint_selected_res1';
        $(target).empty();
        jsonView.format(res_total_cost_data, target);
        target = '#datapoint_selected_res2';
        $(target).empty();
        jsonView.format(res_annualised_cost_data, target);
        target = '#datapoint_selected_res3';
        $(target).empty();
        jsonView.format(res_cost_type_data, target);

        //console.log(resources_data);

        // Selected table
        //-----------------
        // datapoint_detail_table_selected
        // Destroy the datatables if necessary
        if ($.fn.DataTable.isDataTable('#datapoint_detail_table_selected')) {
            $('#datapoint_detail_table_selected').DataTable().destroy();
        }
        // Empty the body of the table
        $('#datapoint_detail_table_selected tbody').empty();
        // get the new body of the table and append it
        var detail_selected_html_body = get_datapoint_detail_slected_table_body2(datapoint_id);
        $('#datapoint_detail_table_selected > tbody:last').append(detail_selected_html_body);
        // Reattach the datatables functionality
        $("#datapoint_detail_table_selected").dataTable(datapoint_table_def);

        // Cost Type 2 table
        //-----------------
        // Destroy the datatables if necessary
        if ($.fn.DataTable.isDataTable('#cost_type2_summary_table')) {
            $('#cost_type2_summary_table').DataTable().destroy();
        }
        // Empty the body of the table
        $('#cost_type2_summary_table tbody').empty();
        // get the new body of the table and append it
        var cost_type2_table_html_body = get_cost_type2_summary_table_body_new(datapoint_id);
        $('#cost_type2_summary_table > tbody:last').append(cost_type2_table_html_body);
        // Reattach the datatables functionality
        $("#cost_type2_summary_table").dataTable(cats_table_def);

        // Category 1 table
        //-----------------
        // Destroy the datatables if necessary
        if ($.fn.DataTable.isDataTable('#category1_summary_table')) {
            $('#category1_summary_table').DataTable().destroy();
        }
        // Empty the body of the table
        $('#category1_summary_table tbody').empty();
        // get the new body of the table and append it
        var cat1_table_html_body = get_category1_summary_table_body_new(datapoint_id);
        $('#category1_summary_table > tbody:last').append(cat1_table_html_body);
        // Reattach the datatables functionality
        $("#category1_summary_table").dataTable(cats_table_def);

        // Category 2 table
        //-----------------
        // Destroy the datatables if necessary
        if ($.fn.DataTable.isDataTable('#category2_summary_table')) {
            $('#category2_summary_table').DataTable().destroy();
        }
        // Empty the body of the table
        $('#category2_summary_table tbody').empty();
        // get the new body of the table and append it
        var cat2_table_html_body = get_category2_summary_table_body_new(datapoint_id);
        $('#category2_summary_table > tbody:last').append(cat2_table_html_body);
        // Reattach the datatables functionality
        $("#category2_summary_table").dataTable(cats_table_def);

        // Category 3 table
        //-----------------
        // Destroy the datatables if necessary
        if ($.fn.DataTable.isDataTable('#category3_summary_table')) {
            $('#category3_summary_table').DataTable().destroy();
        }
        // Empty the body of the table
        $('#category3_summary_table tbody').empty();
        // get the new body of the table and append it
        var cat3_table_html_body = get_category3_summary_table_body_new(datapoint_id);
        $('#category3_summary_table > tbody:last').append(cat3_table_html_body);
        // Reattach the datatables functionality
        $("#category3_summary_table").dataTable(cats_table_def);

        // Services table
        //-----------------
        // Destroy the datatables if necessary
        if ($.fn.DataTable.isDataTable('#services2_summary_table')) {
            $('#services2_summary_table').DataTable().destroy();
        }
        // Empty the body of the table
        $('#services2_summary_table tbody').empty();
        // get the new body of the table and append it
        var services2_table_html_body = get_services2_summary_table_body_new(datapoint_id);
        $('#services2_summary_table > tbody:last').append(services2_table_html_body);
        // Reattach the datatables functionality
        $("#services2_summary_table").dataTable(services_table_def);
    }

    // New
    function get_cost_type2_summary_table_body_new(datapoint_id){
        // Builds the cost type 2 summary table
        var j = datapoint_id;

        var capex_totals = [
            all_datapoint_data.study_data[j].results.cost_type_cost.capex_direct_variable,
            all_datapoint_data.study_data[j].results.cost_type_cost.capex_direct_fixed,
            all_datapoint_data.study_data[j].results.cost_type_cost.capex_indirect_variable,
            all_datapoint_data.study_data[j].results.cost_type_cost.capex_indirect_fixed
        ];
        var opex_totals = [
            all_datapoint_data.study_data[j].results.cost_type_cost.opex_direct_variable,
            all_datapoint_data.study_data[j].results.cost_type_cost.opex_direct_fixed,
            all_datapoint_data.study_data[j].results.cost_type_cost.opex_indirect_variable,
            all_datapoint_data.study_data[j].results.cost_type_cost.opex_indirect_fixed
        ];
        var annual_totals = [
            all_datapoint_data.study_data[j].results.cost_type_cost.total_direct_variable,
            all_datapoint_data.study_data[j].results.cost_type_cost.total_direct_fixed,
            all_datapoint_data.study_data[j].results.cost_type_cost.total_indirect_variable,
            all_datapoint_data.study_data[j].results.cost_type_cost.total_indirect_fixed
        ];

        var html = "";
        // The rows of the body
        for(var i = 0 ; i < all_cost_type2.length ; i++) {
            html += "<tr>\n";
            html += "<td>" + all_cost_type2[i] + "</td> <td class='text-right'>" +
                formatThousandNumber(capex_totals[i].toFixed(2)) + "</td> <td class='text-right'>" +
                formatThousandNumber(opex_totals[i].toFixed(2)) + "</td> <td class='text-right'>" +
                formatThousandNumber(annual_totals[i].toFixed(2)) + "</td>\n";
            html += "</tr>\n";
        }

        // The total row
        html += "<tr>\n";
        html += "<td>" +  "</td> <td>" +  "</td> <td>" + "</td> <td class='text-right' style='background: WhiteSmoke'>" +
            formatThousandNumber(all_datapoint_data.study_data[j].results.cost_type_cost.total.toFixed(2)) + "</td>\n";
        html += "</tr>\n";

        return html;
    }

    function get_category1_summary_table_body_new(datapoint_id){
        // Builds the category 1 summary table
        var j = datapoint_id;

        var sum_consumables = all_datapoint_data.study_data[j].results.total_cost.opex_all_consumables;
        var sum_annual_consumables = all_datapoint_data.study_data[j].results.annualised_cost.opex_all_consumables;

        var capex_totals = [
            all_datapoint_data.study_data[j].results.total_cost.capex_land,
            all_datapoint_data.study_data[j].results.total_cost.capex_infrastructure,
            all_datapoint_data.study_data[j].results.total_cost.capex_equipment,
            all_datapoint_data.study_data[j].results.total_cost.capex_extraordinary,
            all_datapoint_data.study_data[j].results.total_cost.capex_staff_develop,
            all_datapoint_data.study_data[j].results.total_cost.capex_other,
            0,
            0,
            0,
            all_datapoint_data.study_data[j].results.total_cost.capex_administration,
            all_datapoint_data.study_data[j].results.total_cost.capex_finance,
            all_datapoint_data.study_data[j].results.total_cost.capex_taxes
        ];
        var opex_totals = [
            all_datapoint_data.study_data[j].results.total_cost.opex_land,
            all_datapoint_data.study_data[j].results.total_cost.opex_infrastructure,
            all_datapoint_data.study_data[j].results.total_cost.opex_equipment,
            0,
            all_datapoint_data.study_data[j].results.total_cost.opex_staff_develop,
            0,
            all_datapoint_data.study_data[j].results.total_cost.opex_staff,
            sum_consumables,
            all_datapoint_data.study_data[j].results.total_cost.opex_other,
            all_datapoint_data.study_data[j].results.total_cost.opex_administration,
            all_datapoint_data.study_data[j].results.total_cost.opex_finance,
            all_datapoint_data.study_data[j].results.total_cost.opex_taxes
        ];
        var annual_totals = [
            all_datapoint_data.study_data[j].results.annualised_cost.capex_land + all_datapoint_data.study_data[j].results.annualised_cost.opex_land,
            all_datapoint_data.study_data[j].results.annualised_cost.capex_infrastructure + all_datapoint_data.study_data[j].results.annualised_cost.opex_infrastructure,
            all_datapoint_data.study_data[j].results.annualised_cost.capex_equipment + all_datapoint_data.study_data[j].results.annualised_cost.opex_equipment,
            all_datapoint_data.study_data[j].results.annualised_cost.capex_extraordinary + 0,
            all_datapoint_data.study_data[j].results.annualised_cost.capex_staff_develop + all_datapoint_data.study_data[j].results.annualised_cost.opex_staff_develop,
            all_datapoint_data.study_data[j].results.annualised_cost.capex_other + 0,
            0 + all_datapoint_data.study_data[j].results.annualised_cost.opex_staff,
            0 + sum_annual_consumables,
            0 + all_datapoint_data.study_data[j].results.annualised_cost.opex_other,
            all_datapoint_data.study_data[j].results.annualised_cost.capex_administration + all_datapoint_data.study_data[j].results.annualised_cost.opex_administration,
            all_datapoint_data.study_data[j].results.annualised_cost.capex_finance + all_datapoint_data.study_data[j].results.annualised_cost.opex_finance,
            all_datapoint_data.study_data[j].results.annualised_cost.capex_taxes + all_datapoint_data.study_data[j].results.annualised_cost.opex_taxes
        ];

        var annual_sum = 0;
        for (var k = 0; k < annual_totals.length; k++) {
            annual_sum += annual_totals[k];
        }

        var html = "";
        // The rows of the body
        for(var i = 0 ; i < all_category1.length ; i++) {
            html += "<tr>\n";
            html += "<td>" + all_category1[i] + "</td> <td class='text-right'>" +
                formatThousandNumber(capex_totals[i].toFixed(2)) + "</td> <td class='text-right'>" +
                formatThousandNumber(opex_totals[i].toFixed(2)) + "</td> <td class='text-right'>" +
                formatThousandNumber(annual_totals[i].toFixed(2)) + "</td>\n";
            html += "</tr>\n";
        }

        // The total row
        html += "<tr>\n";
        html += "<td>" +  "</td> <td>" +  "</td> <td>" + "</td> <td class='text-right' style='background: WhiteSmoke'>" +
            formatThousandNumber(annual_sum.toFixed(2)) + "</td>\n";
        html += "</tr>\n";

        return html;
    }

    function get_category2_summary_table_body_new(datapoint_id){
        // Builds the category 2 summary table
        var j = datapoint_id;

        var sum_services = all_datapoint_data.study_data[j].results.total_cost.opex_all_services;
        var sum_annual_services = all_datapoint_data.study_data[j].results.annualised_cost.opex_all_services;

        var capex_totals = [0, 0, 0, 0, 0];
        var opex_totals = [
            all_datapoint_data.study_data[j].results.total_cost.opex_consumables_utilities,
            all_datapoint_data.study_data[j].results.total_cost.opex_consumables_fuel,
            all_datapoint_data.study_data[j].results.total_cost.opex_consumables_chemicals,
            sum_services,
            all_datapoint_data.study_data[j].results.total_cost.opex_consumables_other
        ];
        var annual_totals = [
            all_datapoint_data.study_data[j].results.annualised_cost.opex_consumables_utilities,
            all_datapoint_data.study_data[j].results.annualised_cost.opex_consumables_fuel,
            all_datapoint_data.study_data[j].results.annualised_cost.opex_consumables_chemicals,
            sum_annual_services,
            all_datapoint_data.study_data[j].results.annualised_cost.opex_consumables_other
        ];

        var annual_sum = 0;
        for (var k = 0; k < annual_totals.length; k++) {
            annual_sum += annual_totals[k];
        }

        var html = "";
        // The rows of the body
        for(var i = 0 ; i < all_category2.length ; i++) {
            html += "<tr>\n";
            html += "<td>" + all_category2[i] + "</td> <td class='text-right'>" +
                formatThousandNumber(capex_totals[i].toFixed(2)) + "</td> <td class='text-right'>" +
                formatThousandNumber(opex_totals[i].toFixed(2)) + "</td> <td class='text-right'>" +
                formatThousandNumber(annual_totals[i].toFixed(2)) + "</td>\n";
            html += "</tr>\n";
        }

        // The total row
        html += "<tr>\n";
        html += "<td>" +  "</td> <td>" +  "</td> <td>" + "</td> <td class='text-right' style='background: WhiteSmoke'>" +
            formatThousandNumber(annual_sum.toFixed(2)) + "</td>\n";
        html += "</tr>\n";

        return html;
    }

    function get_category3_summary_table_body_new(datapoint_id){
        // Builds the category 3 summary table
        var j = datapoint_id;

        var capex_totals = [0, 0, 0, 0, 0];
        var opex_totals = [
            all_datapoint_data.study_data[j].results.total_cost.opex_consumables_service_consultant,
            all_datapoint_data.study_data[j].results.total_cost.opex_consumables_service_legal,
            all_datapoint_data.study_data[j].results.total_cost.opex_consumables_service_insurance,
            all_datapoint_data.study_data[j].results.total_cost.opex_consumables_service_maint,
            all_datapoint_data.study_data[j].results.total_cost.opex_consumables_service_other
        ];
        var annual_totals = [
            all_datapoint_data.study_data[j].results.annualised_cost.opex_consumables_service_consultant,
            all_datapoint_data.study_data[j].results.annualised_cost.opex_consumables_service_legal,
            all_datapoint_data.study_data[j].results.annualised_cost.opex_consumables_service_insurance,
            all_datapoint_data.study_data[j].results.annualised_cost.opex_consumables_service_maint,
            all_datapoint_data.study_data[j].results.annualised_cost.opex_consumables_service_other
        ];

        var annual_sum = 0;
        for (var k = 0; k < annual_totals.length; k++) {
            annual_sum += annual_totals[k];
        }

        var html = "";
        // The rows of the body
        for(var i = 0 ; i < all_category3.length ; i++) {
            html += "<tr>\n";
            html += "<td>" + all_category3[i] + "</td> <td class='text-right'>" +
                formatThousandNumber(capex_totals[i].toFixed(2)) + "</td> <td class='text-right'>" +
                formatThousandNumber(opex_totals[i].toFixed(2)) + "</td> <td class='text-right'>" +
                formatThousandNumber(annual_totals[i].toFixed(2)) + "</td>\n";
            html += "</tr>\n";
        }

        // The total row
        html += "<tr>\n";
        html += "<td>" +  "</td> <td>" +  "</td> <td>" + "</td> <td class='text-right' style='background: WhiteSmoke'>" +
            formatThousandNumber(annual_sum.toFixed(2)) + "</td>\n";
        html += "</tr>\n";

        return html;
    }

    function get_services2_summary_table_body_new(datapoint_id){
        // Builds the services summary table
        var j = datapoint_id;

        service_values = [
            all_datapoint_data.study_data[j].master.num_people_served,
            all_datapoint_data.study_data[j].master.num_hh_served,
            all_datapoint_data.study_data[j].master.num_people_per_hh
        ];
        annual_service = [
            all_datapoint_data.study_data[j].results.cost_type_cost.total / service_values[0],
            all_datapoint_data.study_data[j].results.cost_type_cost.total / service_values[1],
            0
        ];

        var html = "";
        // The rows of the body
        for(var i = 0 ; i < all_service_drivers.length ; i++) {
            html += "<tr>\n";
            html += "<td>" + all_service_drivers[i] + "</td> <td class='text-right'>" +
                formatThousandNumber(service_values[i].toFixed(2)) + "</td> <td class='text-right'>" +
                formatThousandNumber(annual_service[i].toFixed(2)) + "</td>\n";
            html += "</tr>\n";
        }

        return html;
    }

    // Old
    function get_cost_type2_summary_table_body(){
        // Builds the cost type 2 summary table
        var html = "";

        // The rows of the body
        for(var i = 0 ; i < all_cost_type2.length ; i++) {
            html += "<tr>\n";
            html += "<td>" + all_cost_type2[i] + "</td> <td class='text-right'>" +
                formatThousandNumber(cost_type2_costs.capex[i].toFixed(2)) + "</td> <td class='text-right'>" +
                formatThousandNumber(cost_type2_costs.opex[i].toFixed(2)) + "</td> <td class='text-right'>" +
                formatThousandNumber(cost_type2_costs.tot_annualised[i].toFixed(2)) + "</td>\n";
            html += "</tr>\n";
        }

        // The total row
        html += "<tr>\n";
        html += "<td>" +  "</td> <td>" +  "</td> <td>" + "</td> <td class='text-right' style='background: WhiteSmoke'>" +
            formatThousandNumber(cost_type2_costs.tot_annualised_sum.toFixed(2)) + "</td>\n";
        html += "</tr>\n";

        return html;
    }

    function get_category1_summary_table_body(){
        // Builds the category 1 summary table
        var html = "";

        // The rows of the body
        for(var i = 0 ; i < all_category1.length ; i++) {
            html += "<tr>\n";
            html += "<td>" + all_category1[i] + "</td> <td class='text-right'>" +
                formatThousandNumber(category1_costs.capex[i].toFixed(2)) + "</td> <td class='text-right'>" +
                formatThousandNumber(category1_costs.opex[i].toFixed(2)) + "</td> <td class='text-right'>" +
                formatThousandNumber(category1_costs.tot_annualised[i].toFixed(2)) + "</td>\n";
            html += "</tr>\n";
        }

        // The total row
        html += "<tr>\n";
        html += "<td>" +  "</td> <td>" +  "</td> <td>" + "</td> <td class='text-right' style='background: WhiteSmoke'>" +
            formatThousandNumber(category1_costs.tot_annualised_sum.toFixed(2)) + "</td>\n";
        html += "</tr>\n";

        return html;
    }

    function get_category2_summary_table_body(){
        // Builds the category 2 summary table
        var html = "";

        // The rows of the body
        for(var i = 0 ; i < all_category2.length ; i++) {
            html += "<tr>\n";
            html += "<td>" + all_category2[i] + "</td> <td class='text-right'>" +
                formatThousandNumber(category2_costs.capex[i].toFixed(2)) + "</td> <td class='text-right'>" +
                formatThousandNumber(category2_costs.opex[i].toFixed(2)) + "</td> <td class='text-right'>" +
                formatThousandNumber(category2_costs.tot_annualised[i].toFixed(2)) + "</td>\n";
            html += "</tr>\n";
        }

        // The total row
        html += "<tr>\n";
        html += "<td>" +  "</td> <td>" +  "</td> <td>" + "</td> <td class='text-right' style='background: WhiteSmoke'>" +
            formatThousandNumber(category2_costs.tot_annualised_sum.toFixed(2)) + "</td>\n";
        html += "</tr>\n";

        return html;
    }

    function get_category3_summary_table_body(){
        // Builds the category 3 summary table
        var html = "";

        // The rows of the body
        for(var i = 0 ; i < all_category3.length ; i++) {
            html += "<tr>\n";
            html += "<td>" + all_category3[i] + "</td> <td class='text-right'>" +
                formatThousandNumber(category3_costs.capex[i].toFixed(2)) + "</td> <td class='text-right'>" +
                formatThousandNumber(category3_costs.opex[i].toFixed(2)) + "</td> <td class='text-right'>" +
                formatThousandNumber(category3_costs.tot_annualised[i].toFixed(2)) + "</td>\n";
            html += "</tr>\n";
        }

        // The total row
        html += "<tr>\n";
        html += "<td>" +  "</td> <td>" +  "</td> <td>" + "</td> <td class='text-right' style='background: WhiteSmoke'>" +
            formatThousandNumber(category3_costs.tot_annualised_sum.toFixed(2)) + "</td>\n";
        html += "</tr>\n";

        return html;
    }

    function get_services2_summary_table_body(){
        // Builds the services summary table

        services_costs.tot_annual_service[services_costs.tot_annual_service.length - 1] = 0;

        var html = "";

        // The rows of the body
        for(var i = 0 ; i < all_service_drivers.length ; i++) {
            html += "<tr>\n";
            html += "<td>" + all_service_drivers[i] + "</td> <td class='text-right'>" +
                formatThousandNumber(services_costs.service_value[i].toFixed(2)) + "</td> <td class='text-right'>" +
                formatThousandNumber(services_costs.tot_annual_service[i].toFixed(2)) + "</td>\n";
            html += "</tr>\n";
        }

        return html;
    }

//});