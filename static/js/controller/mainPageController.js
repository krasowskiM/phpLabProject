var main;
var mainScope;
hotelAppModule.controller('mainPageController', function ($scope, $http, $state) {
    mainScope = $scope;
    $scope.greeting = "Hello!";
    $scope.isLoggedIn = false;
    $scope.logoutMessage = undefined;

    $scope.logout = function () {
        $http.get('api/controller/main_page/logout.php').then(
                function (response) {
                    $scope.logoutMessage = response.data.message;
                });
        mainScope.isLoggedIn = false;
    };
});
