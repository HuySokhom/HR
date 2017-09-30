<?php
    require('includes/application_top.php');
    require(DIR_WS_INCLUDES . 'template_top.php');
?>
<br>
<div class="container" data-ng-controller="job_seeker_ctrl as vm">
    <div class="row">
        <div class="form-group has-feedback col-sm-3">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search..." 
                    data-ng-model="vm.search_name" 
                    data-ng-keypress="($event.which === 13) ? vm.search() : 0">
            <span class="input-group-btn">
                <button class="btn btn-default" data-ng-click="vm.search()" type="button">
                    <i class="fa fa-search"></i>
                </button>
            </span>
            </div>
        </div>
        <div class="form-group has-feedback col-sm-3">
            <select name="function" id="function"
                data-ng-model="vm.function"
                class="form-control"
                data-ng-change="vm.search()"
                data-ng-options="x.categories_id as x.categories_name for x in vm.functionList">
                <option value="">Select Function</option>
            </select>
        </div>
    </div>
    <div class="col-md-8 col-sm-7" ng-cloak>

        <div data-ng-if="vm.data.count == 0">
            <div class="row alert alert-danger">
                <strong>Warning!</strong> Empty Data.
            </div>
        </div>
        <div
            data-ng-if="vm.loading"
            class="col-md-12"
        >
            <i class="fa fa-refresh fa-spin align_center text-center" style="font-size: 100px;"></i>
        </div>
        <div class="candidates-list">
            <div class="candidates-list-item" data-ng-repeat="data in vm.data.elements">
                <div class="candidates-list-item-heading">
                    <div class="candidates-list-item-title">
                        <h2><b>Apply For: {{data.apply_for}}</b></h2>
                        <h3 data-ng-bind="data.function_name"></h3>
                    </div><!-- /.candidates-list-item-title -->
                </div><!-- /.candidates-list-item-heading -->

                <div class="candidates-list-item-location">
                    
                </div><!-- /.candidates-list-item-location -->

                <div class="candidates-list-item-profile">
                    <div class="pointer" data-ng-click="vm.view(data);">
                        <i class="fa fa-eye"></i>
                        Quick View
                    </div>
                    <div class="pull-right"><i class="fa fa-map-marker"></i> {{data.preferLocation_name}}</div>
                    
                </div><!-- /.candidates-list-item-rating -->
            </div>
        </div>
        <div
            data-ng-show="vm.totalItems > 40"
        >
            <pagination
                total-items="vm.totalItems"
                ng-model="currentPage"
                ng-change="vm.pageChanged()"
                max-size="9"
                items-per-page="40"
                boundary-links="true"
            ></pagination>
        </div>
    </div>
    <div class="col-md-4 col-sm-5">
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
                    <img src='images/". $item['image']."' class='img-responsive'/>
                </div>";
            }
        ?>
    </div>
    <!-- Modal popup cv-->
    
    <div id="cv" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">
                    <b>
                        Apply For: {{vm.model.apply_for}}
                    </b>
                    <button class="btn btn-primary btn-xs" data-ng-click="vm.download();">
                        <i class="fa fa-download"></i>
                        Download CV
                    </button>
                </h4>
            </div>
            <div class="modal-body" id="content">
                <form data-ng-submit="vm.save()" class="form-horizontal" name="accountForm">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="page-header title-header text-center">
                                    Cover Letter
                                </div>
                            </div>
                            <div class="col-md-12">
                                <h4 class="pull-right">{{vm.model.full_name}}</h4>
                            </div>
                            <div class="col-md-12 text-center">
                                <span class="pull-right"> Present address: {{vm.model.present_address}}</span>
                            </div>
                            <div class="col-md-12 text-center">
                                <span class="pull-right"> Phone number: {{vm.model.phone_number}}</span>
                            </div>
                            <div class="col-md-12 text-center">
                                <span class="pull-right"> Email: {{vm.model.email}}</span>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">
                                    Apply For
                                </label>
                                <div class="col-md-5">
                                    {{vm.model.apply_for}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">
                                    Function
                                </label>
                                <div class="col-md-5">
                                    {{vm.model.function_name}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">
                                    Prefer Location
                                </label>
                                <div class="col-md-5">
                                    {{vm.model.preferLocation_name}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3">
                                    Salary Expected
                                </label>
                                <div class="col-md-5">
                                    {{vm.model.salary_expected | currency}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="page-header title-header col-md-12">
                                    Cover Letter Detail
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <span data-ng-bind-html="vm.model.cover_letter_summary"></span>
                                </div>
                            </div>
                            <!-- START CV INFORMATION -->
                            <div class="row">
                                <div class="page-header title-header text-center col-md-12">
                                    Curriculum Vitae(CV)
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label class="col-md-3">
                                            Full Name
                                        </label>
                                        <div class="col-md-9">
                                            {{vm.model.full_name}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3">
                                            Gender
                                        </label>
                                        <div class="col-md-9">
                                            {{vm.model.gender}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3">
                                            Date of Birth
                                        </label>
                                        <div class="col-md-9">
                                            {{vm.model.dob}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3">
                                            Nationality
                                        </label>
                                        <div class="col-md-9">
                                            {{vm.model.nationality}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3">
                                            Religion
                                        </label>
                                        <div class="col-md-9">
                                            {{vm.model.religion}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3">
                                            Health
                                        </label>
                                        <div class="col-md-9">
                                            {{vm.model.health}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3">
                                            Marital Status
                                        </label>
                                        <div class="col-md-9">
                                            {{vm.model.marital_status}}
                                        </div>
                                    </div>
                        
                                    <div class="form-group">
                                        <label class="col-md-3">
                                            Telephone
                                        </label>
                                        <div class="col-md-9">
                                            {{vm.model.phone_number}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3">
                                            Email Address
                                        </label>
                                        <div class="col-md-9">
                                            {{vm.model.email}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3">
                                            Country
                                        </label>
                                        <div class="col-md-9">
                                            {{vm.model.country_name}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3">
                                            State/City
                                        </label>
                                        <div class="col-md-9">
                                            {{vm.model.state_city}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3">
                                            Current Position                             
                                        </label>
                                        <div class="col-md-9">
                                            {{vm.model.current_position}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3">
                                            Present Address
                                        </label>
                                        <div class="col-md-9">
                                            {{vm.model.present_address}}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <img src="{{vm.model.photo}}" alt="" srcset="" class="img-thumbnail">
                                </div>
                            </div>
                            
                            <!-- START Other -->
                            <div class="row">
                                <div class="page-header title-header col-md-12">
                                    Education Background
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <span data-ng-bind-html="vm.model.experience"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="page-header title-header col-md-12">
                                    Working Experience
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <span data-ng-bind-html="vm.model.working_history"></span>
                                </div>
                            </div>
                            <!-- START Other -->
                            <div class="row">
                                <div class="page-header title-header col-md-12">
                                    Other
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <span data-ng-bind-html="vm.model.summary"></span>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-* -->

                    </div>
                    <!-- /.center -->
                </form>
            </div>
        </div>
    </div>
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
