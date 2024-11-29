<script>
    $(document).ready(function () {
        var map = $("#map-2");

map.vectorMap({
    map: 'europe_merc_en',
    zoomMin: '3',
    backgroundColor: '#383f47',
    focusOn: { x: 0.5, y: 0.8, scale: 3 }
});
    })
</script>

<div id="map-2" class="map"></div>