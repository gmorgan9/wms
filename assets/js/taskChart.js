fetch('../app/functions/taskGraph.php')
    .then(response => response.json())
    .then(data => {
        // Extract x_values and y_values from the response
        const daysOfWeek = data.map(item => item.x_value);
        const taskCounts = data.map(item => item.y_value);

        // Define gradient colors for background and border
        const gradientBackground = 'rgba(39, 92, 176, 0.2)';
        const gradientBorder = 'rgba(39, 92, 176, 1)';

        // Generate chart
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: daysOfWeek, // Use days of the week as labels
                datasets: [{
                    label: 'Tasks Count',
                    data: taskCounts, // Use task counts as data
                    backgroundColor: gradientBackground,
                    borderColor: gradientBorder,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    })
    .catch(error => console.error('Error fetching data:', error));
