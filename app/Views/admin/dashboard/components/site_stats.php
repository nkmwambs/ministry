<script>
    $(document).ready(function () {
        $('.pageviews').sparkline('html', { type: 'bar', height: '30px', barColor: '#ff6264' });
        $('.uniquevisitors').sparkline('html', { type: 'bar', height: '30px', barColor: '#00b19d' });


        // Line Charts
        var line_chart_demo = $("#line-chart-demo");

        var line_chart = Morris.Line({
            element: 'line-chart-demo',
            data: [
                { y: '2006', a: 100, b: 90 },
                { y: '2007', a: 75, b: 65 },
                { y: '2008', a: 50, b: 40 },
                { y: '2009', a: 75, b: 65 },
                { y: '2010', a: 50, b: 40 },
                { y: '2011', a: 75, b: 65 },
                { y: '2012', a: 100, b: 90 }
            ],
            xkey: 'y',
            ykeys: ['a', 'b'],
            labels: ['October 2013', 'November 2013'],
            redraw: true
        });

        line_chart_demo.parent().attr('style', '');


        // Donut Chart
        var donut_chart_demo = $("#donut-chart-demo");

        donut_chart_demo.parent().show();

        var donut_chart = Morris.Donut({
            element: 'donut-chart-demo',
            data: [
                { label: "Download Sales", value: getRandomInt(10, 50) },
                { label: "In-Store Sales", value: getRandomInt(10, 50) },
                { label: "Mail-Order Sales", value: getRandomInt(10, 50) }
            ],
            colors: ['#707f9b', '#455064', '#242d3c']
        });

        donut_chart_demo.parent().attr('style', '');


        // Area Chart
        var area_chart_demo = $("#area-chart-demo");

        area_chart_demo.parent().show();

        var area_chart = Morris.Area({
            element: 'area-chart-demo',
            data: [
                { y: '2006', a: 100, b: 90 },
                { y: '2007', a: 75, b: 65 },
                { y: '2008', a: 50, b: 40 },
                { y: '2009', a: 75, b: 65 },
                { y: '2010', a: 50, b: 40 },
                { y: '2011', a: 75, b: 65 },
                { y: '2012', a: 100, b: 90 }
            ],
            xkey: 'y',
            ykeys: ['a', 'b'],
            labels: ['Series A', 'Series B'],
            lineColors: ['#303641', '#576277']
        });

        area_chart_demo.parent().attr('style', '');

    })

    function getRandomInt(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }


</script>

<div class="panel panel-primary" id="charts_env">

    <div class="panel-heading">
        <div class="panel-title">Site Stats</div>

        <div class="panel-options">
            <ul class="nav nav-tabs">
                <li class=""><a href="#area-chart" data-toggle="tab">Area Chart</a></li>
                <li class="active"><a href="#line-chart" data-toggle="tab">Line Charts</a></li>
                <li class=""><a href="#pie-chart" data-toggle="tab">Pie Chart</a></li>
            </ul>
        </div>
    </div>

    <div class="panel-body">

        <div class="tab-content">

            <div class="tab-pane" id="area-chart">
                <div id="area-chart-demo" class="morrischart" style="height: 300px"></div>
            </div>

            <div class="tab-pane active" id="line-chart">
                <div id="line-chart-demo" class="morrischart" style="height: 300px"></div>
            </div>

            <div class="tab-pane" id="pie-chart">
                <div id="donut-chart-demo" class="morrischart" style="height: 300px;"></div>
            </div>

        </div>

    </div>

    <table class="table table-bordered table-responsive">

        <thead>
            <tr>
                <th width="50%" class="col-padding-1">
                    <div class="pull-left">
                        <div class="h4 no-margin">Pageviews</div>
                        <small>54,127</small>
                    </div>
                    <span class="pull-right pageviews">4,3,5,4,5,6,5</span>

                </th>
                <th width="50%" class="col-padding-1">
                    <div class="pull-left">
                        <div class="h4 no-margin">Unique Visitors</div>
                        <small>25,127</small>
                    </div>
                    <span class="pull-right uniquevisitors">2,3,5,4,3,4,5</span>
                </th>
            </tr>
        </thead>

    </table>

</div>