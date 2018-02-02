var hotelAppModule = angular.module('hotelApp', ['ui.router']);

hotelAppModule.config(function ($stateProvider, $urlRouterProvider) {
    $urlRouterProvider.otherwise('/main');

    $stateProvider
            .state('main', {
                url: '/main',
                templateUrl: 'static/views/main.html',
                controller: 'mainPageController'
            })
            .state('main.login', {
                url: '/login',
                templateUrl: 'static/views/login.html',
                controller: 'loginController'
            })
            .state('main.registration', {
                url: '/register',
                templateUrl: 'static/views/register.html',
                controller: 'registerController'
            })
            .state('main.userPanel', {
                url: '/panel',
                templateUrl: 'static/views/userPanel.html',
                controller: 'userPanelController'
            })
            .state('main.userPanel.rooms', {
                url: '/rooms',
                templateUrl: 'static/views/rooms.html',
                controller: 'roomController'
            })
            .state('main.userPanel.rooms.floor', {
                url: '/floor',
                templateUrl: 'static/views/floor.html',
                controller: 'roomController'
            })





            ;
});



