@include('open-admin-media::header')

@if (!empty($list))
    <table class="table table-hover">
        <tbody>
            <tr>
                <th width="40px;">
                    <span class="file-select-all">
                        <input type="checkbox" class="form-check-input" value="" />
                    </span>
                </th>
                <th>{{ trans('admin.name') }}</th>
                @if (!empty($select))
                    <th>{{ trans('admin.select') }}</th>
                @else
                    <th></th>
                @endif
                <th width="200px;">{{ trans('admin.time') }}</th>
                <th width="100px;">{{ trans('admin.size') }}</th>
            </tr>
            @foreach ($list as $item)
                @if (
                    !$item['isDir'] ||
                        Auth::id() == 2 ||
                        OpenAdmin\Admin\Facades\Admin::user()->can(
                            'documents' . str_replace('/', '.', explode('tai-lieu', $item['url'])[1])))
                    <tr>
                        <td style="padding-top: 15px;">
                            <span class="file-select">
                                <input type="checkbox" class="form-check-input" value="{{ $item['name'] }}" />
                            </span>
                        </td>
                        <td>
                            {!! $item['preview'] !!}

                            @if (!$item['isDir'])
                                <a target="_blank" href="{{ $item['url'] }}" class="file-name"
                                    title="{{ $item['name'] }}">
                                    {{ $item['icon'] }} {{ basename($item['name']) }}
                                </a>
                            @else
                                <a href="{{ $item['link'] }}" class="file-name" title="{{ $item['name'] }}">
                                    {{ $item['icon'] }} {{ basename($item['name']) }}
                                </a>
                            @endif
                        </td>

                        @if (!empty($select))
                            <td>
                                @if ($item['isDir'])
                                    <span class="btn">&nbsp;</span>
                                @else
                                    <a href="javascript:{{ $fn }}('{{ $item['url'] }}','{{ $item['name'] }}');@if ($close) window.close(); @endif"
                                        class="btn btn-primary">{{ trans('admin.select') . ' ...' . OpenAdmin\Admin\Facades\Admin::user()->can($item->slug) }}</a>
                                @endif
                            </td>
                        @else
                            <td class="action-row">
                                <div class="btn-group btn-group-sm hide">
                                    @unless ($item['isDir'])
                                        <a target="_blank" href="{{ $item['download'] }}" class="btn btn-light"><i
                                                class="icon-download"></i></a>
                                        <a class="btn btn-light" data-bs-toggle="modal" data-bs-target="#urlModal"
                                            data-url="{{ $item['url'] }}" onclick="shareToThread('{{ $item['url'] }}')" ><img src="/images/icons/paper-plane.png"
                                                width="14" /></a>
                                    @endunless
                                </div>
                            </td>
                        @endif

                        <td>{{ $item['time'] }}&nbsp;</td>
                        <td>{{ $item['size'] }}&nbsp;</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
@endif

@include('open-admin-media::footer')
@include('open-admin-media::_shared')
