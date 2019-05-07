<div class="box-body">
    <div class='form-group{{ $errors->has("{$lang}.title") ? ' has-error' : '' }}'>
        {!! Form::label("{$lang}[title]", trans('iact::acts.form.title')) !!}
        {!! Form::text("{$lang}[title]", old("{$lang}.title"), ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('iact::acts.form.title')]) !!}
        {!! $errors->first("{$lang}.title", '<span class="help-block">:message</span>') !!}
    </div>

    <div class='form-group{{ $errors->has("$lang.description") ? ' has-error' : '' }}'>
        @editor('description', trans('iplaces::places.form.description'), old("{$lang}.description"), $lang)
    </div>
<div class="row">
    <div class="col-xs-5 ">
        <div class="box box-primary">
            <div class="box-header">
                <div class='form-group{{ $errors->has("{$lang}.email") ? ' has-error' : '' }}'>
                    {!! Form::label("{$lang}[email]", trans('iact::acts.form.email')) !!}
                    {!! Form::text("{$lang}[email]", old("{$lang}.email"), ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('iact::acts.form.email')]) !!}
                    {!! $errors->first("{$lang}.email", '<span class="help-block">:message</span>') !!}
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-5 ">
        <div class="box box-primary">
            <div class="box-header">
                <div class='form-group{{ $errors->has("{$lang}.phone") ? ' has-error' : '' }}'>
                    {!! Form::label("{$lang}[phone]", trans('iact::acts.form.phone')) !!}
                    {!! Form::text("{$lang}[phone]", old("{$lang}.phone"), ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('iact::acts.form.phone')]) !!}
                    {!! $errors->first("{$lang}.phone", '<span class="help-block">:message</span>') !!}
                </div>
            </div>
        </div>
    </div>
</div>
    <?php if (config('asgard.page.config.partials.translatable.create') !== []): ?>
    <?php foreach (config('asgard.page.config.partials.translatable.create') as $partial): ?>
    @include($partial)
    <?php endforeach; ?>
    <?php endif; ?>
</div>


