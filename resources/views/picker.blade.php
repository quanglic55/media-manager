<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Picker Layout</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .file-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 15px;
            background: #F8F8F8;
            margin: 10px 0;
            border-radius: 8px;
            transition: background-color 0.3s;
        }

        .file-item > * {
            display: inline-flex;
            vertical-align: center;
        }

        .file-item:hover {
            background-color: #add8e6;
            /* Màu light blue */
        }

        .file-info > * {
            display: flex;
            align-items: center;
        }

        .file-info .file-icon i {
            width: 31px;
            height: 25px;
            margin-right: 10px;
            display: inline-block;
            background-size: contain;
            background-repeat: no-repeat;
            background-image: url('/images/icons/open-folder.png');
        }

        .file-info .file-icon i.icon-folder {
            width: 31px;
            height: 27px;
        }

        .file-info .file-icon i.icon-file-pdf {
            background-image: url('/images/icons/pdf.png');
            background-size: contain;
            background-repeat: no-repeat;
        }

        .search-icon {
            width: 20px;
            /* Kích thước icon tìm kiếm */
            height: 20px;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <!-- Phần tìm kiếm -->
        <div class="mb-4">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Tìm kiếm tệp tin hoặc thư mục"
                    aria-label="Tìm kiếm">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button">
                        <img src="/images/icons/search-icon.png" alt="Tìm kiếm" class="search-icon">
                    </button>
                </div>
            </div>
        </div>

        <!-- Phần danh sách tệp tin và thư mục -->
        <div class="file-list">

            @if (!empty($list))
                @foreach($list as $item)
                    <div class="file-item" @if(!$item['isDir']) data-path="{{ $item['url'] }}" @endif >
                        <div class="file-info">
                            {!! $item['preview'] !!}
                            @if(!$item['isDir'])
                                <a class="file-name" title="{{ $item['name'] }}">
                                    {{ $item['icon'] }} {{ basename($item['name']) }}
                                </a>
                            @else 
                                <a href="{{ $item['link'] }}" title="{{ $item['name'] }}">
                                    {{ $item['icon'] }} {{ basename($item['name']) }}
                                </a>
                            @endif                  
                        </div>
                        <span class="file-size">
                            {{ $item['size'] }}&nbsp;
                        </span>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.file-item').click(function () {
                var filePath = $(this).data('path');
                window.opener.document.getElementById('selectedFile').value = filePath;
                window.close();
            });
        });
    </script>
</body>

</html>
