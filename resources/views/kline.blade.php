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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Radial Gradient Chart</h4>
                    </div>
                    <div class="card-body">
                        <div id="candle"></div>
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
            height: 350,
            type: "candlestick",
        },
        title: {
            text: "CandleStick Chart - Category X-axis",
            align: "left",
        },
        annotations: {
            xaxis: [{
                x: "Oct 06 14:00",
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
                    text: "Annotation Test",
                },
            }, ],
        },
        tooltip: {
            enabled: true,
        },
        xaxis: {
            type: "category",
            labels: {
                formatter: function (val) {
                    return dayjs(val).format("MMM DD HH:mm");
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

</script>
@endsection
