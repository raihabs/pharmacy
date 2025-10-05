<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Select Option on Load</title>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set the value of the select element
            const selectElement = document.getElementById('category');
            selectElement.value = 'banana'; // Change 'banana' to any value that exists in the options
        });
    </script>
</head>
<body>
    <h1>Select Your Favorite Fruit</h1>
    <form>
        <label for="category">Choose a fruit:</label>
        <select id="category" name="category">
            <option value="apple">Apple</option>
            <option value="banana">Banana</option>
            <option value="orange">Orange</option>
            <option value="grape">Grape</option>
        </select>
    </form>
</body>
</html>
