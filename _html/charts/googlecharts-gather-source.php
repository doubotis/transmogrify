<div id="googlecharts-gather-source"></div>
<script type="text/javascript">
  // Set a callback to run when the Google Visualization API is loaded.
  google.setOnLoadCallback(draw__gather_source);

  // Callback that creates and populates a data table,
  // instantiates the pie chart, passes in the data and
  // draws it.
  function draw__gather_source() {

    <?php
        $req = "SELECT DISTINCT origin, COUNT(*) AS count FROM gather_items GROUP BY origin";
        $res = db_ask($req);
        $serverCount = "0";
        $clientCount = "0";
        $othersCount = "0";
        for ($i=0; $i < count($res); $i++)
        {
            if ($res[$i]["origin"] == "server")
                $serverCount = $res[$i]["count"];
            else if ($res[$i]["origin"] == "client")
                $clientCount = $res[$i]["count"];
            else
                $othersCount = $res[$i]["count"];
        }
        
    ?>
    // Create the data table.
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Topping');
    data.addColumn('number', 'Slices');
    data.addRows([
      ['Server', <?php echo $serverCount ?>],
      ['Client', <?php echo $clientCount ?>],
      ['Other', <?php echo $othersCount ?>],
    ]);

    // Set chart options
    var options = {'title':'Raw Data Source Repartition',
                   'width':400,
                   'height':300};

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.PieChart(document.getElementById("googlecharts-gather-source"));
    chart.draw(data, options);
  }
</script>