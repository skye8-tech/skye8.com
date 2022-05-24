<div class="row">
    <div class="col-md-12">

        <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 10px;">
            <li role="presentation" class="active"><a href="#icons" aria-controls="icons" role="tab" data-toggle="tab">Icons</a></li>
            <li role="presentation"><a href="#alerts" aria-controls="alerts" role="tab" data-toggle="tab">Alerts</a></li>
            <li role="presentation"><a href="#labels" aria-controls="labels" role="tab" data-toggle="tab">Tags</a></li>
            <li role="presentation"><a href="#buttons" aria-controls="buttons" role="tab" data-toggle="tab">Buttons</a></li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="icons">
                <?php if(!empty($data['icons'])): ?>
                    <?php foreach($data['icons'] as $t): ?>
                        <span class="insert-component fa <?php echo $t ?>"></span>
                    <?php endforeach ?>
                <?php endif ?>
            </div>
            <div role="tabpanel" class="tab-pane" id="alerts">
                <div class="insert-component alert alert-success" role="alert">Text</div>
                <div class="insert-component alert alert-info" role="alert">Text</div>
                <div class="insert-component alert alert-warning" role="alert">Text</div>
                <div class="insert-component alert alert-danger" role="alert">Text</div>
            </div>
            <div role="tabpanel" class="tab-pane" id="labels">
                <span class="insert-component label label-default">Text</span>
                <span class="insert-component label label-primary">Text</span>
                <span class="insert-component label label-success">Text</span>
                <span class="insert-component label label-info">Text</span>
                <span class="insert-component label label-warning">Text</span>
                <span class="insert-component label label-danger">Text</span>
                <span class="insert-component badge">Text</span>
            </div>
            <div role="tabpanel" class="tab-pane" id="buttons">
                <span class="insert-component btn btn-default">Text</span>
                <span class="insert-component btn btn-primary">Text</span>
                <span class="insert-component btn btn-success">Text</span>
                <span class="insert-component btn btn-info">Text</span>
                <span class="insert-component btn btn-warning">Text</span>
                <span class="insert-component btn btn-danger">Text</span>
                <span class="insert-component btn btn-link">Text</span>
            </div>
        </div>
    </div>
</div>