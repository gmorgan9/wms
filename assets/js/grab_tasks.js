document.addEventListener("DOMContentLoaded", function() {
    const taskContainer = document.getElementById("taskContainer");
    const showMoreBtn = document.getElementById("showMoreBtn");

    // Function to format the date
    function formatDate(dateString) {
        const options = { day: '2-digit', month: 'short', year: 'numeric' };
        const date = new Date(dateString);
        return date.toLocaleDateString('en-GB', options);
    }

    // Example usage:
    // const formattedDate = formatDate(task.updated_at);


    // Function to fetch tasks from PHP file
    function fetchTasks() {
        axios.get("../app/functions/latestTasks.php")
            .then(response => {
                const tasks = response.data;
                console.log("Received tasks:", tasks); // Log received tasks

                // Clear existing tasks
                taskContainer.innerHTML = '';

                // Render tasks as cards
                tasks.forEach(task => {
                    const taskCard = document.createElement("div");
                    taskCard.classList.add("task-card");
                    taskCard.innerHTML = `
                        <p class="text-secondary fw-semibold my-auto text-truncate" style="max-width: 200px;">${task.title}</p>
                        <p class="text-secondary my-auto ms-4">${formatDate(task.updated_at)}</p>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: ${task.progress}%" aria-valuenow="${task.progress}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <p class="text-secondary my-auto" style="margin-left: 80px;">${task.client_name}</p>
                        <p class="text-secondary my-auto end"><i class="bi bi-three-dots-vertical"></i></p>
                    `;
                    taskContainer.appendChild(taskCard);
                });
            })
            .catch(error => {
                console.error("Error fetching tasks:", error);
                // Handle error (e.g., display a message to the user)
            });
    }

    // Fetch tasks when the page loads
    fetchTasks();

    // // Event listener for "Show More" button
    // showMoreBtn.addEventListener("click", function() {
    //     // Fetch more tasks and append them to the task container
    //     fetchTasks();
    //     // Hide the "Show More" button after clicking
    //     showMoreBtn.style.display = "none";
    // });
});