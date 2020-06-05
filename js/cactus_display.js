    var all_cactus_data;

    function set_all_cactus_data(my_cactus_data){
        all_cactus_data = my_cactus_data;
    }

    function draw_base_summary_chart() {
        var base_summary_chart = my_base_summary_chart;
        var selected_base_data = get_selected_base_data();
        base_summary_chart.title.text = 'CACTUS$ Costing';
        base_summary_chart.subtitle.text = 'TACH Range by element. US$ 2016';
        base_summary_chart.series[0] = {name : 'TACH', data : selected_base_data};
        base_summary_chart.xAxis.categories = ['Containment', 'Emptying and Transport', 'Treatment'];
        base_summary_chart.yAxis.title.text = "TACH (US$ 2016)";
        base_summary_chart.yAxis.max = null;
        base_summary_chart.tooltip.formatter = function(){
                var text;
                text = '<em>' + this.x + '</em><br />Min: <b>$' + this.point.low + '</b><br />Max: <b>$' + this.point.y + '</b><br />Count: <b>' + this.point.n + '</b>' ;
                return  text;
            };
        base_summary_chart.exporting.filename = 'cactus_costing_tach_' + (new Date()).getFullYear();

        $('#BaseSummaryChart').show();
        $('#BaseSummaryChart').highcharts(base_summary_chart);

        //console.log(all_cactus_data);
    }

    function draw_base_summary_split_chart() {
        var base_summary_chart = my_base_summary_split_chart;
        var selected_base_data = get_selected_base_split_data();
        base_summary_chart.title.text = 'CACTUS$ Costing';
        base_summary_chart.subtitle.text = 'TACH Range for Elements, by Country.  US$ 2016';
        base_summary_chart.series = selected_base_data.base_data;
        base_summary_chart.xAxis.categories = selected_base_data.countries;
        base_summary_chart.yAxis.title.text = "TACH (US$ 2016)";
        base_summary_chart.yAxis.max = null;
        base_summary_chart.tooltip.formatter = function(){
            var text;
            text = '<strong>' + this.series.name + '</strong><br /><br />TACH US$: <b>' + this.point.y + '</b><br />Count: <b>' + this.point.n + '</b>' ;
            return  text;
        };
        base_summary_chart.exporting.filename = 'cactus_costing_tach_' + (new Date()).getFullYear();

        $('#BaseSummarySplitChart').show();
        $('#BaseSummarySplitChart').highcharts(base_summary_chart);

        //console.log(all_cactus_data);
    }

    function draw_base_summary_raw_chart() {
        var base_summary_chart = my_base_summary_chart;
        var selected_base_data = get_selected_base_raw_data();
        base_summary_chart.title.text = 'CACTUS$ Costing';
        base_summary_chart.subtitle.text = 'All TACH records. US$ 2016 [Coloured by element]';
        base_summary_chart.series[0] = {name : 'TACH', data : selected_base_data.base_data};
        base_summary_chart.xAxis.categories = selected_base_data.labels;
        base_summary_chart.yAxis.title.text = "TACH (US$ 2016)";
        base_summary_chart.yAxis.max = null;
        base_summary_chart.tooltip.formatter = function(){
            var text;
            text = '<em>' + this.x + '</em><br />Country: <b>' + this.point.country+ '</b><br />City: <b>' + this.point.city + '</b><br />Element: <b>' + this.point.element + '</b>' ;
            return  text;
        };
        base_summary_chart.exporting.filename = 'cactus_costing_tach_' + (new Date()).getFullYear();

        $('#BaseSummaryRawChart').show();
        $('#BaseSummaryRawChart').highcharts(base_summary_chart);

        //console.log(all_cactus_data);
    }

    function draw_bubble_base_summary_chart() {
        var bubble_base_summary_chart = my_bubble_base_summary_chart;

        var selected_bubble_base_data = get_bubble_selected_base_data();
        bubble_base_summary_chart.title.text = 'CACTUS$ Costing : Bubble chart (coloured by component)';
        bubble_base_summary_chart.subtitle.text = 'TACH US$ 2016';
        bubble_base_summary_chart.series = selected_bubble_base_data;
        bubble_base_summary_chart.plotOptions.packedbubble.layoutAlgorithm.splitSeries = false;
        bubble_base_summary_chart.plotOptions.packedbubble.layoutAlgorithm.gravitationalConstant = 0.03;
        // tweak the size
        bubble_base_summary_chart.plotOptions.packedbubble.minSize = '30%';
        bubble_base_summary_chart.plotOptions.packedbubble.maxSize = '120%';

        bubble_base_summary_chart.exporting.filename = 'cactus_costing_bubble_tach_' + (new Date()).getFullYear();

        $('#BubbleBaseSummaryChart').show();
        $('#BubbleBaseSummaryChart').highcharts(bubble_base_summary_chart);

        //console.log(all_cactus_data);
    }

    function draw_bubble_base_summary_split_chart() {
        var bubble_base_summary_chart = my_bubble_base_summary_chart;

        var selected_bubble_base_data = get_bubble_selected_base_data();
        bubble_base_summary_chart.title.text = 'CACTUS$ Costing : Bubble chart (Split by component)';
        bubble_base_summary_chart.subtitle.text = 'TACH US$ 2016';
        bubble_base_summary_chart.series = selected_bubble_base_data;
        bubble_base_summary_chart.plotOptions.packedbubble.layoutAlgorithm.splitSeries = true;
        bubble_base_summary_chart.plotOptions.packedbubble.layoutAlgorithm.gravitationalConstant = 0.02;

        // tweak the size
        bubble_base_summary_chart.plotOptions.packedbubble.minSize = '30%';
        bubble_base_summary_chart.plotOptions.packedbubble.maxSize = '120%';

        bubble_base_summary_chart.exporting.filename = 'cactus_costing_bubble_tach_' + (new Date()).getFullYear();

        $('#BubbleBaseSummarySplitChart').show();
        $('#BubbleBaseSummarySplitChart').highcharts(bubble_base_summary_chart);

        //console.log(all_cactus_data);
    }

    function get_selected_base_data(){
        var base_data = new Array();
        var containment_min = 10e6;
        var containment_max = -10e6;
        var emptying_min = 10e6;
        var emptying_max = -10e6;
        var treatment_min = 10e6;
        var treatment_max = -10e6;
        var n_containment = 0;
        var n_emptying = 0;
        var n_treatment = 0;
        for(var i = 0; i < all_cactus_data.length ; i++){
            // check if selected
            var id = all_cactus_data[i].id;
            var id_name = "#chk_" + id;
            if($(id_name).is(':checked')){
                //
                // Elements:
                // Containment
                // Emptying and transport
                // Treatment
                var element = all_cactus_data[i].element;

                var tach = parseFloat(all_cactus_data[i].tach);
                if (element.toUpperCase() == "CONTAINMENT") {
                    if (tach > containment_max) {
                        containment_max = tach;
                    }
                    if (tach < containment_min) {
                        containment_min = tach;
                    }
                    n_containment++;
                }
                if (element.toUpperCase() == "EMPTYING AND TRANSPORT") {
                    if (tach > emptying_max) {
                        emptying_max = tach;
                    }
                    if (tach < emptying_min) {
                        emptying_min = tach;
                    }
                    n_emptying++;
                }
                if (element.toUpperCase() == "TREATMENT") {
                    if (tach > treatment_max) {
                        treatment_max = tach;
                    }
                    if (tach < treatment_min) {
                        treatment_min = tach;
                    }
                    n_treatment++;
                }
            }
        }

        var data = {low: parseFloat(containment_min), y: parseFloat(containment_max), n: n_containment};
        base_data.push(data);
        data = {low: parseFloat(emptying_min), y: parseFloat(emptying_max), n: n_emptying };
        base_data.push(data);
        data = {low: parseFloat(treatment_min), y: parseFloat(treatment_max), n: n_treatment};
        base_data.push(data);

        return base_data;
    }

    function get_selected_base_raw_data(){
        var base_data = new Array();
        var label_data = new Array();

        var colors = ["#7cb5ec", "#434348", "#90ed7d"];
        for(var i = 0; i < all_cactus_data.length ; i++){
            // check if selected
            var id = all_cactus_data[i].id;
            var id_name = "#chk_" + id;
            if($(id_name).is(':checked')){
                //
                // Elements:
                // Containment
                // Emptying and transport
                // Treatment
                var element = all_cactus_data[i].element;
                var city = all_cactus_data[i].city;
                var country = all_cactus_data[i].city;

                var tach = parseFloat(all_cactus_data[i].tach);

                var k;
                if (element.toUpperCase() == "CONTAINMENT") {
                    k=0;
                }else if (element.toUpperCase() == "EMPTYING AND TRANSPORT") {
                    k=1;
                }else{
                    k = 2;
                }
                var data = {y: parseFloat(tach), country: country, city: city, element: element, color: colors[k]};
                var label = id + ': ' + city;
                base_data.push(data);
                label_data.push(label);
            }
        }

        return {base_data: base_data, labels: label_data};
    }

    function onlyUnique(value, index, self) {
        return self.indexOf(value) === index;
    }

    function get_range(val_min, val_max, n){
        // this assumes a non set max < 0, non set min > 0
        var range = 0;
        if(n == 0){
            range = 0;
        }else if(n == 1){
            if(val_max > 0){
                range = val_max;
            }else{
                range = val_min;
            }
        }else{
            range = val_max - val_min;
        }

        return parseFloat(range.toFixed(2));
    }
    function get_selected_base_split_data(){
        // Split the base data into countries and element
        var countries = new Array();
        var base_data = new Array();
        var containment_min = [];
        var containment_max = [];
        var emptying_min = [];
        var emptying_max = [];
        var treatment_min = [];
        var treatment_max = [];
        var n_containment = [];
        var n_emptying = [];
        var n_treatment = [];

        var i, j;
        var country_index;

        // Get list of countries
        var all_cactus_countries = new Array();
        var unique_countries;
        for(i = 0; i < all_cactus_data.length ; i++){
            all_cactus_countries.push(all_cactus_data[i].country);
        }
        unique_countries = all_cactus_countries.filter(onlyUnique);

        // initialise
        for( j = 0 ; j < unique_countries.length; j++) {
            containment_min.push(10e6);
            containment_max.push(-10e6);
            emptying_min.push(10e6);
            emptying_max.push(-10e6);
            treatment_min.push(10e6);
            treatment_max.push(-10e6);
            n_containment.push(0);
            n_emptying.push(0);
            n_treatment.push(0);
        }

        for (i = 0; i < all_cactus_data.length; i++) {
            // Which country index
            for( j = 0 ; j < unique_countries.length; j++) {
                if (all_cactus_data[i].country == unique_countries[j]) {
                    country_index = j;
                    break;
                }
            }
            // check if selected
            var id = all_cactus_data[i].id;
            var id_name = "#chk_" + id;
            if ($(id_name).is(':checked')) {
                //
                // Elements:
                // Containment
                // Emptying and transport
                // Treatment
                var element = all_cactus_data[i].element;

                var tach = parseFloat(all_cactus_data[i].tach);
                if (element.toUpperCase() == "CONTAINMENT") {
                    if (tach > containment_max[country_index]) {
                        containment_max[country_index] = tach;
                    }
                    if (tach < containment_min[country_index]) {
                        containment_min[country_index] = tach;
                    }
                    n_containment[country_index]++;
                }
                if (element.toUpperCase() == "EMPTYING AND TRANSPORT") {
                    if (tach > emptying_max[country_index]) {
                        emptying_max[country_index] = tach;
                    }
                    if (tach < emptying_min[country_index]) {
                        emptying_min[country_index] = tach;
                    }
                    n_emptying[country_index]++;
                }
                if (element.toUpperCase() == "TREATMENT") {
                    if (tach > treatment_max[country_index]) {
                        treatment_max[country_index] = tach;
                    }
                    if (tach < treatment_min[country_index]) {
                        treatment_min[country_index] = tach;
                    }
                    n_treatment[country_index]++;
                }
            }
        }

        var containment_base_data = [];
        var emptying_base_data = [];
        var treatment_base_data = [];
        for( j = 0 ; j < unique_countries.length; j++) {
            var range = get_range(containment_min[j],containment_max[j],n_containment[j]);

            var data = {y: range, n: n_containment[j]};
            containment_base_data.push(data);

            range = get_range(emptying_min[j],emptying_max[j],n_emptying[j]);
            data = {y: range, n: n_emptying[j]};
            emptying_base_data.push(data);

            range = get_range(treatment_min[j],treatment_max[j],n_treatment[j]);
            data = {y: range, n: n_treatment[j]};
            treatment_base_data.push(data);
        }
        data = {name: "Containment", data: containment_base_data};
        //containment_base_data.push(data);
        base_data.push(data);
        data = {name: "Emptying and Transport", data: emptying_base_data};
        //emptying_base_data.push(data);
        base_data.push(data);
        data = {name: "Treatment", data: treatment_base_data};
        //treatment_base_data.push(data);
        base_data.push(data);

        return {base_data: base_data, countries: unique_countries};
    }

    function get_bubble_selected_base_data(){
        var bubble_base_data = new Array();
        var containment = new Array();
        var emptying = new Array();
        var treatment = new Array();


        for(var i = 0; i < all_cactus_data.length ; i++){
            // check if selected
            var id = all_cactus_data[i].id;
            var id_name = "#chk_" + id;
            if($(id_name).is(':checked')){
                //
                // Elements:
                // Containment
                // Emptying and transport
                // Treatment
                var element = all_cactus_data[i].element;
                var name = all_cactus_data[i].city + ': ' + all_cactus_data[i].component;
                var city = all_cactus_data[i].city;
                var cat = all_cactus_data[i].component;
                var data;
                var tach = parseFloat(all_cactus_data[i].tach);
                if (element.toUpperCase() == "CONTAINMENT") {
                    data = {name: city, value: tach, cat: cat};
                    containment.push(data);
                }
                if (element.toUpperCase() == "EMPTYING AND TRANSPORT") {
                    data = {name: city, value: tach, cat: cat};
                    emptying.push(data);
                }
                if (element.toUpperCase() == "TREATMENT") {
                    data = {name: city, value: tach, cat: cat};
                    treatment.push(data);
                }
            }
        }


        data = {name: "Containment", data: containment};
        bubble_base_data.push(data);
        data = {name: "Empyting and Transport", data: emptying};
        bubble_base_data.push(data);
        data = {name: "treatment", data: treatment};
        bubble_base_data.push(data);

        return bubble_base_data;
    }
