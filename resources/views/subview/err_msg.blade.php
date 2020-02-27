@if($errors->has($err))
    <span class="err-msg">{{ $errors->first($err) }}</span>
@endif