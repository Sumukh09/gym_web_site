<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Gym</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        .options {
            text-align: center;
        }

        .exercise-list {
            margin-top: 20px;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin: 10px 0;
            cursor: pointer;
            color: blue;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        #finish-workout {
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to My Gym</h1>

        <div class="options">
            <label for="workout-type">Select a Workout Type:</label>
            <select id="workout-type">
                <option value="cardio">Cardio</option>
                <option value="full-body">Full Body Workout</option>
            </select>
        </div>

        <div class="exercise-list">
            <h2>Exercise List</h2>
            <ul id="exercise-list">
                <!-- This is where the exercise list will be displayed dynamically -->
            </ul>
        </div>

        <div class="input-container" id="exercise-details" style="display: none;">
            <h2>Exercise Details</h2>
            <label for="sets">Sets:</label>
            <input type="number" id="sets" placeholder="Enter number of sets">

            <label for="reps">Reps:</label>
            <input type="number" id="reps" placeholder="Enter number of reps">

            <label for="weight">Weight Used (lbs/kg):</label>
            <input type="number" id="weight" placeholder="Enter weight used">

            <button onclick="saveDetails()">Save</button>
        </div>

        <button id="finish-workout" onclick="finishWorkout()" style="display: none;">Finish Workout</button>

        <table id="exercise-table" style="display: none;">
            <thead>
                <tr>
                    <th>Exercise</th>
                    <th>Sets</th>
                    <th>Reps</th>
                    <th>Weight</th>
                </tr>
            </thead>
            <tbody id="exercise-table-body"></tbody>
        </table>
    </div>

    <script>
        const workoutTypeSelect = document.getElementById("workout-type");
        const exerciseList = document.getElementById("exercise-list");
        const exerciseDetails = document.getElementById("exercise-details");
        const exerciseTable = document.getElementById("exercise-table");
        const exerciseTableBody = document.getElementById("exercise-table-body");
        const finishButton = document.getElementById('finish-workout');

        let selectedExercise = null;
        let isWorkoutFinished = false;

        workoutTypeSelect.addEventListener("change", () => {
            const selectedWorkoutType = workoutTypeSelect.value;

            const cardioExercises = ["Running", "Cycling", "Jumping Jacks", "Burpees", "Swimming"];
            const fullBodyExercises = ["Push-ups", "Squats", "Planks", "Deadlifts", "Kettlebell Swings"];

            exerciseList.innerHTML = "";

            if (selectedWorkoutType === "cardio") {
                for (const exercise of cardioExercises) {
                    const li = document.createElement("li");
                    li.textContent = exercise;
                    li.addEventListener("click", () => showExerciseDetails(exercise));
                    exerciseList.appendChild(li);
                }
            } else if (selectedWorkoutType === "full-body") {
                for (const exercise of fullBodyExercises) {
                    const li = document.createElement("li");
                    li.textContent = exercise;
                    li.addEventListener("click", () => showExerciseDetails(exercise));
                    exerciseList.appendChild(li);
                }
            }
        });

        function showExerciseDetails(exercise) {
            selectedExercise = exercise;
            exerciseDetails.style.display = 'block';
            finishButton.style.display = 'block';
        }

        function saveDetails() {
            if (!isWorkoutFinished) {
                const sets = document.getElementById('sets').value;
                const reps = document.getElementById('reps').value;
                const weight = document.getElementById('weight').value;

                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>${selectedExercise}</td>
                    <td>${sets}</td>
                    <td>${reps}</td>
                    <td>${weight}</td>
                `;

                exerciseTableBody.appendChild(newRow);
                exerciseTable.style.display = 'block';

                document.getElementById('sets').value = '';
                document.getElementById('reps').value = '';
                document.getElementById('weight').value = '';

                exerciseDetails.style.display = 'none';
            }
        }

        function finishWorkout() {
            isWorkoutFinished = true;
            exerciseDetails.style.display = 'none';
            finishButton.style.display = 'none';
            document.getElementById('sets').disabled = true;
            document.getElementById('reps').disabled = true;
            document.getElementById('weight').disabled = true;
        }
    </script>
</body>
</html>