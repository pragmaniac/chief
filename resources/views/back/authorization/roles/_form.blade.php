@chiefformgroup(['field' => 'name'])
    @slot('label', trans('chief::roles.role_name'))
    @slot('description', trans('chief::roles.role_name_description'))
    <input class="input inset-s" type="text" name="name" value="{{ old('name',$role->name) }}">
@endchiefformgroup

@chiefformgroup(['field' => 'permission_names'])
    @slot('label', trans('chief::roles.permission_name'))
    @slot('description', trans('chief::roles.permission.description'))
    <chief-multiselect
        name="permission_names"
        :options=@json($permission_names)
        selected='@json(old('permission_names', $role->permissionNames()))'
        :multiple="true"
    >
    </chief-multiselect>
    @if($errors->has('permission_names.0'))
        <span class="caption">{{ $errors->first('permission_names.0') }}</span>
    @endif
@endchiefformgroup
