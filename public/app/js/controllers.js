(function() {
    var as = angular.module('myApp.controllers', []);
    as.controller('AppCtrl', function($scope, $rootScope, $http, i18n, $location) {
        $scope.language = function() {
            return i18n.language;
        };
        $scope.setLanguage = function(lang) {
            i18n.setLanguage(lang);
        };
        $scope.activeWhen = function(value) {
            return value ? 'active' : '';
        };

        $scope.path = function() {
            return $location.url();
        };

//        $scope.login = function() {
//            $scope.$emit('event:loginRequest', $scope.username, $scope.password);
//            //$location.path('/login');
//        };

//        $scope.logout = function() {
//            $rootScope.user = null;
//            $scope.username = $scope.password = null;
//            $scope.$emit('event:logoutRequest');
//            $location.url('/');
//        };

        $rootScope.appUrl = "http://localhost";

    });

    as.controller('AlbumListCtrl', function($scope, $rootScope, $http, $location) {
        var load = function() {
            console.log('call load()...');
            $http.get($rootScope.appUrl + '/albums')
                    .success(function(data, status, headers, config) {
                        $scope.albums = data.data;
                        angular.copy($scope.albums, $scope.copy);
                    });
        }

        load();

        $scope.addAlbum = function() {
            console.log('call addAlbum');
            $location.path("/new");
        }

        $scope.editAlbum = function(index) {
            console.log('call editAlbum');
            $location.path('/edit/' + $scope.albums[index].id);
        }

        $scope.delAlbum = function(index) {
            console.log('call delAlbum');
            var todel = $scope.albums[index];
            $http
                    .delete($rootScope.appUrl + '/albums/' + todel.id)
                    .success(function(data, status, headers, config) {
                        load();
                    }).error(function(data, status, headers, config) {
            });
        }

    });

    as.controller('NewAlbumCtrl', function($scope, $rootScope, $http, $location) {

        $scope.album = {};
        $scope.saveAlbum = function() {
            console.log('call saveAlbum');
            $http.post($rootScope.appUrl + '/albums', $scope.album)
                    .success(function(data, status, headers, config) {
                        console.log('success...');
                        $location.path('/albums');
                    })
                    .error(function(data, status, headers, config) {
                         console.log('error...');
                    });
        }
    });

    as.controller('EditAlbumCtrl', function($scope, $rootScope, $http, $routeParams, $location) {
        $scope.album = {};
        
        var load = function() {
            console.log('call load()...');
            $http.get($rootScope.appUrl + '/albums/' + $routeParams['id'])
                    .success(function(data, status, headers, config) {
                        $scope.album = data.data;
                        angular.copy($scope.album, $scope.copy);
                    });
        };

        load();  

        $scope.updateAlbum = function() {
            console.log('call updateAlbum');

            $http.put($rootScope.appUrl + '/albums/' + $scope.album.id, $scope.album)
                    .success(function(data, status, headers, config) {
                        $location.path('/albums');
                    })
                    .error(function(data, status, headers, config) {
                    });
		}
    });

}());