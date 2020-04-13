
var student_id = $('div#columnchart_values').attr('class');
$.ajax({
    url:'/diagramm_data',
    type: "POST",
    dataType: "json",
    data: {
        "student":student_id
    },
    success: function (data)
    {
        var array = [];
        $.each(data, function (index, value) {
            array.push(value);
        });
        google.charts.load('current', {
            packages: ['corechart', 'bar']
        });

        google.charts.setOnLoadCallback(drawBasic);
        function drawBasic() {

            var data = google.visualization.arrayToDataTable(array);
            var options = {
                title: 'Прогресс занятий',
                hAxis: {
                    title: 'Дата урока'
                },
                vAxis: {
                    title: 'Оценка',
                    minValue: 1,
                    ticks: [2,4,6,8,10,12]
                }
            };

            var chart = new google.visualization.ColumnChart(
                document.getElementById('columnchart_values'));

            chart.draw(data, options);
        }

    }});





