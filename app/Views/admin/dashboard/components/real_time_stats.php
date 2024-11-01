<script>
    $(document).ready(function () {

        // Rickshaw
        var seriesData = [[], []];

        var random = new Rickshaw.Fixtures.RandomData(50);

        for (var i = 0; i < 50; i++) {
            random.addData(seriesData);
        }

        var graph = new Rickshaw.Graph({
            element: document.getElementById("rickshaw-chart-demo"),
            height: 193,
            renderer: 'area',
            stroke: false,
            preserve: true,
            series: [{
                color: '#73c8ff',
                data: seriesData[0],
                name: 'Upload'
            }, {
                color: '#e0f2ff',
                data: seriesData[1],
                name: 'Download'
            }
            ]
        });

        graph.render();

        var hoverDetail = new Rickshaw.Graph.HoverDetail({
            graph: graph,
            xFormatter: function (x) {
                return new Date(x * 1000).toString();
            }
        });

        var legend = new Rickshaw.Graph.Legend({
            graph: graph,
            element: document.getElementById('rickshaw-legend')
        });

        var highlighter = new Rickshaw.Graph.Behavior.Series.Highlight({
            graph: graph,
            legend: legend
        });

        setInterval(function () {
            random.removeData(seriesData);
            random.addData(seriesData);
            graph.update();

        }, 500);
    })
</script>

<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="panel-title">
            <h4>
                Real Time Stats
                <br />
                <small>current server uptime</small>
            </h4>
        </div>

        <div class="panel-options">
            <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i
                    class="entypo-cog"></i></a>
            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
            <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
            <a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
        </div>
    </div>

    <div class="panel-body no-padding">
        <div id="rickshaw-chart-demo">
            <div id="rickshaw-legend"></div>
        </div>
    </div>
</div>