<div id="googlecharts-gather-transfer"></div>
<script type="text/javascript">
  // Set a callback to run when the Google Visualization API is loaded.
  google.setOnLoadCallback(draw__gather_transfer);

  // Callback that creates and populates a data table,
  // instantiates the pie chart, passes in the data and
  // draws it.
  function draw__gather_transfer() {

    <?php
        $req = "SELECT COUNT(*) AS valid, (SELECT COUNT(*) FROM gather_items WHERE status = 2) AS wrong, 
            (SELECT COUNT(*) FROM gather_items WHERE status = 3) AS passed FROM gather_items WHERE status = 1";
        $res = db_ask($req);
        $valid = $res[0]["valid"];
        $wrong = $res[0]["wrong"];
        $passed = $res[0]["passed"];
    ?>
    // Create the data table.
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Topping');
    data.addColumn('number', 'Slices');
    data.addRows([
      ['Done', <?php echo $valid ?>],
      ['Wrong data', <?php echo $wrong ?>],
      ['Bypassed', <?php echo $passed ?>],
    ]);

    // Set chart options
    var options = {'title':'Transfer Result Repartition',
                   'width':400,
                   'height':300};

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.PieChart(document.getElementById("googlecharts-gather-transfer"));
    chart.draw(data, options);
  }
</script>