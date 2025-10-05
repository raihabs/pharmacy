<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Select Option on Load</title>
</head>

<body>
    <input type="text" id="myInput" >
    <script>
        // Get the value of the input element
        const inputField = document.getElementById('myInput');

        inputField.addEventListener('input', () => {
            if (inputField.value <= 0) {  // Change condition to <= 0
                inputField.style.borderColor = 'red';
            } else {
                inputField.style.borderColor = 'blue';
            }
        });
    </script>
</body>

</html>