<script type="text/ng-template" id="main.html">
<div class="row">
    <div class="col-sm-9">
        <ul class="list-group">
            <a ui-sref="view({id: doc._id})" class="list-group-item" ng-repeat="doc in docs">
                <small class="pull-right text-muted" am-time-ago="doc._timestamp"></small>
                <b style="margin-bottom: 6px; display: inline-block">{{doc.fields.title[0]}}</b>
                <div>
                    <span class="label label-primary">
                        {{doc.fields.category[0]}}
                    </span>
                    <span class="label label-info" ng-repeat="tag in doc.fields.tags">
                        {{tag}}
                    </span>
                </div>
            </a>
        </ul>
    </div>
    <div class="col-sm-3">
        <button class="btn btn-block btn-primary" ui-sref="create">
            <i class="fa fa-plus"></i> New KB
        </button>
        <br>
        <div class="panel panel-primary">
            <div class="panel-heading">
                Search
            </div>
            <div class="panel-body">
                <input type="search" class="form-control kb-search">
            </div>
        </div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                Categories
            </div>
            <ul class="list-group">
                <a href="#" class="list-group-item" ng-repeat="category in categories">{{category.key}}</a>
            </ul>
        </div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                Tags
            </div>
            <ul class="list-group">
                <a href="#" class="list-group-item" ng-repeat="tag in tags">{{tag.key}}</a>
            </ul>
        </div>
    </div>
</div>
</script>

<script type="text/ng-template" id="form.html">
<form role="form" name="createForm" ng-submit="save()">
    <div class="form-group">
        <label class="control-label">Title</label>
        <input class="form-control" type="text" required ng-model="form.title">
    </div>
    <div class="form-group">
        <label class="control-label">Category</label>
        <input class="form-control" type="text" required ng-model="form.category">
    </div>
    <div class="form-group">
        <label class="control-label">Tags</label>
        <input class="form-control" type="text" required ng-model="form.tags">
        <div class="help-text">Semicolon Separated</div>
    </div>
    <div class="form-group">
        <label class="control-label">Contents</label>
        <wysiwyg textarea-id="question" textarea-class="form-control"  textarea-height="480px" textarea-name="textareaQuestion" textarea-required ng-model="form.contents" enable-bootstrap-title="true"></wysiwyg>
    </div>
    <button type="submit" ng-disabled="createForm.$invalid" class="btn btn-primary">Submit</button>
    <button ng-if="form._id" ui-sref="view({id: form._id})" type="button" class="btn btn-default">Cancel</button>
    <button ng-if="!form._id" ui-sref="main" type="button" class="btn btn-default">Cancel</button>
</form>
</script>

<script type="text/ng-template" id="view.html">
<div class="label label-primary" ng-bind="category"></div>
<br>
<br>
<div ng-bind-html="contents"></div>
<br>
<hr>
<button ui-sref="main" type="button" class="btn btn-primary">Home</button>
<button ui-sref="update({id: _id})" type="button" class="btn btn-default">Update</button>
<button type="button" class="btn btn-danger" ng-click="delete()">Delete</button>
</script>
