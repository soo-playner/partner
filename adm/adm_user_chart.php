<!-- Styles -->
<style>
#chartdiv {
  width: 100%;
  height: 300px;
}

</style>

<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

<!-- Chart code -->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

var chart = am4core.create("chartdiv", am4charts.XYChart);
chart.hiddenState.properties.opacity = 0; // this makes initial fade in effect

chart.data = [{
  "country": "20.08",
  "value": 3025
}, {
  "country": "20.09",
  "value": 1882
}, {
  "country": "20.10",
  "value": 1809
}, {
  "country": "20.11",
  "value": 1322
}, {
  "country": "20.12",
  "value": 1122
}, {
  "country": "21.01",
  "value": -1114
}, {
  "country": "21.02",
  "value": -984
}, {
  "country": "21.03",
  "value": 711
}, {
  "country": "21.04",
  "value": 665
}, {
  "country": "21.05",
  "value": -580
}, {
  "country": "21.06",
  "value": 443
}, {
  "country": "21.07",
  "value": 441
}];


var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.dataFields.category = "country";
categoryAxis.renderer.minGridDistance = 40;

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

var series = chart.series.push(new am4charts.CurvedColumnSeries());
series.dataFields.categoryX = "country";
series.dataFields.valueY = "value";
series.tooltipText = "{valueY.value}"
series.columns.template.strokeOpacity = 0;

series.columns.template.fillOpacity = 0.75;

var hoverState = series.columns.template.states.create("hover");
hoverState.properties.fillOpacity = 1;
hoverState.properties.tension = 0.4;

chart.cursor = new am4charts.XYCursor();

// Add distinctive colors for each column using adapter
series.columns.template.adapter.add("fill", function(fill, target) {
  return chart.colors.getIndex(target.dataItem.index);
});

chart.scrollbarX = new am4core.Scrollbar();

}); // end am4core.ready()
</script>

<!-- HTML -->
<div id="chartdiv"></div>