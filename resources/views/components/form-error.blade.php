{{--<div>--}}
{{--    <!-- Walk as if you are kissing the Earth with your feet. - Thich Nhat Hanh -->--}}
{{--</div>--}}

{{--blade component for error handilng in the form - stories/form.blade.php--}}
{{--this is an anonymous component--}}
@props(['field'])

@error($field)
<span class="invalid-feedback" role="alert">
        <strong>{{ $message }} </strong>
    </span>
@enderror
