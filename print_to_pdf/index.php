<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index Page</title>

    <style>
        @media print {
            @page {
                margin: 0;
                size: auto;
            }

            body {
                margin: 5cm;
            }

        }

        /* Specific width for Description column */
        .description-column {
            width: 25px !important;
            /* Sets the width for Description column */
        }

        header {
            margin-bottom: 30px;
        }
        iframe {
            width: 100%;
            height: 500px;
            border: none;
            display: none;
            /* Initially hide the iframe */
        }

        button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <h1>Dashboard</h1>
    <button onclick="printGraph()" id="printButton">Print Graph</button>
    <iframe id="graphIframe" src="graph_index.php"></iframe>

    <script>
        function printGraph() {
            var iframe = document.getElementById('graphIframe');
            var iframeDocument = iframe.contentDocument || iframe.contentWindow.document;

            // Unhide the title before printing

            var title = iframeDocument.getElementById('reportsTitle');
            var title1 = iframeDocument.getElementById('reportsTitle1');

            if (title && title1) {
                title.style.display = 'block';
                title1.style.display = 'block';
            }

            iframe.contentWindow.print();

            // Hide the title again after printing
            if (title && title1) {
                title.style.display = 'none';
                title1.style.display = 'none';
            }


        }

        // Optionally show the iframe when the page loads
        window.onload = function() {
            var iframe = document.getElementById('graphIframe');
            iframe.style.display = 'block'; // Show the iframe
        };
    </script>
</body>

</html>