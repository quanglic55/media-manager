@include('open-admin-media::header')

<ul class="files list clearfix">

    @if (empty($list))
        <li style="height: 200px;border: none;"></li>
    @else
        @foreach ($list as $item)
            @if (
                !$item['isDir'] ||
                    Auth::id() == 2 ||
                    OpenAdmin\Admin\Facades\Admin::user()->can(
                        'documents' . str_replace('/', '.', explode('tai-lieu', $item['url'])[1])))
                <li>
                    <span class="file-select">
                        <input type="checkbox" class="form-check-input" value="{{ $item['name'] }}" />
                    </span>

                    {!! $item['preview'] !!}

                    <div class="file-info">
                        @if (!$item['isDir'])
                            <a target="_blank" href="{{ $item['url'] }}" class="file-name" title="{{ $item['name'] }}">
                                {{ $item['icon'] }} {{ basename($item['name']) }}
                            </a>
                        @else
                            <a href="{{ $item['link'] }}" class="file-name" title="{{ $item['name'] }}">
                                {{ $item['icon'] }} {{ basename($item['name']) }}
                            </a>
                        @endif

                        <span class="file-size">
                            {{ $item['size'] }}&nbsp;
                        </span>

                        @if (!empty($select))
                            @if ($item['isDir'])
                                <span class="btn">&nbsp;</span>
                            @else
                                <a href="javascript:{{ $fn }}('{{ $item['url'] }}','{{ $item['name'] }}');@if ($close) window.close(); @endif"
                                    class="btn btn-primary">{{ trans('admin.select') }}</a>
                            @endif
                        @else
                            <div class="btn-group btn-group-sm float-end">
                                <button type="button" class="btn btn-default btn-xs dropdown-toggle"
                                    data-bs-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    @unless ($item['isDir'])
                                        <li><a target="_blank" class="dropdown-item"
                                                href="{{ $item['download'] }}">Download</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                data-bs-target="#urlModal" data-url="{{ $item['url'] }}"
                                                onclick="shareToThread('{{ $item['url'] }}')">Chia sẻ vào nhóm</a></li>
                                    @endunless
                                </ul>
                            </div>
                        @endif
                    </div>
                </li>
            @endif
        @endforeach
    @endif
</ul>
@include('open-admin-media::footer')
@include('open-admin-media::_shared')
