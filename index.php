<!doctype html>
<html >
  <head>
    <title>My Angular App</title>
    <script src="angular.min.js"></script>

  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="bootstrap.min.css" >


  </head>
  <body ng-app="pagingtable">
  
<section id="main-content" class="animated fadeInRight">
    <div class="row">
        <div class="col-md-12" ng-controller="activityTableCtrl as datax">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Table Biodata</h3>
              </div>
              <div class="panel-body">
              <!-- TOP OF TABLE: shows page size and search box -->
              <div class="dataTables_wrapper form-inline" role="grid">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="dataTables_length" id="example_length">
                            <label>
                            <select name="example_length" aria-controls="example" class="form-control input-sm" ng-model="pageSize" ng-change="pageSizeChanged()">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select> records per page</label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div id="example_filter" class="dataTables_filter">
                            <label>Search:<input type="search" class="form-control input-sm" aria-controls="example" ng-model="searchText" ng-change="searchTextChanged()"></label>
                        </div>
                    </div>
                </div>                        

                <!-- DATA TABLE: shows the results -->
                <!-- <table id="example" class="table table-striped table-bordered" datatable="" cellspacing="0" width="100%"> -->
                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Telpon</th>
                        
                    </tr>
                </thead>

                <tbody>
                    <tr ng-repeat = "x in activity" total-items="totalItems">
                        <td>{{x.nama}}</td>
                        <td>{{x.jenis_kelamin}}</td>
                        <td>{{x.telpon}}</td>
                    </tr>
                </tbody>
                </table>

                <!-- BOTTOM OF TABLE: shows record number and pagination control -->
                <div class="row">
                    <div class="col-sm-6">
                        <div class="dataTables_info" ole="alert" aria-live="polite" aria-relevant="all">Showing {{startItem}} to {{endItem}} of {{totalItems}} entries</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="dataTables_paginate paging_simple_numbers">
                        <paging
                          page="currentPage" 
                    page-size="pageSize" 
                    total="totalItems" 
                    show-prev-next="true"
                     paging-action="pageChanged('Paging Clicked', page, pageSize, totalItems)">
                        </paging>
                         
                    </div>
                </div>                      
              </div>
              </div>
            </div>
        </div>
    </div>
 </section>

<script>
// Portal Activity Table Control
var app = angular.module("pagingtable",['bw.paging']);
 app.controller('activityTableCtrl', function($scope, $http) {

    $scope.currentPage = 1;
    $scope.totalItems = 0;
    $scope.pageSize = 10;
    $scope.searchText = '';
    getData();

    function getData() {
     $http.get('api.php?page=' + $scope.currentPage + '&size=' + $scope.pageSize + '&search=' + $scope.searchText)
        .success(function(data) {
            $scope.activity = [];
            $scope.totalItems = data.totalCount;
            $scope.startItem = ($scope.currentPage - 1) * $scope.pageSize + 1;
            $scope.endItem = $scope.currentPage * $scope.pageSize;
            if ($scope.endItem > $scope.totalCount) {$scope.endItem = $scope.totalCount;}

            angular.forEach(data.Biodata, function(temp){
                $scope.activity.push(temp);
            });
        });
    }

    $scope.pageChanged = function(text, page, pageSize, total) {
        $scope.currentPage = page;
        getData();
    }
    $scope.pageSizeChanged = function() {
        $scope.currentPage = 1;
        getData();
    }
    $scope.searchTextChanged = function() {
        $scope.currentPage = 1;
        getData();
    }
 }) 

</script>
     <script src="paginate.js"></script>
</body>
</html>