@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="{{ route('provider_list_path') }}">Providers</a>
                </li>
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">Name: "{{ $professionalName }}"</a>
                </li>
                <li class="crumb-active">
                    <a href="{{ route('professional_board_list_path', ['professional_id' => $professional_id]) }}">Board</a>
                </li>
                <li class="crumb-trail">Create</li>
            </ol>
        </div>
        <div class="topbar-right">
        </div>
    </header>
@stop

@section('content')
    <section id="content" class="animated fadeIn list-items admin-form">
        <div class="row">
            <div class="col-md-9 center-block">
                @include('errors._list')
                <div class="admin-form theme-primary">
                    <div class="panel">
                        {!! Form::open(['route' => 'professional_board_store_path', 'id' => 'createForm']) !!}
                            {!! Form::hidden('professional_id', $professional_id) !!}
                            @include('provider.board._form', ['formTitle' => 'New Board', 'submitButtonText' => 'Add Board', 'create' => true])
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js-files')
    <script>
        $(function(){
            $('#createForm').validate({
                rules: {
                    speciality_type_id: {
                        required: true,
                        positive: true
                    },
                    speciality_subtype_id: {
                        required: true,
                        positive: true
                    },
                    body_id: {
                        required: true,
                        positive: true
                    },
                    certification_id: {
                        required: true,
                        positive: true
                    },
                    country_id: {
                        required: true,
                        positive: true
                    },
                    state_id: {
                        required: true,
                        positive: true
                    },
                    number: {
                        required : true,
                        plainText: true
                    },
                    // not required fields
                    issued_at: {
                        required: false,
                        usDate  : true
                    },
                    expired_at: {
                        required: false,
                        usDate  : true
                    },
                    verification:{
                        required    : true,
                        smartCaptcha: "{{ $equation['result'] }}"
                    }
                },
                messages: {
                    speciality_type_id: {
                        positive: 'Please, select a speciality type.'
                    },
                    speciality_subtype_id: {
                        positive: 'Please, select a speciality subtype.'
                    },
                    body_id: {
                        positive: 'Please, select a body.'
                    },
                    certification_id: {
                        positive: 'Please, select a certification.'
                    },
                    country_id: {
                        positive: 'Please, select a country.'
                    },
                    state_id: {
                        positive: 'Please, select a state.'
                    }
                }
            });

            $('#cancel-button').click(function(ev){
                ev.preventDefault();
                window.location = "{{ route('professional_board_list_path', ['professional_id' => $professional_id]) }}";
            });

            $('#speciality_type_id').change(function(ev){
                $.ajax({
                    type:"post",
                    url: "{{ route('speciality_subtype_fetch_path') }}",
                    data: {
                        speciality_type_id: $(this).val()
                    },
                    beforeSend: function (request){
                        PNotify.removeAll();
                        showSpinner();
                        request.setRequestHeader("X-XSRF-TOKEN", "{{ $encToken }}");
                    },
                    complete: function(){
                        hideSpinner();
                    },
                    success: function(response){
                        var result = $.parseJSON(response);
                        $('#speciality_subtype_id').empty();
                        if (result.success) {
                            var html = ['<option value="0">Select Subtype</option>'];
                            $.each(result.data, function(index, value){
                                html.push('<option value="'+ index +'">'+ value +'</option>')  // person-data-section facility-data-section
                            });
                            $('#speciality_subtype_id').html(html.join(''));
                        } else {
                            pnAlert({
                                type: 'error',
                                title: 'Error',
                                text: result.message,
                                addClass: 'mt50'
                            });
                        }
                    }
                });
            });

            $('#country_id').change(function(ev){
                $.ajax({
                    type:"post",
                    url: "{{ route('state_fetch_path') }}",
                    data: {
                        country_id: $(this).val()
                    },
                    beforeSend: function (request){
                        PNotify.removeAll();
                        showSpinner();
                        request.setRequestHeader("X-XSRF-TOKEN", "{{ $encToken }}");
                    },
                    complete: function(){
                        hideSpinner();
                    },
                    success: function(response){
                        var result = $.parseJSON(response);
                        $('#state_id').empty();
                        if (result.success) {
                            var html = ['<option value="0">Select State</option>'];
                            $.each(result.data, function(index, value){
                                html.push('<option value="'+ index +'">'+ value +'</option>')  // person-data-section facility-data-section
                            });
                            $('#state_id').html(html.join(''));
                        } else {
                            pnAlert({
                                type: 'error',
                                title: 'Error',
                                text: result.message,
                                addClass: 'mt50'
                            });
                        }
                    }
                });
            });
        });
    </script>
@stop