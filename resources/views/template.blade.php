<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Font Example</title>
    <style>
        /* Define the Verdana font for headings (h1 to h6) */
        h1, h2, h3, h4, h5, h6,span {
            font-family: 'Kindergarten';
            src: url('{{storage_path('fonts/Kindergarten.ttf') }}') format('truetype');
        }

        /* Define the Calibri font for non-headings */
        body, p, div {
            font-family: 'Calibril';
             src: url('{{storage_path('fonts/Calibril.ttf') }}') format('truetype');
        }
        }
    </style>
</head>
<body>
    <h1>This is a Heading 1</h1>
    <p>This is a paragraph with Calibri font.</p>
    <h2>This is a Heading 2</h2>
    <span>This is a span with Calibri font.</span>
    <h3>This is a Heading 3</h3>
    <div>This is a div with Calibri font.</div>
    <!-- Add more content as needed -->
</body>
</html>
