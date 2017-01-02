<?php
require('includes/application_top.php');
require(DIR_WS_INCLUDES . 'template_top.php');
?>
<br>
<div class="container" data-ng-controller="lesson_ctrl as vm">
    <div class="col-md-3 col-sm-5 ">
        <div class="filter-stacked">
            <?php include('advanced_search_box_right.php');?>
        </div>
    </div>
    <div class="col-md-9 col-sm-7" ng-cloak>
        <div class="candidates-list">
            <div class="candidates-list-item" data-ng-repeat="data in vm.data.elements">
                <div class="">
                    <a href="{{vm.renderLink(data.id, data.title)}}">
                        {{data.title}}
                    </a>
                </div>
            </div>
        </div>

        <div
            data-ng-if="vm.data.count == 0"
        >
            <div class="alert alert-danger">
                <strong>Warning!</strong> Empty Data.
            </div>
        </div>
        <div
            data-ng-if="!vm.data"
            class="align_center"
        >
            <i class="fa fa-refresh fa-spin" style="font-size: 100px;"></i>
        </div>
        <div
            data-ng-show="vm.totalItems > 10"
        >
            <pagination
                total-items="vm.totalItems"
                ng-model="vm.currentPage"
                ng-change="vm.pageChanged()"
                max-size="5"
                items-per-page="10"
                boundary-links="true"
            ></pagination>
        </div>
    </div>
</div>
<?php
require(DIR_WS_INCLUDES . 'template_bottom.php');
require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
<script
    type="text/javascript"
    src="ext/ng/lib/angular/1.5.6/angular.min.js"
></script>
<script
    type="text/javascript"
    src="ext/ng/lib/angular-ui-bootstrap/ui-bootstrap-tpls-0.12.0.min.js"
></script>
<!-- custom file -->
<script
    type="text/javascript"
    src="ext/ng/app/lesson/main.js"
></script>
<script
    type="text/javascript"
    src="ext/ng/app/core/restful/restful.js"
></script>
<script
    type="text/javascript"
    src="ext/ng/app/lesson/controller/lesson_ctrl.js"
></script>
