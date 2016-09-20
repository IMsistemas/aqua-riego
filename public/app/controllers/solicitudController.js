
app.controller('solicitudController', function($scope, $http, API_URL) {

    $scope.solicitudes = [];

    $scope.initLoad = function () {
        $http.get(API_URL + 'solicitud/getSolicitudes').success(function(response){
            $scope.solicitudes = response;
        });
    };

});