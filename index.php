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
            flex-direction: row; /* Default: row */
            align-items: flex-start;
        }

        @media (max-width: 768px) {
            .task {
                flex-direction: column; /* Change to column on smaller screens */
                align-items: flex-start;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body style="background-color: #374151;">

<header>
    <div class="header-content">
        <h1 style="color: black;">Task List 2023</h1>
        <div class="header-buttons">
            <button id="login-button">Login</button>
            <button id="signup-button">Sign Up</button>
        </div>
    </div>
    <form id="new-task-form">
        <input 
            type="text" 
            name="new-task-input" 
            id="new-task-input" 
            placeholder="What do you have planned?" />
        <input 
            type="submit"
            id="new-task-submit" 
            value="Add task" />
    </form>
</header>
<main>
    <section class="task-list">
        <h2>Tasks :</h2>
        <div id="tasks">
        </div>
    </section>
</main>
	<script>
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
        }
    });
});

const deleteButtons = document.querySelectorAll('.delete');

deleteButtons.forEach(deleteButton => {
    deleteButton.addEventListener('click', function () {
        const task = this.closest('.task');
        task.remove();
    });
});

const newTaskForm = document.getElementById('new-task-form');

newTaskForm.addEventListener('submit', function (e) {
    e.preventDefault();
    const taskInput = document.getElementById('new-task-input');
    const taskText = taskInput.value;

    if (taskText.trim() !== '') {
        const newTask = document.createElement('div');
        newTask.classList.add('task');
        newTask.innerHTML = `
            <div class="content">
                <input type="text" class="text" value="${taskText}" readonly>
            </div>
            <div class="actions">
                <span class="custom-checkbox"></span>
                <input type="checkbox" class="checkbox">
                <span class="checkmark"></span>
                <button class="edit">Edit</button>
                <button class="delete">Delete</button>
                <select class="status" id="status-select">
                    <option value="high">Not Yet</option>
                    <option value="medium">On Progress</option>
                    <option value="low">Done</option>
                </select>
            </div>
        `;
        const taskList = document.getElementById('tasks');
        taskList.appendChild(newTask);
        taskInput.value = '';
    }
});

const taskList = document.getElementById('tasks');
function handleTaskActions(event) {
    const target = event.target;

    if (target.classList.contains('edit')) {
        const task = target.closest('.task');
        const textInput = task.querySelector('.text');
        if (textInput.hasAttribute('readonly')) {
            textInput.removeAttribute('readonly');
            textInput.focus();
            target.textContent = 'Save';
        } else {
            textInput.setAttribute('readonly', 'true');
            target.textContent = 'Edit';
        }
    } else if (target.classList.contains('delete')) {
        const task = target.closest('.task');
        task.remove();
    }
}

taskList.addEventListener('click', handleTaskActions);

const statusSelect = document.getElementById('status-select');

statusSelect.addEventListener('change', function () {
    if (statusSelect.value === 'high') {
        statusSelect.style.color = 'red';
    } else {
        statusSelect.style.color = '';
    }
});
</script>
</body>
</html>