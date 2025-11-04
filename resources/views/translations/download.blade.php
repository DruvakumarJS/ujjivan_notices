<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Translations</title>
</head>
<body>
    <h2>Original (English)</h2>
    <p>{{ $original }}</p>

    <h2>Translations</h2>
    @foreach($translations as $lang => $text)
        <h3>{{ strtoupper($lang) }}</h3>
        <p>{{ $text }}</p>
        <hr>
    @endforeach
</body>
</html>
