<!DOCTYPE html>
<html>
<head>
    <title>Upload Images</title>
</head>
<body>
    @if(Session::has('success'))
        <p>{{ Session::get('success') }}</p>
    @endif
    @if(Session::has('error'))
        <p>{{ Session::get('error') }}</p>
    @endif
    <form action="{{ route('image.upload.post') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="images[]" multiple>
        <button type="submit">Upload</button>
    </form>
</body>
</html>
