<?php 
session_start();
include 'koneksi.php';

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    $userData = array();
    $user_query = "SELECT username FROM userdata WHERE id_user = $user_id";
    $user_result = $conn->query($user_query);

    if ($user_result->num_rows == 1) {
        $userData = $user_result->fetch_assoc();
    }

    $tasks = array();
    $sql = "SELECT id_task, task_name, task_status FROM listudu WHERE id_user = $user_id ORDER BY task_status DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }
    }
} else {
    header("Location: login.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List 2021</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .task {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
        }

        @media (max-width: 768px) {
            .task {
                flex-direction: column;
                align-items: flex-start;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body style="background-color: #374151;">

<header>
    <div class="header-content">
        <h1>Task List 2023</h1>
		<?php
			if(!isset($_SESSION['user_id'])){
				echo '<div class="header-buttons">';
				echo '<button id="login-button">Login</button>';
				echo '<button id="signup-button">Sign Up</button>';
				echo '</div>';
			} else {
				echo '<div class="header-buttons">';
				echo '<a style="font-size: 1.2rem;
                font-weight: 300;
                background-image: linear-gradient(to right, var(--pink), var(--purple));
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                margin-bottom: 1rem;">Wassup ' . $userData['username'] . '</a>';
                echo '<a href="login.php"><button style="background-color: #1a202c;">Logout</button></a>';
				echo '</div>';
			}
		?>
    </div>
    <form id="new-task-form" action="tasklist.php" method="post">
		<input 
			type="text" 
			name="new-task-input" 
			id="new-task-input" 
			placeholder="What do you have planned?" 
			required/>
			<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
		<input 
			type="submit"
			id="new-task-submit" 
			value="Add task" />
	</form>
</header>
<main>
<div id="tasks">
	<?php foreach ($tasks as $task) { ?>
		<div class="task">
			<div class="content mt-3">
				<input type="text" class="text" value="<?php echo $task['task_name']; ?>" data-task-id="<?php echo $task['id_task']; ?>" readonly>
			</div>
			<div class="actions">
            <label class="switch mt-2">
            <input type="checkbox" class="toggleSwitch" data-task-id="<?php echo $task['id_task']; ?>" value="<?php echo ($task['task_status']) ?>">
            <span class="slider"></span>
            </label>
            <p style="background-image: linear-gradient(to right, var(--pink), var(--purple));
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;" class="mt-3 ml-3" >Done</p>
            <button class="edit">Edit</button>
				<button class="delete" data-task-id="<?php echo $task['id_task']; ?>">Delete</button>
				<select class="status" id="status-select-<?php echo $task['id_task']; ?>" name="task_status[]">
					<option value="Not Yet" <?php echo ($task['task_status'] === 'Not Yet') ? 'selected' : ''; ?>>Not Yet</option>
					<option value="On Progress" <?php echo ($task['task_status'] === 'On Progress') ? 'selected' : ''; ?>>On Progress</option>
					<option value="Waiting On" <?php echo ($task['task_status'] === 'Waiting On') ? 'selected' : ''; ?>>Waiting On</option>
                    <option value="Done" <?php echo ($task['task_status'] === 'Done') ? 'selected' : ''; ?>>Done</option>
                </select>
			</div>
		</div>
	<?php } ?>
</div>
</main>
<script>
document.addEventListener('change', function (event) {
    const target = event.target;

    if (target.classList.contains('toggleSwitch')) {
        const taskId = target.getAttribute('data-task-id');

        if (confirm('Are you sure the task is done?')) {
            updateTaskDone(taskId);
        }
    }
});

function updateTaskDone(taskId) {
    fetch('taskDone.php', {
        method: 'POST',
        body: new URLSearchParams({ taskId: taskId }),
    })
    .then(response => {
        if (response.ok) {
            window.location.reload();
        } else {
            // Handle errors if needed
        }
    })
    .catch(error => {
        console.error('Error deleting task:', error);
    });
}

document.addEventListener('click', function (event) {
    const target = event.target;

    if (target.classList.contains('delete')) {
        const taskId = target.getAttribute('data-task-id');

        if (confirm('Are you sure you want to delete this task?')) {
            deleteTaskFromDatabase(taskId);
        }
    }
});

function deleteTaskFromDatabase(taskId) {
    fetch('deleteTask.php', {
        method: 'POST',
        body: new URLSearchParams({ taskId: taskId }),
    })
    .then(response => {
        if (response.ok) {
            window.location.reload();
        } else {
            // Handle errors if needed
        }
    })
    .catch(error => {
        console.error('Error deleting task:', error);
    });
}

document.addEventListener('change', function (event) {
    const target = event.target;

    if (target.classList.contains('status')) {
        const taskId = target.id.replace('status-select-', '');
        const newStatus = target.value;
        updateTaskStatusInDatabase(taskId, newStatus);
    }
});

function updateTaskStatusInDatabase(taskId, newStatus) {
    const formData = new FormData();
    formData.append('task_id', taskId);
    formData.append('new_status', newStatus);

    fetch('updateStatus.php', {
        method: 'POST',
        body: formData,
    })
    .catch(error => {
        console.error('Error updating task status:', error);
    });
}

const editButtons = document.querySelectorAll('.edit');

editButtons.forEach(editButton => {
    editButton.addEventListener('click', function () {
        const task = this.closest('.task');
        const textInput = task.querySelector('.text');

        if (textInput.hasAttribute('readonly')) {
            textInput.removeAttribute('readonly');
            textInput.focus();
            this.textContent = 'Save';
        } else {
            textInput.setAttribute('readonly', 'true');
            this.textContent = 'Edit';
            const newName = textInput.value;
            const taskId = textInput.getAttribute('data-task-id');
            updateTaskNameInDatabase(taskId, newName);
        }
    });
});

document.addEventListener('change', function (event) {
    const target = event.target;

    if (target.classList.contains('text')) {
        const taskId = target.getAttribute('data-task-id');
        const newName = target.value;
		console.log(taskId);
		console.log(newName);
        updateTaskNameInDatabase(taskId, newName);
    }
});

function updateTaskNameInDatabase(taskId, newName) {
    const formData2 = new FormData();
    formData2.append('task_id', taskId);
    formData2.append('new_name', newName);

    fetch('updateName.php', {
        method: 'POST',
        body: formData2,
    })
    .catch(error => {
        console.error('Error updating task name:', error);
    });
}
document.getElementById("toggleSwitch").addEventListener("change", function() {
    // Handle the change event here
    if (this.checked) {
        // Toggle is on
        // Perform actions for the "on" state
        console.log("Switch is ON");
    } else {
        // Toggle is off
        // Perform actions for the "off" state
        console.log("Switch is OFF");
    }
});
</script>
</body>
</html>