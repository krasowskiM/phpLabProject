hotelAppModule.controller('roomController', function ($scope, $http) {
    $scope.headingTitle = "Rooms";
    $scope.floor = "Pick floor";

    $scope.condignation = [1, 2, 3, 4, 5];
    $scope.rooms = undefined;
    $scope.reservationSuccess = undefined;

    $scope.showFloor = function (floorNumber) {
        $http.get('api/controller/main_page/floor.php?number=' + floorNumber).then(
                function (response) {
                    $scope.rooms = response.data;
                }
        );
    };

    $scope.reserve = function (roomNumber) {
        $http.post('api/controller/main_page/reservation.php?room=' + roomNumber).then(
                function (response) {
                    var reservationStatus = response.data.message;
                    if ('OK' === reservationStatus) {
                        $scope.reservationSuccess = true;
                    } else {
                        $scope.reservationSuccess = false;
                    }
                }
        );
    };
});
