/**
 * Created by cenpas on 02/02/2017.
 */
//Highcharts.chart('ContainerTeachingHoursChart',

var chart;

var my_base_summary_chart =    {
    chart: {
        type: 'column'
    },
    title: {
        text: 'CACTU$ Costing'
    },
    subtitle: {
        text: 'TACH values'
    },
    xAxis: {
        categories: ['Containment', 'Emptying and Transport', 'Treatment'],
        title: {
            text: null
        },
        labels: {
            groupedOptions: [{
                style: {
                    color: 'maroon' // set red font for labels in 1st-Level
                },
                rotation: 0
            }],
            rotation: 90,
            align: 'left',
            style: {
                width: '250px',
                style: {
                    whiteSpace: "nowrap",
                    textOverflow: "ellipsis"
                }
            }
        }
    },
    // Highcharts 2.0 default colours
    colors: [
        '#4572A7', '#AA4643', '#89A54E', '#80699B', '#3D96AE',
        '#DB843D', '#92A8CD', '#A47D7C', '#B5CA92'
    ],

    yAxis: {
        min: 0,
        title: {
            text: 'Hours',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        }
    },
    tooltip: {
        valueSuffix: ' hours',
        valueDecimals: 2,
        useHTML: true,
        //headerFormat: '<em>Date: {point.key}</em><br/>',
        formatter: function(){
            var text;
            text = '<em>' + this.x + '</em><br/>Hours: '
                + '</b><BR/><em>Composed of:</em><BR /> ' + 'min: <b>' + this.low + '</b>'
                + '<BR/>' + 'max: <b>' + this.low + '</b>';
            return  text;
        }
    },
    plotOptions: {
        bar: {
            dataLabels: {
                enabled: true,
                style: {fontWeight: 'normal'}
            }
        }
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'top',
        x: -40,
        y: 80,
        floating: true,
        borderWidth: 1,
        backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
        shadow: false,
        style: {fontWeight: 'normal'}
    },
    credits: {
        enabled: true
    },
    series: [{
        name: 'Cactus',
        data: [107, 31, 635, 203, 2]
    }],
    exporting: {
        filename: "chart",
        scale: 5
        /*,
            buttons: {
            contextButton: {
                menuItems: ['printChart', 'downloadPNG', 'downloadPDF']
            }
        }*/
    }
    /*series: [{
        name: 'Planned teaching hours',
        data: [107, 31, 635, 203, 2]
    }, {
        name: 'Faculty model hours',
        data: [133, 156, 947, 408, 6]
    }, {
        name: 'School model hours',
        data: [1052, 954, 4250, 740, 38]
    }]*/
};
//);