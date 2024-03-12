<!DOCTYPE html>
<html>
<head>
    <title>Images Gallery</title>
    <style>
        .thumbnail {
            max-width: 200px;
            max-height: 200px;
        }
    </style>
</head>
<body>
    <h1>Images Gallery</h1>

   <!-- Форма для сортировки -->
<form action="{{ route('images.show') }}" method="get">
    <label for="sort">Сортировка:</label>
    <select name="sort" id="sort">
        <option value="name">По названию</option>
        <option value="date">По дате</option>
    </select>
    <button type="submit">Применить</button>
</form>

<!-- Таблица с информацией о загруженных файлах -->
    <table>
        <thead>
            <tr>
                <th>Название файла</th>
                <th>Дата и время загрузки</th>
                <th>Превью</th>
                <th>Просмотр</th>
                <th>Скачать</th>
            </tr>
        </thead>
        <tbody>
            @foreach($images as $image)
                <tr>
                    <td>{{ $image->filename }}</td>
                    <td>{{ $image->uploaded_at }}</td>
                    <td><img src="{{ asset('images/' . $image->filename) }}" class="thumbnail"></td>
                    <td><a href="{{ asset('images/' . $image->filename) }}" target="_blank">Просмотр</a></td>
                    <td><a href="{{ route('images.downloadZip', $image->id) }}">Скачать в ZIP</a></td> 
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
