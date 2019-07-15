<div class="seo-container">
    <div class="page-header">
        <h3>Search Engine Optimization</h3>
    </div>
    <div class="form-group">
        <div class="slide-down-info col-sm-10 col-sm-offset-2" style="display:none;">
            <div class="alert alert-info">
                Think of title tags like the title of the chapter of a book. It tells people and search engines what your page is about.
            </div>
        </div>
        <label class="col-sm-2 control-label">
            Title
            <span class="glyphicon glyphicon-question-sign do-show-info"></span>
        </label>
        <div class="col-sm-10">
            {{ Form::text('seo[title]', null, ['class' => 'form-control do-copy-content', 'data-copy-to' => '.og-title', 'maxlength' => 100]) }}
        </div>
    </div>
    <div class="form-group">
        <div class="slide-down-info col-sm-10 col-sm-offset-2" style="display:none;">
            <div class="alert alert-info">
                The keywords are used to sprinkle in a couple of your most targeted keywords for this content in comma delimeted format. <br>Plain text, max 150 characters.
            </div>
        </div>
        <label class="col-sm-2 control-label">
            Keywords
            <span class="glyphicon glyphicon-question-sign do-show-info"></span>
        </label>
        <div class="col-sm-10">
            {{ Form::text('seo[keywords]', null, ['class' => 'form-control', 'maxlength' => 150]) }}
        </div>
    </div>
    <div class="form-group">
        <div class="slide-down-info col-sm-10 col-sm-offset-2" style="display:none;">
            <div class="alert alert-info">
                The description is a snippet used to summarize a web page's content. Plain text.
                <p><strong>Ps. Meta descriptions can be any length, but search engines generally truncate snippets longer than 160 characters. It is best to keep meta descriptions between 150 and 160 characters.</strong></p>
            </div>
        </div>
        <label class="col-sm-2 control-label">
            Description
            <span class="glyphicon glyphicon-question-sign do-show-info"></span>
        </label>
        <div class="col-sm-10">
            {{ Form::textarea('seo[description]', null, ['class' => 'form-control do-copy-content', 'data-copy-to' => '.og-description', 'rows' => 3]) }}
        </div>
    </div>
    <div class="page-header">
        <h3>Facebook Sharing</h3>
    </div>
    <div class="form-group">
        <div class="slide-down-info col-sm-10 col-sm-offset-2" style="display:none;">
            <div class="alert alert-info">
                A clear title without branding or mentioning the domain itself. You should use this as a headline that will appeal to the Facebook audience. It is completely ok to use a different title than the one on the actual site as long as the message is ultimately the same.
            </div>
        </div>
        <label class="col-sm-2 control-label">
            Title
            <span class="glyphicon glyphicon-question-sign do-show-info"></span>
        </label>
        <div class="col-sm-10">
            {{ Form::text('seo[og_title]', null, ['class' => 'form-control og-title', 'maxlength' => 95]) }}
        </div>
    </div>
    <div class="form-group">
        <div class="slide-down-info col-sm-10 col-sm-offset-2" style="display:none;">
            <div class="alert alert-info">
                This is the description Facebook will show in the screenshot of the piece of content. Just like the standard meta description it should be catchy.
                <p><strong>Ps. Facebook meta descriptions can be any length, but facebook engines generally truncate snippets longer than 300 characters. It is best to keep meta descriptions between 110 and 300 characters.</strong></p>
            </div>
        </div>
        <label class="col-sm-2 control-label">
            Description
            <span class="glyphicon glyphicon-question-sign do-show-info"></span>
        </label>
        <div class="col-sm-10">
            {{ Form::textarea('seo[og_description]', null, ['class' => 'form-control og-description', 'rows' => 3]) }}
        </div>
    </div>
    <div class="form-group">
        <div class="slide-down-info col-sm-10 col-sm-offset-2" style="display:none;">
            <div class="alert alert-info">
                This is the image that Facebook will show in the screenshot of the content. Use images that are at least 1200 x 630 pixels for the best display on high resolution devices.
            </div>
        </div>
        <label class="col-sm-2 control-label">
            Image
            <span class="glyphicon glyphicon-question-sign do-show-info"></span>
        </label>
        <div class="col-sm-6">
            {{ Form::file('seo[og_image]') }}
            <small>The minimum image size is 200 x 200 pixels.</small>
        </div>
        @if (!empty($model) && $model->seo && $model->seo->image)
            <div class="col-sm-4 text-right">
                <img src="{{ $model->seo->image->getSrc() }}" alt="" class="preview-img" />
            </div>
        @endif
    </div>
</div>