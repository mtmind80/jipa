@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="{{ route('credential_list_path') }}">Credentials</a>
                </li>
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">Provider: "{{ $credentialProfessionalName }}"</a>
                </li>
                <li class="crumb-active">
                    <a href="{{ route('credential_document_list_path', ['credential_id' => $credential_id]) }}">Document: "{{ $credentialDocumentType }}"</a>
                </li>
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">Actions</a>
                </li>
                <li class="crumb-trail">List</li>
            </ol>
        </div>
        <div class="topbar-right">
        </div>
    </header>
@stop

@section('content')
    <div id="content" class="animated fadeIn list-items admin-form">
        @include('errors._list')
        <div class="clearfix">
            <div class="col-xs-12 col-sm-6 pl0 ml0 pr0 mr0 mb15">
                <div class="btn-group">
                    @if (Auth::user()->isAllowTo('create-credential-document-action'))
                        <button id="button-create" class="btn btn-success mr10" type="submit">
                            <i class="fa fa-plus mr10"></i>Add New
                        </button>
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 pl0 ml0 pr0 mr0 mb15 search-container">
                @if (Auth::user()->isAllowTo('search-credential-document-action'))
                    {!! Form::open(['url' => route('credential_document_action_search_path', ['document_id' => $document_id]), 'id' => 'searchForm']) !!}
                    <span class="field search-input-container">
                            {!! Form::text('needle', $needle, ['class' => 'gui-input search-input', 'id' => 'needle']) !!}
                        </span>
                    <button id="button-search" class="btn btn-info search-button">
                        <i class="fa fa-search mr10"></i>Search
                    </button>
                    @if (!empty($needle))
                        <button class="btn btn-default reset-button equis" type="button" data-location="credentialdocumentactions/{{ $document_id }}">x</button>
                    @endif
                    {!! Form::close() !!}
                @endif
            </div>
        </div>

        <div class="panel" id="spy7">
            <div class="panel-body pn">
                <table class="table table-bordered list-table">
                    <thead>
                    <tr>
                        <th class="td-sortable">{!! SortableTrait::link('document_action_types.name|credential_document_actions.action_type_id', 'Action', ['document_id' => $document_id]) !!}</th>
                        <th class="td-sortable">{!! SortableTrait::link('users.first_name|credential_document_actions.user_id', 'User', ['document_id' => $document_id]) !!}</th>
                        <th class="td-sortable text-center">{!! SortableTrait::link('created_at', 'Created At', ['document_id' => $document_id]) !!}</th>
                        <th class="actions">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($credentialDocumentActions as $credentialDocumentAction)
                            <tr data-id="{{ $credentialDocumentAction->id }}" class="{{ !empty($credentialDocumentAction->disabled) ? 'disabled' : '' }}">
                                <td>{{ $credentialDocumentAction->type->name }}</td>
                                <td>{{ $credentialDocumentAction->user->fullName }}</td>
                                <td class="text-center">{!! $credentialDocumentAction->htmlCreatedAt !!}</td>
                                <td class="centered actions">
                                    <ul class="nav navbar-nav">
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i></a>
                                            <ul class="dropdown-menu animated animated-short flipInX" role="menu">
                                                @if (Auth::user()->isAllowTo('update-insurer'))
                                                    <li>
                                                        <a href="javascript:void(0);" class="action" data-action="edit" data-id="{{ $credentialDocumentAction->id }}">
                                                            <span class="glyphicons glyphicons-edit"></span>Edit
                                                        </a>
                                                    </li>
                                                @endif
                                                @if (Auth::user()->isAllowTo('delete-credential-document-action'))
                                                    <li class="menu-separator"></li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="action" data-action="delete" data-id="{{ $credentialDocumentAction->id }}">
                                                            <span class="glyphicons glyphicons-circle_remove"></span>Delete
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row pagination-container clearfix text-center">
            <div class="col-xs-12 col-sm-4">
                <div class="pull-left pagination-info">
                    @if (!$credentialDocumentActions->total())
                        <span>There is no item to show.</span>
                    @else
                        @if ($credentialDocumentActions->perPage() > $credentialDocumentActions->total())
                            <span>Showing {!! $credentialDocumentActions->total() !!} {{ $credentialDocumentActions->total() == 1 ? 'item' : 'items' }}</span>
                        @else
                            <span>Showing {{ $credentialDocumentActions->perPage() }} of {!! $credentialDocumentActions->total() !!} {{ $credentialDocumentActions->total() == 1 ? 'item': 'items' }}</span>
                        @endif
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 pagination-pages">
                Items per page:
                <select id="pageItems" class="form-control">
                    <option value="{{ route('credential_document_action_list_path', array_merge(Request::query(), ['document_id' => $document_id, 'page' => 0, 'perPage' => 10])) }}"{{ Request::input('perPage') == 10 ? ' selected' : '' }}>10</option>
                    <option value="{{ route('credential_document_action_list_path', array_merge(Request::query(), ['document_id' => $document_id, 'page' => 0, 'perPage' => 20])) }}"{{ Request::input('perPage') == 20 ? ' selected' : '' }}>20</option>
                    <option value="{{ route('credential_document_action_list_path', array_merge(Request::query(), ['document_id' => $document_id, 'page' => 0, 'perPage' => $credentialDocumentActions->total()])) }}"{{ Request::input('perPage') == $credentialDocumentActions->total() ? ' selected' : '' }}>All</option>
                </select>
            </div>
            <div class="col-xs-12 col-sm-4 pull-right pagination-handlers text-right">
                @include('components.pagination.custom', ['paginator' => $credentialDocumentActions, 'route' => 'credential_document_action_list_path', 'query' => http_build_query(Input::except(['page', '_token']))])
            </div>
        </div>

        {!! Form::open(['method'=>'DELETE', 'route' => 'credential_document_action_delete_path', 'id' => 'deleteForm']) !!}
            {!! Form::hidden('document_id', $document_id) !!}
            <input type="hidden" id="strCid" name="strCid" value="">
        {!! Form::close() !!}
    </div>
@endsection

@section('js-files')
    <script>
        $(function(){
            $('#pageItems').change(function(){
                window.location.href = $(this).val();
            });

            $('#button-create').click(function(){
                window.location = "{{ route('credential_document_action_create_path', ['document_id' => $document_id]) }}";
            });

            $('#needle').blur(function(){
                $(this).parents('label').removeClass('state-error').next('em').remove();
            });

            $('#searchForm').validate({
                rules: {
                    needle: {
                        minlength: 2,
                        text     : true
                    }
                }
            });

            $('table.list-table tbody tr td.actions').on('click', 'a.action[data-action="edit"]', function(){
                window.location = "{{ asset('credentialdocumentactions') }}/" + $(this).attr('data-id') + '/edit';
            });

            $('table.list-table tbody tr td.actions').on('click', 'a.action[data-action="delete"]', function(){
                uiConfirm({callback: 'confirmDelete', params: [$(this).attr('data-id')]});
            });

        });

        function confirmDelete(params)
        {
            $('#strCid').val(params);
            $('#deleteForm').submit();
        }
    </script>
@stop