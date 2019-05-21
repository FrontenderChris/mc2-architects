{{ Form::open(['route' => 'contact.send', 'method' => 'POST', 'class' => 'validate-form', 'id' => 'contactForm']) }}
@if (Session::has('success-msg'))
    <p style="padding:10px; color:green;">{!! Session::get('success-msg') !!}</p>
@else
    @if ($errors->any())
        <p style="padding:10px; color:red;">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </p>
    @endif

    <h3>CONTACT FORM</h3>

    <div class="form-fields-stack">
        <div class="form-field">
            {{ Form::text('full_name', null, ['maxlength' => 255, 'id' => 'firstname', 'placeholder' => 'Full Name *', 'class' => 'required']) }}
        </div>
    </div>
    <div class="form-fields-stack two-column">
        <div class="form-field">
            {{ Form::text('phone', null, ['maxlength' => 255, 'id' => 'phone', 'placeholder' => 'Phone Number *', 'class' => 'required']) }}
        </div>
        <div class="form-field">
            {{ Form::text('email', null, ['maxlength' => 255, 'id' => 'email', 'class' => 'required', 'placeholder' => 'Email Address *']) }}
        </div>
    </div>
    <div class="form-field">
        {{ Form::textarea('message', null, ['id' => 'message', 'rows' => 5, 'cols' => 15, 'placeholder' => 'Write a Message', 'class' => '']) }}
    </div>
    <div class="button-field">
        <span class="form-note">*Mandatory Fields</span>
        <button type="submit">Send</button>
    </div>
@endif
{{ Form::close() }}