<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload CSV</title>
</head>
<body>
    <h1>Upload File CSV</h1>
    <form action="upload-csv-processing.php" method="post" enctype="multipart/form-data">
        <label for="csvFile">Chọn tệp CSV:</label>
        <input type="file" name="csvFile" id="csvFile" accept=".csv" required>
        <input type="submit" value="Upload">
    </form>
</body>
</html>
