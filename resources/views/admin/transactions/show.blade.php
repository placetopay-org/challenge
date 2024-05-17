@extends('layouts.admin')

@section('admin-content')
    <div class="row">
        <div class="col">
            <div class="my-4 w-100" v-cloak>
                <h1>{{ trans('titles.authentications') }}</h1>
            </div>
        </div>
        <div class="col">
            <div class="d-flex gap-3 justify-content-end align-items-center h-100">
                @button([
                    'type' => 'back',
                    'route' => route('admin.transactions.index')
                ])
                @endbutton

                <a
                    href="{{ route('admin.transactions.export', $transaction) }}"
                    class="btn btn-default d-flex justify-content-end align-items-center">
                    <em class="{{ "fa fa-solid fa-file-pdf me-2" }}"></em> {{ trans('common.export') }}
                </a>

                @can(\App\Constants\PolicyNames::CREATE, \App\Models\Dispute::class)
                    @if(!$transaction->dispute)
                        @include('admin.transactions.data.disputes.__create')
                    @endif
                @endcan
            </div>
        </div>
    </div>

    @if($transaction->dispute)
        <div @class([
                'alert',
                'd-flex',
                'justify-content-between',
                'notification-danger' => $transaction->dispute->isOpened(),
                'notification-warning' => !$transaction->dispute->isOpened(),
            ])>
            @lang('disputes.titles.exists')
            <a class="pointer text-decoration-none text-secondary" href="#dispute">
                <em class="fas fa-eye me-2"></em>
                @lang('common.view_more')
            </a>
        </div>
    @endif

    @include('admin.transactions.data.__indicators')

    <div class="row row-cols-1 row-cols-xl-3 mb-sm-2">
        <div class="col d-flex flex-column">
            @include('admin.transactions.data.__transaction')
        </div>

        <div class="col d-flex flex-column">
            @include('admin.transactions.data.__payer')
            @include('admin.transactions.data.__merchant')
            @include('admin.transactions.data.__risk_indicators')
        </div>

        <div class="col d-flex flex-column">
            @include('admin.transactions.data.__messages_data')
            @include('admin.transactions.data.__3ds')
        </div>
    </div>

    @if($scores->isNotEmpty())
        @include('admin.transactions.data.__scores')
    @endif

    <div class="row mb-4 row-cols-xl-3">
        @if (!$transaction->challenge)
            <div class="col-12 col-lg-4 mb-5 mb-lg-0">
                @if(!$exportable)
                    <h1 class="subhead my-2">@lang('titles.geolocation_by_ip')</h1>
                @endif
                <div class="card p-2 h-100 table-responsive mb-0">
                    @if($aReq && $aReq->browserIP)
                        <ip-localization-map
                                ip="{{ $aReq->browserIP }}"
                                token="{{ config('geolocation.maps.google.apiKey') }}">
                        </ip-localization-map>
                    @endif
                </div>
            </div>
        @endif

        <div class="col-12 col-lg-4 mb-5 mb-lg-0">
            @include('admin.transactions.data.__shipping')
        </div>

        <div class="col-12 col-lg-4 mb-5 mb-lg-0">
            @include('admin.transactions.data.__bill_address')
        </div>

        @isset($transaction->challenge)
            <div class="col-12 col-lg-4 mb-5 mb-lg-0">
                @include('admin.transactions.data.__challenge')
            </div>
        @endisset

    </div>

    <div class="row">
        @if ($transaction->challenge)
            <div class="col-12 mt-4 mb-4">
                @if(!$exportable)
                    <h1 class="subhead my-2">@lang('titles.geolocation_by_ip')</h1>
                @endif
                <div class="card p-2 h-100 table-responsive mb-0">
                    @if($aReq && $aReq->browserIP)
                        <ip-localization-map
                            ip="{{ $aReq->browserIP }}"
                            token="{{ config('geolocation.maps.google.apiKey') }}"
                            landscape>
                        </ip-localization-map>
                    @endif
                </div>
            </div>
        @endif
    </div>

    @if($transaction->dispute)
        @include('admin.transactions.data.disputes.__dispute', ['dispute' => $transaction->dispute])
    @endif

    @if($transaction->messages->isNotEmpty())
        @include('admin.transactions.data.__messages')
    @endif

    @include('admin.transactions.data.__traces')
@endsection
