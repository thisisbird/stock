@extends('layout.app')

@section('header')
<link rel="stylesheet" href="/dist/assets/vendors/apexcharts/apexcharts.css">
@endsection
@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Apexcharts</h3>
                <p class="text-subtitle text-muted">A chart for user </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Apexcharts</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        {{-- <h4>Radial Gradient Chart</h4> --}}
                    </div>
                    <div class="card-body">
                        <div id="candle"></div>
                        <div id="candle_bar"></div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        {{-- <h4>Radial Gradient Chart</h4> --}}
                    </div>
                    <div class="card-body">
                        <div id="chart"></div>
                        <div id="chart_bar"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('footer')
<script src="/dist/assets/vendors/apexcharts/apexcharts.js"></script>
<script>
    var candleOptions = {
        series: [{
            name: "candle",
            data: [{
                    x: new Date(1538778600000),
                    y: [6629.81, 6650.5, 6623.04, 6633.33],
                },
                {
                    x: new Date(1538780400000),
                    y: [6632.01, 6643.59, 6620, 6630.11],
                },
                {
                    x: new Date(1538782200000),
                    y: [6630.71, 6648.95, 6623.34, 6635.65],
                },
            ],
        }, ],
        chart: {
            height: 500,
            id: 'candle',
            type: "candlestick",
        },
        title: {
            text: "CandleStick Chart - Category X-axis",
            align: "left",
        },
        annotations: {
            xaxis: [{
                x: "2018-10-06 07:00",
                borderColor: "#00E396",
                label: {
                    borderColor: "#00E396",
                    style: {
                        fontSize: "12px",
                        color: "#fff",
                        background: "#00E396",
                    },
                    orientation: "horizontal",
                    offsetY: 7,
                    text: "標記",
                },
            }, ],
            yaxis: [{
                y: 6632,
                borderColor: "#00E396",
                label: {
                    borderColor: "#00E396",
                    style: {
                        fontSize: "12px",
                        color: "#fff",
                        background: "#00E396",
                    },
                    offsetY: 7,
                    text: "標記Y",
                },
            }, ],
            points: [{
                x: '2018-10-06 07:00',
                y: 6632,
                marker: {
                    size: 8,
                },
                label: {
                    borderColor: '#FF4560',
                    text: 'Point Annotation'
                }
            }]
        },
        tooltip: {
            enabled: true,
        },
        xaxis: {
            type: "category",
            labels: {
                formatter: function (val) {
                    return dayjs(val).format("YYYY-MM-DD HH:mm");
                },
            },
        },
        yaxis: {
            tooltip: {
                enabled: true,
            },
        },
    };
    var candle = new ApexCharts(document.querySelector("#candle"), candleOptions);
    candle.render();


    var optionsBar = {
        series: [{
            name: 'volume',
            data: [{
                    x: new Date(1538778600000),
                    y: 1000,
                },
                {
                    x: new Date(1538780400000),
                    y: 2000,
                },
                {
                    x: new Date(1538782200000),
                    y: 3000,
                },
            ]
        }],
        chart: {
            height: 160,
            type: 'bar',
            brush: {
                enabled: true,
                target: 'candle'
            },
            selection: {
                enabled: true,
                xaxis: {
                    min: new Date(1538778600000),
                    max: new Date(1538782200000)
                },
                fill: {
                    color: '#ccc',
                    opacity: 0.4
                },
                stroke: {
                    color: '#0D47A1',
                }
            },
        },
        dataLabels: {
            enabled: false
        },
        plotOptions: {
            bar: {
                columnWidth: '80%',
                colors: {
                    ranges: [{
                        from: -1000,
                        to: 0,
                        color: '#F15B46'
                    }, {
                        from: 1,
                        to: 10000,
                        color: '#FEB019'
                    }],

                },
            }
        },
        stroke: {
            width: 0
        },
        xaxis: {
            type: 'datetime',
            axisBorder: {
                offsetX: 13
            }
        },
        yaxis: {
            labels: {
                show: true
            }
        }
    };

    var candle_bar = new ApexCharts(document.querySelector("#candle_bar"), optionsBar);
    // candle_bar.render();

</script>

<script>
    var info = @json($info);
    console.log(info);
    var options = {
        series: [
            {
            name: 'line',
            type: 'line',
            data: info.kline
        },
         {
            name: 'candle',
            type: 'candlestick',
            data: info.kline
        }],
        chart: {
            id: 'chart',
            group:'group_1',
            height: 350,
            type: 'line',
        },
        dataLabels: {
            enabled: false
        },
        title: {
            text: 'CandleStick Chart',
            align: 'left'
        },
        stroke: {
            width: [3, 1]
        },
        tooltip: {
            shared: true,
            enabled: true,

            custom: [function ({
                seriesIndex,
                dataPointIndex,
                w
            }) {
                return w.globals.series[seriesIndex][dataPointIndex]
            }, function ({
                seriesIndex,
                dataPointIndex,
                w
            }) {
                var o = w.globals.seriesCandleO[seriesIndex][dataPointIndex]
                var h = w.globals.seriesCandleH[seriesIndex][dataPointIndex]
                var l = w.globals.seriesCandleL[seriesIndex][dataPointIndex]
                var c = w.globals.seriesCandleC[seriesIndex][dataPointIndex]
                return `${o}<br>${h}<br>${l}<br>${c}`
            }]
        },
        xaxis: {
            type: 'category'
        },yaxis: {
            tooltip: {
                enabled: true,
            },
        },
    };
    var options_bar = {
        series: [{
            name: 'line',
            type: 'bar',
            data: info.volume
        }],
        chart: {
            id: 'chart_bar',
            group:'group_1',
            height: 160,
            type: 'line',
        },
        dataLabels: {
            enabled: false
        },
        title: {
            text: '',
            align: 'left'
        },
        stroke: {
            width: [3, 1]
        },
        tooltip: {
            enabled: true,
        },
        xaxis: {
            type: 'category'
        },
        yaxis:{
            labels: {
          show: true,
          align: 'right',
          minWidth: 0,
          maxWidth: 160,
          style: {
              colors: [],
              fontSize: '12px',
              fontFamily: 'Helvetica, Arial, sans-serif',
              fontWeight: 400,
              cssClass: 'apexcharts-yaxis-label',
          },
          offsetX: 0,
          offsetY: 0,
          rotate: 0,
          formatter: (value) => { return value+'k' },
      },
        }
        
        
        
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();


    var chart_bar = new ApexCharts(document.querySelector("#chart_bar"), options_bar);
    chart_bar.render();
</script>
@endsection
