@php $itoasts = session()->pull('itoasts', []) @endphp

@if (session()->has('success') || session()->has('error') || session()->has('warn') || session()->has('info') || $itoasts)
    <div class="itoasts">
        {{-- To show normal session messages --}}
        @foreach (['success', 'error', 'warn', 'info'] as $type)
            @if (session()->has($type))
                <div class="itoast-inner" @if (isIToastArray($type, 'dir')) dir="{{ isIToastArray($type, 'dir') }}" @endif>
                    <div class="itoast itoast-{{ isIToastArray($type, 'theme') ?: $type }} {{ isIToastArray($type, 'pin') }} {{ isIToastArray($type, 'position') ?: config('itoast.default_position') }}{{ config('itoast.move') != 'enable' ? ' no_move' : '' }}"
                        @if (isIToastArray($type, 'duration')) data-duration="{{ isIToastArray($type, 'duration') }}" @endif>

                        @if (isIToastArray($type, 'emoji'))
                            <div class="itoast-icon emoji fas" style="font-size: 20px">
                                {{ isIToastArray($type, 'emoji') }}
                            </div>
                        @else
                            <i class="itoast-icon fas fa-{{ isIToastArray($type, 'icon') ?: getIcon($type) }}"></i>
                        @endif

                        @if (config('itoast.move') != 'enable' || isIToastArray($type, 'pin') == 'pin')
                            <i class="itoast-icon pin fas fa-thumbtack"></i>
                        @endif

                        <div class="itoast-text">
                            <div class="text">
                                @if (isIToastArray($type, 'title'))
                                    <strong>{{ isIToastArray($type, 'title') }}</strong>
                                @endif
                                <p>{{ isIToastArray($type, 'message') }}</p>
                            </div>

                            @if ($actions = getIToastActions($type))
                                <div class="itoast-actions">
                                    @foreach ($actions as $action)
                                        <a href="{{ $action['url'] }}" class="itoast-action {{ isEmoji($action['label']) ? 'emoji' : 'text' }}">
                                            {{ $action['label'] }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="itoast-closed">
                            <i class="fas fa-xmark"></i>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach

        @if ($itoasts)
            {{-- To show itoasts with more options --}}
            @foreach ($itoasts as $itoast)
                <div class="itoast-inner" @if ($itoast->dir) dir="{{ $itoast->dir }}" @endif>
                    <div class="itoast itoast-{{ $itoast->getTheme() }} {{ $itoast->position }}{{ config('itoast.move') != 'enable' ? ' no_move' : '' }} {{ $itoast->pin ?: '' }} {{ $itoast->type == 'confirm' ? 'confirm-forever' : '' }}"
                        @if ($itoast->duration) data-duration="{{ $itoast->duration }}" @endif>
                        @if ($itoast->emoji)
                            <div class="itoast-icon emoji fas" style="font-size: 20px">
                                {{ $itoast->emoji }}
                            </div>
                        @else
                            <i class="itoast-icon fas fa-{{ $itoast->getIcon() }}"></i>
                        @endif

                        @if (config('itoast.move') != 'enable' || $itoast->pin == 'pin' || config('itoast.confirm_pin') == true)
                            <i class="itoast-icon pin fas fa-thumbtack"></i>
                        @endif

                        <div class="itoast-text">
                            <div class="text">
                                @if ($itoast->type == 'confirm' || $itoast->title)
                                    <strong>{{ $itoast->title }}</strong>
                                @endif
                                <p>{{ $itoast->message }}</p>
                            </div>

                            @if ($itoast->type != 'confirm')
                                <div class="itoast-actions">
                                    @foreach ($itoast->actions as $action)
                                        <a href="{{ $action['url'] }}" class="itoast-action {{ isEmoji($action['label']) ? 'emoji' : 'text' }}">
                                            {{ $action['label'] }}
                                        </a>
                                    @endforeach
                                </div>
                            @elseif ($itoast->type == 'confirm')
                                <div class="itoast-actions">
                                    @foreach ($itoast->actions as $action)
                                        <a href="{{ $action['url'] }}" class="itoast-action {{ isEmoji($action['label']) ? 'emoji' : 'text' }}">
                                            {{ $action['label'] }}
                                        </a>
                                    @endforeach
                                </div>

                                <div class="itoast-actions">
                                    <a href="{{ $itoast->link }}" @if ($itoast->target) target="{{ $itoast->target }}" @endif class="itoast-action onconfirm {{ isEmoji($itoast->onconfirm) ? 'emoji' : 'text' }}">
                                        {{ $itoast->onconfirm }}
                                    </a>
                                    <p class="itoast-action oncancel {{ isEmoji($itoast->oncancel) ? 'emoji' : 'text' }}">
                                        {{ $itoast->oncancel }}
                                    </p>
                                </div>
                            @endif
                        </div>

                        <div class="itoast-closed">
                            <i class="fas fa-xmark"></i>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endif

@if ($errors->any())
    <div class="itoasts">
        <div class="itoast itoast-error{{ config('itoast.move') != 'enable' ? ' no_move' : '' }}">
            <i class="itoast-icon fas fa-circle-xmark"></i>

            <div class="itoast-text">
                <div class="text">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="itoast-closed">
                <i class="fas fa-xmark"></i>
            </div>
        </div>
    </div>
@endif


<script>
    configItoast = @json(config('itoast'));
</script>

<script type="module" src="{{ asset('vendor/itoast/js/itoast.js') }}"></script>
