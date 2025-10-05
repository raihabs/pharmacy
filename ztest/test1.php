<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Bar Animation</title>
    <style>
        body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    background-color: #f5f5f5;
}

.progress-container {
    width: 60%;
    max-width: 500px;
    height: 20px;
    background-color: #e0e0e0;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.progress-bar {
    height: 100%;
    width: 0;
    background-color: #4caf50;
    border-radius: 15px;
    animation: progress 5s ease-in-out infinite;
}

@keyframes progress {
    from {
        width: 0;
    }
    to {
        width: 100%;
    }
}

    </style>
</head>
<body>
<div class="progress-container">
        <div class="progress-bar"></div>
    </div>
</body>
</html>
