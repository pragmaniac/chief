
@chiefformgroup(['field' => ['firstname', 'lastname']])
    @slot('label', trans('chief::users.name'))
    <div class="row gutter">
        <div class="column-5">
            <label for="firstName">@lang('chief::users.firstname')</label>
            <input id="firstName" class="input inset-s" type="text" name="firstname" value="{{ old('firstname',$user->firstname) }}">
        </div>
        <div class="column-7">
            <label for="lastName">@lang('chief::users.lastname')</label>
            <input id="lastName" class="input inset-s" type="text" name="lastname" value="{{ old('lastname',$user->lastname) }}">
        </div>
    </div>
@endchiefformgroup

@chiefformgroup(['field' => 'email'])
    @slot('label', trans('chief::users.email'))
    @slot('description', trans('chief::users.email_description'))
    <label for="email">E-mail</label>
    <input id="email" class="input inset-s" type="email" name="email" value="{{ old('email',$user->email) }}">
@endchiefformgroup

@chiefformgroup(['field' => 'roles'])
    @slot('label', trans('chief::users.roles'))
    @slot('description', trans('chief::users.roles_description'))
        <label for="roles">@lang('chief::users.roles')</label>
        <chief-multiselect
            name="roles"
            :options=@json($roleNames)
            selected='@json(old('roles', $user->roleNames()))'
            :multiple="true"
    >
    </chief-multiselect>
    @if($errors->has('roles.0'))
        <span class="caption">{{ $errors->first('roles.0') }}</span>
    @endif
@endchiefformgroup
