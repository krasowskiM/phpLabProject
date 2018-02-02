hotelAppModule.controller('loginController', function ($scope, $http, $state) {
    $scope.loginError = null;
    $scope.login = function () {
        $http.post('api/controller/main_page/login.php', $scope.credentials).then(
                function (response) {
                    if (response.data.message === 'OK') {
                        mainScope.isLoggedIn = true;
                        $state.go('main.userPanel');
                    } else {
                        $scope.loginError = response.data;
                    }
                });
    };
});
