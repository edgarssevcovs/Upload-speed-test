<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload Speed Test</title>
</head>
<body>
    <h2>Upload Files and Measure Speed</h2>
    <form id="uploadForm">
        <input type="file" id="files" name="files[]" multiple>
        <button type="button" onclick="uploadFiles()">Upload</button>
    </form>
    <div id="progress"></div>
    <div id="speed"></div>

    <script>
        function uploadFiles() {
            let files = document.getElementById('files').files;
            if (files.length === 0) {
                alert("Please select files!");
                return;
            }

            let formData = new FormData();
            for (let i = 0; i < files.length; i++) {
                formData.append('files[]', files[i]);
            }

            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'upload.php', true);

            let startTime = Date.now();

            xhr.upload.onprogress = function (e) {
                if (e.lengthComputable) {
                    let percentComplete = (e.loaded / e.total) * 100;
                    document.getElementById('progress').innerText = `Uploaded: ${percentComplete.toFixed(2)}%`;
                }
            };

            xhr.onload = function () {
                if (xhr.status === 200) {
                    let endTime = Date.now();
                    let duration = (endTime - startTime) / 1000; // seconds
                    let fileSize = [...files].reduce((acc, file) => acc + file.size, 0) / (1024 * 1024); // MB
                    let speed = (fileSize / duration).toFixed(2); // MB/s
                    document.getElementById('speed').innerText = `Upload Speed: ${speed} MB/s`;
                } else {
                    document.getElementById('speed').innerText = `Upload failed!`;
                }
            };

            xhr.send(formData);
        }
    </script>
</body>
</html>
