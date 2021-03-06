<div class="panel-body">
    <div class="section-divider mb40 mt20"><span>{{ $formTitle }}</span></div>

    <div class="section row">
        <div class="col-md-4">
            {{ Form::jText('short_name', ['label' => 'Short Name', 'id' => 'short_name', 'placeholder' => 'Short Name', 'required' => true, 'iconClass' => 'fa fa-diamond']) }}
        </div>
        <div class="col-md-8">
            {{ Form::jText('full_name', ['label' => 'Full Name', 'id' => 'full_name', 'placeholder' => 'Full Name', 'required' => true]) }}
        </div>
    </div>
</div>
<div class="panel-footer text-right">
    <div class="row">
        <div class="col-md-6">
            @if (empty($config['simpleFormSubmission']))
                {{ Form::jVerification($equation['equation']) }}
            @endif
        </div>
        <div class="col-md-6">
            {{ Form::jCancelSubmit(['submit-label' => $submitButtonText]) }}
        </div>
    </div>
</div>