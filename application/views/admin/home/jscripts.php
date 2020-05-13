<script>

  var donut = new Morris.Donut({
          element: 'sales-chart',
          colors: <?= json_encode($colours) ?>,
          data: <?php 
              echo $empsInDepts;
            ?>,
          hideHover: 'auto'
        });
</script>