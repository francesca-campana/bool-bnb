@extends('layouts.app')
@section('title')
  Le tue statistiche
@endsection

@section('content')
<section id="statistics">

  <div class="container-fluid">
      <div class="row">
          <div class="col">
              <div class="panel panel-default">
                  <div class="panel-heading">
                    <h1>{{ $apartment->title }}</h1>
                    <h3>Visualizzazioni totali {{ $month }}: {{ $totMonthlyViews }}</h3>
                    <h3>Messaggi totali {{ $month }}: {{ $totMonthlyMessages }}</h3>
                  </div>
                  <div class="panel-body">
                      <canvas id="canvas" height="350" width="1000"></canvas>
                  </div>
              </div>
          </div>
      </div>
  </div>

<script src="https://raw.githubusercontent.com/nnnick/Chart.js/master/dist/Chart.bundle.js"></script>
<script>
    var days = <?php echo json_encode($arrayDays); ?>;
    var data_viewer = <?php echo json_encode($arrayViews); ?>;
    var data_message = <?php echo json_encode($arrayMessages); ?>;


    var barChartData = {
        labels: days,
        datasets: [{
            label: 'Visualizzazioni',
            backgroundColor: "rgba(151,187,205,0.5)",
            data: data_viewer
        },
        {
              label: 'Messaggi',
              backgroundColor: "rgba(0,0,205,0.5)",
              data: data_message
          }]
    };


    window.onload = function() {
        var ctx = document.getElementById("canvas").getContext("2d");
        window.myBar = new Chart(ctx, {
            type: 'bar',
            data: barChartData,
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 2,
                        borderColor: 'rgb(0, 255, 0)',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,
                title: {
                    display: true,
                    text: 'Statistiche'
                }
            }
        });


    };
</script>
</section>
@endsection
