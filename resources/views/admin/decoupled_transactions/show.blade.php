@extends('layouts.admin')

@section('admin-content')
    <div class="row mb-3 mb-md-0">
        <div class="col offset-md-6">
            <div class="d-flex justify-content-end align-items-center gap-3 h-100">
                @if($transaction->isDecoupledChallenge())
                    <b-form
                        action="{{ route('admin.decoupleTransaction.free', $transaction->acs_trans_id) }}"
                        method="post">
                        @csrf
                        <b-button type="submit" variant="default">{{ trans('common.release_user') }}</b-button>
                    </b-form>
                    <div class="mx-1">
                        <b-button @click="$bvModal.show('resolve-transaction')"
                            variant="default">{{ trans('common.resolve_authentication') }}</b-button>
                    </div>
                @endif
                @button([
                    'type' => 'back',
                    'route' => route('admin.decoupleTransactions.index', $transaction)
                ])
                @endbutton
            </div>
        </div>
    </div>

    @include('admin.transactions.data.__indicators')

    <div class="row row-cols-1 row-cols-xl-3">
        <div class="col d-flex flex-column">
            @include('admin.transactions.data.__transaction')
        </div>
        <div class="col d-flex flex-column">
            @include('admin.transactions.data.__payer')
        </div>
        <div class="col d-flex flex-column">
            @include('admin.transactions.data.__merchant')
        </div>
    </div>

    @if(!$scores->isEmpty())
        @include('admin.transactions.data.__scores')
    @endif

    <related-transactions uuid="{{ $transaction->acs_trans_id }}"></related-transactions>

    <div class="row gap-3 mb-3">
        @include('admin.transactions.data.__acct_info', ['acctInfo' => $aReq->acctInfo])
    </div>

    <div class="row">
        <div class="col d-flex flex-column col-12 col-xl-6">
            @if($aReq->browserIP)
                <ip-localization-map ip="{{ $transaction->aReq->browserIP }}"
                    token="{{ config('geolocation.maps.google.apiKey') }}"></ip-localization-map>
            @endif
        </div>
        <div class="col d-flex flex-column col-12 col-xl-6">
            @include('admin.transactions.data.__shipping')
        </div>
    </div>

    @include('admin.transactions.data.__messages')

    @include('admin.transactions.data.__traces')

    <b-modal
        dialog-class="modal-dialog-centered"
        body-class="pt-0 px-0"
        hide-footer
        header-class="custom-modal-header pt-1 pb-0"
        id="resolve-transaction">
        <template #modal-header="{ close }">
            <div class="d-flex justify-content-end w-100">
                <a class="text-decoration-none hover-focus-none text-dark" style="cursor: pointer" @click="close()">
                    <em class="fas fa-times"></em>
                </a>
            </div>
        </template>
        <template #default="{ hide }">
            <div class="d-flex flex-column justify-content-center align-items-center gap-3">
                <div class="text-center">
                    <span class="title text-uppercase">{{ trans('common.resolve_authentication') }}</span>
                </div>

                <p-form
                    action="{{ route('admin.decoupleTransaction.resolve', $transaction->acs_trans_id) }}"
                    method="post"
                    class="w-100 d-flex flex-column align-items-center justify-content-center gap-4">
                    @csrf
                    <div class="form-group text-center">
                        <b-form-group class="m-1">
                            <b-form-radio-group
                                id="state"
                                :options="{{ json_encode($decoupled) }}"
                                name="state"
                            ></b-form-radio-group>
                        </b-form-group>
                    </div>
                    <div class="items-center">
                        <button class="btn btn-dark d-flex justify-content-between align-items-center"
                                type="submit" @click="$bvModal.hide('resolve-transaction')">
                            <em class="fas fa-fw fa-save"></em> {{ trans('common.save') }}
                        </button>
                    </div>
                </p-form>
            </div>
        </template>
    </b-modal>
@endsection
