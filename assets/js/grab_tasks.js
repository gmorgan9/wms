document.addEventListener("DOMContentLoaded", function() {
    const taskContainer = document.getElementById("taskContainer");

    // Function to format the date
    function formatDate(dateString) {
        const options = { day: '2-digit', month: 'short', year: 'numeric' };
        const date = new Date(dateString);
        return date.toLocaleDateString('en-GB', options);
    }

    // Function to create and show the popup menu
    function showPopupMenu(event, taskId) {
        event.preventDefault();

        const popupMenu = document.createElement("div");
        popupMenu.classList.add("popup-menu");
        popupMenu.innerHTML = `
            <ul>
                <li onclick="viewTask(${taskId})">View</li>
                <li onclick="editTask(${taskId})">Edit</li>
                <li onclick="deleteTask(${taskId})">Delete</li>
            </ul>
        `;

        // Position the popup menu relative to the click event
        popupMenu.style.top = `${event.clientY}px`;
        popupMenu.style.left = `${event.clientX}px`;

        // Append the popup menu to the document body
        document.body.appendChild(popupMenu);

        // Close the popup menu when clicking outside of it
        document.addEventListener("click", closePopupMenu);
    }

    // Function to close the popup menu
    function closePopupMenu(event) {
        const popupMenu = document.querySelector(".popup-menu");
        if (popupMenu && !popupMenu.contains(event.target)) {
            popupMenu.remove();
            document.removeEventListener("click", closePopupMenu);
        }
    }

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
                        <p class="text-secondary my-auto end">
                            <a href="#" onclick="showPopupMenu(event, ${task.id})"><i class="bi bi-three-dots-vertical"></i></a>
                        </p>
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
});
