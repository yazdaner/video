<select name="{{$name}}">
    <option value="">{{$placeholder}}</option>
    {{ $slot }}
</select>
<x-validation-error field="{{$name}}" />
