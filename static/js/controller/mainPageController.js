var main;
var mainScope;
hotelAppModule.controller('mainPageController', function($scope, $state){
    mainScope = $scope;
    $scope.greeting = "Hello!";
    $scope.isLoggedIn = false;
    
    $scope.logout = function(){
        mainScope.isLoggedIn = false;
        $state.go('main');
    };
});
