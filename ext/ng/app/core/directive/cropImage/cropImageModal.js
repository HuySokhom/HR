(function () {
    app.controller('cropImageModalCtrl', [
        '$scope', 
         'Restful',
        function ($scope, Restful) {
            var vm = this;
            //when local data is changed, update model from outside
            $scope.$watch('resultImage', function (newValue, oldValue) {
                //check to make sure no loop cycle
                if ($scope.resultImage != newValue) {
                    $scope.resultImage = newValue;
                }
            });
            vm.done = function(){
                $scope.resultImage = $scope.croppedDataUrl;
                vm.loading = true;
                Restful.save( 'api/ImageUploadBase64' , {fileName: $scope.resultImage}).success(function (data) {
                    console.log(data);
                    $('#crop-image-popup').modal('hide');
                    $scope.imagePath = data.fileName;
                }).finally(function(){
                    vm.loading = false;
                });
            };
        }
    ]);

    app.directive('cropImageModal', [
        function () {
            return {
                restrict: 'AE',
                scope: {
                    resultImage: '=',
                    imagePath: '='
                },
                require: ['?ngModel'],
                templateUrl: 'js/ng/app/core/directive/cropImage/cropImageModal.html',
                controller: 'cropImageModalCtrl as vm',
                link: function ($scope, element, attrs) {
                    //@todo
                }
            };
        }
    ]);
})();