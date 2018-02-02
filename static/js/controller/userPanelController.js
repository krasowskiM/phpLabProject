hotelAppModule.controller('userPanelController', function ($scope, $http, $state) {
    $scope.headingTitle = "User panel";
    $scope.userPanelTO = undefined;

    $http.get('api/controller/main_page/user.php').then(function (response) {
        $scope.userPanelTO = response.data;
    });
});
