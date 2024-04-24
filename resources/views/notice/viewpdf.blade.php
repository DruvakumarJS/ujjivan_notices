<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Open PDFs in Tabs</title>
</head>
<body>
   <script>
        window.onload = function() {
            var urls = @json($pdfUrls);
            openTabs(urls, 0);
        }

        function openTabs(urls, index) {
            if (index < urls.length) {
                window.open(urls[index], "_blank");
                setTimeout(function() {
                    openTabs(urls, index + 1);
                }, 100); // 1000 milliseconds delay
            } else {
                // Redirect after all tabs are opened
                setTimeout(function() {
                    window.history.back();
                }, 100); // Adjust the delay time if needed
            }
        }
    </script>
</body>
</html>
