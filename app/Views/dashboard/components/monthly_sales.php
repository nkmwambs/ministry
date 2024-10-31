<script>
    $(document).ready(function () {
        $(".monthly-sales").sparkline([1, 2, 3, 5, 6, 7, 2, 3, 3, 4, 3, 5, 7, 2, 4, 3, 5, 4, 5, 6, 3, 2], {
            type: 'bar',
            barColor: '#485671',
            height: '80px',
            barWidth: 10,
            barSpacing: 2
        });
    })
</script>

<div class="panel panel-primary">
    <table class="table table-bordered table-responsive">
        <thead>
            <tr>
                <th class="padding-bottom-none text-center">
                    <br />
                    <br />
                    <span class="monthly-sales"></span>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="panel-heading">
                    <h4>Monthly Sales</h4>
                </td>
            </tr>
        </tbody>
    </table>
</div>