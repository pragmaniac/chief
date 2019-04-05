@chiefformgroup(['field' => 'firstname'])
    @slot('label', trans('chief::you.firstname'))
    <div class="row gutter">
        <div class="column-12">
            <label for="firstName">@lang('chief::you.firstname')</label>
            <input id="firstName" class="input inset-s" type="text" name="firstname" value="{{ old('firstname',$user->firstname) }}">
        </div>
    </div>
@endchiefformgroup

@chiefformgroup(['field' => 'lastname'])
    @slot('label', trans('chief::you.lastname'))
    <div class="row gutter">
        <div class="column-12">
            <label for="lastName">@lang('chief::you.lastname')</label>
            <input id="lastName" class="input inset-s" type="text" name="lastname" value="{{ old('lastname',$user->lastname) }}">
        </div>
    </div>
@endchiefformgroup

@chiefformgroup(['field' => 'email'])
    @slot('label', trans('chief::you.email'))
    @slot('description', trans('chief::you.email_description'))
    <label for="email">@lang('chief::you.email')</label>
    <input id="email" class="input inset-s" type="email" name="email" value="{{ old('email',$user->email) }}">
@endchiefformgroup
