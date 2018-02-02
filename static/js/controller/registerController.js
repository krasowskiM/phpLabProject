hotelAppModule.controller('registerController', function ($scope, $http) {
    $scope.showForm = true;
    $scope.showInfo = false;
    $scope.registerError = null;
    $scope.register = function () {
        $http.put('api/controller/main_page/register.php', $scope.credentials).then(
                function (response) {
                    if ('OK' === response.data.message) {
                        $scope.registerError = null;
                        $scope.showForm = false;
                        $scope.showInfo = true;
                    } else {
                        $scope.registerError = response.data;
                    }
                });
    };
});
