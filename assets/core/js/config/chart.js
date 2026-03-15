function load_charts() {
  $(".chart").each(function(e){
    var canvas = $(this).find("canvas"),
    canvas_id = canvas.parent('div').attr('id');
    chart_ctx = $(this).find("canvas")[0],
    chart_set = chart[canvas_id],
    chart_type = chart_set.type,
    chart_data  = chart_set.data,
    chart_label = chart_set.label,
    chart_title = chart_set.chart_title,
    chart_bg_color = chart_set.bg_color,
    chart_border_color = chart_set.border_color;
    chart_y_axis = chart_set.y_axis;
    var ctx = chart_ctx.getContext('2d');
    draw_chart(ctx, chart_type, chart_title, chart_label, chart_data, chart_bg_color, chart_border_color, chart_y_axis);
  }); 
}

function draw_chart(ctx, type, title, labels, data, bg_color, border_color, y_axis) {
  new Chart(ctx, {   
    type: type,
    data: {
      labels: labels,
      datasets: [{
        label: title,
        backgroundColor: bg_color,
        borderColor: border_color,
        borderWidth: 1,
        data: data
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        yAxes: [{
          display: y_axis,
          ticks: {              
            beginAtZero: true,
            stepSize: 5
          }
        }]
      },
      legend: {
        labels: {          
          fontColor: '#1b1b1b'
        }
      } 
    }
  });
}
