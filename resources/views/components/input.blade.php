@if($forLogin == 'yes')
<div class="col-12">
    <label for="{{$id}}" class="form-label">{{$label}}</label>
    @if($type->toHtml() == 'password')<button type="button"  style="float:right;border:none" > <i class="ri-eye-close-fill" id="togglePassword" style="position: absolute; cursor: pointer; margin-top: 36px; margin-left:-25px"></i></button> @endif
    <input
        type="{{$type}}"
        name="{{$name}}"
        value="{{old($name->toHtml()) ?? ''}}"
        onclick="$('#alert-{{$name->toHtml()}}').hide(); $('#{{$id->toHtml()}}').removeClass('laravel-invalied') "
        class="form-control @error($name->toHtml()) laravel-invalied @enderror"
        id="{{$id}}"

        required>
    <div class="invalid-feedback">{{ucfirst($name->toHtml()).' ' . 'is required'}} </div>
    @error($name->toHtml())
    <div id="alert-{{$name}}" class="laravel-invalid-feedback">{{ $message }}</div>
    @enderror
</div>
@else
<div class="row mb-3">
    <label for="{{$id}}" class="col-sm-2 col-form-label">{{$label}}</label>
    <div class="col-sm-10">
        @if($type->toHtml() != 'textarea')
        @if($type->toHtml() == 'password')<button type="button" style="float:right;border:none;cursor: pointer;"  > <i id="togglePassword" class="ri-eye-close-fill" style="position: absolute;  margin-top: 10px; margin-left:-25px"></i></button> @endif
        <input type="{{$type}}" placeholder="Enter {{$label}} .." @if($type->toHtml() == 'file' && $name->toHtml() == 'image' ) accept=".png, .jpg, .jpeg" @endif name="{{$name}}"
        value="@if(isset($value)&&$type->toHtml() != "number" ){{$value}}@elseif(isset($value)&&$type->toHtml() == "number" ){{(int)$value->toHtml()}}@else{{old($name->toHtml()) ?? ''}} @endif" onclick="$('#alert-{{$name->toHtml()}}').hide(); $('#{{$id->toHtml()}}').removeClass('laravel-invalied') "
        class="form-control @error($name->toHtml()) laravel-invalied @enderror"
        id="{{$id}}"
        @if(isset($required) && $required=='false') @else required @endif
        @if(isset($readOnly) && $readOnly=='yes') readOnly @endif>
        @else
        <textarea name="{{$name}}" placeholder="Enter {{$label}} .." onclick="$('#alert-{{$name->toHtml()}}').hide(); $('#{{$id->toHtml()}}').removeClass('laravel-invalied') " class="form-control  @error($name->toHtml()) laravel-invalied @enderror" id="{{$id}}" required>@if(isset($value)){{$value}} @else {{old($name->toHtml()) ?? ''}} @endIf</textarea>
        @endif
        @error($name->toHtml())
        <div id="alert-{{$name}}" class="laravel-invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

</div>
@endif
