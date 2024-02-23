fetch('../app/functions/auditGraph.php')
    .then(response => response.json())
    .then(data => {
        const auditTypeLabels = data.map(item => item.framework); // Use 'framework' instead of 'audit_type'
        const auditTypeCounts = data.map(item => item.count);

        const gradientBackground = 'rgba(39, 92, 176, 0.2)';
        const gradientBorder = 'rgba(39, 92, 176, 1)';

        // Render bar graph
        const ctx = document.getElementById('auditTypeChart').getContext('2d');
        const auditTypeChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: auditTypeLabels,
                datasets: [{
                    label: 'Framework Counts',
                    data: auditTypeCounts,
                    backgroundColor: gradientBackground,
                    borderColor: gradientBorder,
                    borderWidth: 1,
                    barPercentage: 0.5,
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
    .catch(error => console.error('Error fetching audit type counts:', error));
