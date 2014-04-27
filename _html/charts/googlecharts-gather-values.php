<div id="googlecharts-gather-values"></div>
<script type="text/javascript">
  // Set a callback to run when the Google Visualization API is loaded.
  google.setOnLoadCallback(draw__gather_values);

  // Callback that creates and populates a data table,
  // instantiates the pie chart, passes in the data and
  // draws it.
  function draw__gather_values() {

    <?php
        $req = "SELECT COUNT(*) AS countnotnull, (SELECT COUNT(*) FROM gather_items WHERE details LIKE '') AS countnull FROM gather_items WHERE details NOT LIKE '';";
        $res = db_ask($req);
        $noDataCount = $res[0]["countnull"];
        $dataCount = $res[0]["countnotnull"];
    ?>
    // Create the data table.
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Topping');
    data.addColumn('number', 'Slices');
    data.addRows([
      ['JSON data', <?php echo $dataCount ?>],
      ['No data', <?php echo $noDataCount ?>]
    ]);

    // Set chart options
    var options = {'title':'Raw Data Content Repartition',
                   'width':400,
                   'height':300};

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.PieChart(document.getElementById("googlecharts-gather-values"));
    chart.draw(data, options);
  }
</script>