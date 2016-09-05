/**
 * Created by io05 on 16.08.2016.
 */
angular.module('mainPostModule',['ngRoute','ngSanitize'])
    .controller('mainPostCtrl',function($scope, $http, $routeParams) {
        $scope.getRand = function(start,end) {
            return start + Math.round(Math.random() * (end - start));
        };

        /*
         * define all elements which are used in controller
         * */
        $scope.postId = $routeParams.postId;
        $scope.apiData;
        $scope.commentName;
        $scope.commentEmail;
        $scope.commentContent;
        $scope.commentCaptcha;
        $scope.captchaId = $scope.getRand(1,3);
        $scope.captchaPlaceholder = [
            'Type the name of the round brown object in the picture. *',
            'Type the name of the room shown in the picture. *',
            'Type the name of the object to the right of the barrel. *'
        ];

        $scope.submitComment = function() {
            /*test input information*/
            var err = 0;
            if( ! $scope.commentName ) {
                $('#commentName').addClass('has-error');
                $('#commentName *').attr('placeholder','You did not type Name!');
                err++;
            }
            else {
                $('#commentName').removeClass('has-error');
            }
            if( $scope.commentEmail.search( /^[\w-]+@[\w-]+\.[\w-]+$/i ) == -1 ) {
                $scope.commentEmail = "";
                $('#commentEmail').addClass('has-error');
                $('#commentEmail *').attr('placeholder','Incorrect Email!');
                err++;
            }
            else {
                $('#commentEmail').removeClass('has-error');
            }
            if( ! $scope.commentContent ) {
                $('#commentContent').addClass('has-error');
                $('#commentContent *').attr('placeholder','You did not type Comment!');
                err++;
            }
            else {
                $('#commentContent').removeClass('has-error');
            }
            if( err ) return;

            /*post comment*/
            $http.post('api/v1.0/submitComment.php',{
                commentName: $scope.commentName,
                commentEmail: $scope.commentEmail,
                commentContent: $scope.commentContent,
                captchaId: $scope.captchaId,
                commentCaptcha: $scope.commentCaptcha,
                postId: $scope.postId
            }).success(function(data) {
                alert(data);
                location.reload();
            })
        };

        $http.get('api/v1.0/getPost.php',{
            params: {
                "id": $scope.postId
            }
        }).success(function(data) {
            $scope.apiData = data;
            $scope.apiData.selectedPost.comments.forEach(function(item) {
                item.imgNum = $scope.getRand(1,4);
            });
        });
    });