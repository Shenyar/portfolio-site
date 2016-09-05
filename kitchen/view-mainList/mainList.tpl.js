/**
 * Created by io05 on 12.08.2016.
 */
angular.module('mainListModule',['ngRoute','ngSanitize'])
    .controller('mainListCtrl',function($scope, $http, $routeParams, $location) {
        /*
        * define all elements which are used in controller
        * */
        $scope.page = undefined;
        $scope.categoryName = undefined;
        $scope.postList = undefined;
        $scope.listPages = [];

        $scope.isSelectedPage = function(input) {
            return (input == $scope.page);
        };
        $scope.categoryIsSelected = function(item) {
            return ($scope.categoryName == item.name);
        };

        if($routeParams.page > 0) {
            $scope.page = $routeParams.page;
        }
        else {
            $scope.page = 1;
        }

        if($routeParams.category != undefined) {
            $scope.categoryName = $routeParams.category;
        }
        else {
            $scope.categoryName = "All";
        }

        var res = $http.get('api/v1.0/getPostList.php',{
            params: {
                "page": $scope.page,
                "category": $scope.categoryName
            }
        });
        res.success(function(data,status,headers,config) {
            $scope.postList = data;
            for(var i = 1, len = Math.ceil($scope.postList.num_posts/4); i <= len; i++) {
                $scope.listPages[i-1] = i;
            }

            $('#main-slider').slider({
                min: 1,
                max: $scope.listPages.length,
                value: $scope.page,
                change: function(event,ui) {
                    $location.url('/'+$scope.categoryName+'/'+ui.value);
                    $scope.$apply();
                }
            });
        });

        $('#sliderWheel')[0].addEventListener('wheel',function(e) {
            e = e || window.event;
            e.preventDefault();
            var delta = e.deltaY || e.detail || e.wheelDelta;
            var val = $('#main-slider').slider('value');
            if(delta < 0) {
                val--;
            } else {
                val++;
            }
            $('#main-slider').slider('value',val);
        });
    });
