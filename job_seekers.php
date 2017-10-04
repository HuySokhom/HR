<?php
    require('includes/application_top.php');
    require(DIR_WS_INCLUDES . 'template_top.php');
?>
<br>
<div class="container" data-ng-controller="job_seeker_ctrl as vm">
    
    <div class="col-md-8" ng-cloak>
        <div class="row">
            <div class="form-group has-feedback col-sm-6">
                <div class="input-group row">
                    <input type="text" class="form-control" placeholder="Search..." 
                        data-ng-model="vm.search_name" 
                        data-ng-keypress="($event.which === 13) ? vm.search() : 0">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" data-ng-click="vm.search()" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
            </div>
            <div class="form-group has-feedback col-sm-6">
                <select name="function" id="function"
                    data-ng-model="vm.function"
                    class="form-control"
                    data-ng-change="vm.search()"
                    data-ng-options="x.categories_id as x.categories_name for x in vm.functionList">
                    <option value="">Select Function</option>
                </select>
            </div>
            <h4 class="page-header">CVs List</h4>
        
            <div data-ng-if="vm.data.count == 0">
                <div class="alert alert-danger">
                    <strong>Warning!</strong> Empty Data.
                </div>
            </div>
            <div data-ng-if="vm.loading" class="col-md-12">
                <i class="fa fa-refresh fa-spin align_center text-center" style="font-size: 100px;"></i>
            </div>
            <div class="candidates-list">
                <div class="candidates-list-item" data-ng-repeat="data in vm.data.elements">
                    <div class="candidates-list-item-heading">
                        <div class="candidates-list-item-title">
                            <h2 class="pointer" data-ng-click="vm.view(data);">
                                <a href="{{vm.getFullName(data.full_name)}}-le-{{data.id}}.html">
                                    <b>
                                        Apply For: {{data.apply_for}}
                                    </b>
                                </a>
                            </h2>
                            <h3 data-ng-bind="data.function_name"></h3>
                        </div><!-- /.candidates-list-item-title -->
                    </div><!-- /.candidates-list-item-heading -->

                    <div class="candidates-list-item-location">
                        
                    </div><!-- /.candidates-list-item-location -->

                    <div class="candidates-list-item-profile">
                        <div>ID: {{data.id}}</div>
                        <div class="pull-right"><i class="fa fa-map-marker"></i> {{data.preferLocation_name}}</div>                        
                    </div><!-- /.candidates-list-item-rating -->
                </div>
            </div>
            <div data-ng-show="vm.totalItems > 40">
                <pagination total-items="vm.totalItems"
                    ng-model="currentPage"
                    ng-change="vm.pageChanged()"
                    max-size="9"
                    items-per-page="40"
                    boundary-links="true"
                ></pagination>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="">
            <?php include('advanced_search_box_right.php');?>
        </div>
        <?php
            $query = tep_db_query("
                select
                    a.title,
                    a.link,
                    a.image,
                    ad.name
                from
                    advertising_banner a, advertising_detail ad
                where
                    a.status = 1 
                        and 
                    a.id = ad.advertising_banner_id
                        and
                    ad.name = 'CV List'
            ");
            while ($item = tep_db_fetch_array($query)) {
                //var_dump($item);
                echo "<div class='col-md-12 col-sm-6 col-xs-6'>
                    <img src='images/". $item['image']."' class='img-responsive ads'/>
                </div>";
            }
        ?>
    </div>
    
</div>
<?php
    require(DIR_WS_INCLUDES . 'template_bottom.php');
    require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
<script
    type="text/javascript"
    src="ext/jsPdf/jspdf.min.js"
></script>
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
    src="ext/ng/app/job-seeker/main.js"
></script>
<script
    type="text/javascript"
    src="ext/ng/app/core/restful/restful.js"
></script>
<script
    type="text/javascript"
    src="ext/ng/app/job-seeker/controller/job_seeker_ctrl.js"
></script>
