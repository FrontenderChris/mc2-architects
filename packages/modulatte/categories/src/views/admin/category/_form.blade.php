<div class="tab-content tab-main" style="display: block;">
    @include('categories::admin.category.forms._catForm')
</div>
<div class="tab-content tab-seo">
    @include('partials._seoForm', ['model' => (!empty($model) ? $model : null)])
</div>