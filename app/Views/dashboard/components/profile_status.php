<script>

    $(document).ready(function () {
        // Sparkline Charts
        $('.inlinebar').sparkline('html', { type: 'bar', barColor: '#ff6264' });
        $('.inlinebar-2').sparkline('html', { type: 'bar', barColor: '#445982' });
        $('.inlinebar-3').sparkline('html', { type: 'bar', barColor: '#00b19d' });
        // $('.bar').sparkline([ [1,4], [2, 3], [3, 2], [4, 1] ], { type: 'bar' });
        // $('.pie').sparkline('html', {type: 'pie',borderWidth: 0, sliceColors: ['#3d4554', '#ee4749','#00b19d']});
        // $('.linechart').sparkline();
    })

</script>

<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="panel-title">Latest Updated Profiles</div>

        <div class="panel-options">
            <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i
                    class="entypo-cog"></i></a>
            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
            <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
            <a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
        </div>
    </div>

    <table class="table table-bordered table-responsive">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Position</th>
                <th>Activity</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>1</td>
                <td>Art Ramadani</td>
                <td>CEO</td>
                <td class="text-center"><span class="inlinebar">4,3,5,4,5,6</span></td>
            </tr>

            <tr>
                <td>2</td>
                <td>Ylli Pylla</td>
                <td>Font-end Developer</td>
                <td class="text-center"><span class="inlinebar-2">1,3,4,5,3,5</span></td>
            </tr>

            <tr>
                <td>3</td>
                <td>Arlind Nushi</td>
                <td>Co-founder</td>
                <td class="text-center"><span class="inlinebar-3">5,3,2,5,4,5</span></td>
            </tr>

        </tbody>
    </table>
</div>