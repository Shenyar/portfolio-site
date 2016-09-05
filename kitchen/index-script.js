/**
 * Created by io05 on 09.08.2016.
 */
angular.module('kitchen',['ngRoute','mainListModule','mainPostModule'])
    .config(function($routeProvider) {
        $routeProvider.when('/post/:postId',{
            templateUrl: 'view-mainPost/mainPost.tpl.html'
        }).when('/',{
            templateUrl: 'view-mainList/mainList.tpl.html'
        }).when('/:page',{
            templateUrl: 'view-mainList/mainList.tpl.html'
        }).when('/:category/:page',{
            templateUrl: 'view-mainList/mainList.tpl.html'
        }).otherwise('/');
    })
    .controller('kitchenCtrl',function($scope) {

        $('#mobileDropdown').bind('click',mobileDropdown);

        function mobileDropdown() {
            event.stopPropagation();
            $('#mobileDroplist').removeClass('hidden-xs').addClass('dropMenu');
            window.addEventListener('click',mobileDropup);
        }
        function mobileDropup() {
            $('#mobileDroplist').removeClass('dropMenu').addClass('hidden-xs');
            window.removeEventListener('click', mobileDropup);
        }
    });