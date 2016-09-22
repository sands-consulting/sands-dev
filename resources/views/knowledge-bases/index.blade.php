@extends('layouts.master')

@section('content')
<div ng-app="kb">
    <h2 class="page-header">
        <span ng-show="title"><a ui-sref="main">Home</a> \ </span>
        <span ng-show="title" ng-bind="title"></span>
        <span ng-hide="title">Knowledge Base</span>
    </h2>
    <ui-view></ui-view>


    @include('knowledge-bases.templates')

</div>

@endsection


@section('scripts')
<script src="{{ elixir('js/kb.js') }}"></script>
<script>
    angular.module('kb')
        .service('es', function (esFactory) {
            return esFactory({
                host: 'localhost:9200',
            });
        })
        .config(function($stateProvider, $urlRouterProvider) {


            function docs(es, $q, $sce) {
                var deferred = $q.defer();
                es.search({
                    index: 'sands_dev_kb',
                    body: {
                        fields: [
                            'title',
                            'category',
                            'tags',
                        ],
                        size: 15,
                        sort: [
                            {
                                _timestamp: {
                                    order: 'desc'
                                }
                            }
                        ]
                    },
                }, function (error, response) {
                    deferred.resolve(response.hits.hits);
                });
                return deferred.promise;
            }

            function categories(es, $q, $sce) {
                var deferred = $q.defer();
                es.search({
                    index: 'sands_dev_kb',
                    body: {
                        aggs: {
                            categories: {
                                terms: {
                                    field: "category"
                                }
                            }
                        },
                        size: 0,
                        sort: [
                            {
                                _timestamp: {
                                    order: 'desc'
                                }
                            }
                        ]
                    },
                }, function (error, response) {
                    deferred.resolve(response.aggregations.categories.buckets);
                });
                return deferred.promise;
            }

            function tags(es, $q, $sce) {
                var deferred = $q.defer();
                es.search({
                    index: 'sands_dev_kb',
                    body: {
                        aggs: {
                            tags: {
                                terms: {
                                    field: "tags"
                                }
                            }
                        },
                        size: 0,
                        sort: [
                            {
                                _timestamp: {
                                    order: 'desc'
                                }
                            }
                        ]
                    },
                }, function (error, response) {
                    deferred.resolve(response.aggregations.tags.buckets);
                });
                return deferred.promise;
            }

            var mainState = {
                name: 'main',
                url: '/main',
                templateUrl: 'main.html',
                resolve: {
                    docs: docs,
                    categories: categories,
                    tags: tags
                },
                controller: 'MainController'
            }

            var mainCategoryState = {
                name: 'main.category',
                url: '/main/category/:category',
                templateUrl: 'main.html',
                abstract: true,
                controller: 'MainController'
            }

            var viewState = {
                name: 'view',
                url: '/read/:id',
                templateUrl: 'view.html',
                resolve: {
                    doc: function($stateParams, $q, es, $sce) {
                        var deferred = $q.defer();
                        es.get({
                            index: 'sands_dev_kb',
                            type: 'docs',
                            id: $stateParams.id,
                        }, function(error, response){
                            response._source.contents = $sce.trustAsHtml(response._source.contents);
                            deferred.resolve(angular.extend({
                                _id: response._id
                            }, response._source));
                        });
                        return deferred.promise;
                    }
                },
                controller: 'ViewController',
                onEnter: function($rootScope, doc) {
                    $rootScope.title = doc.title;
                },
                onExit: function($rootScope) {
                    $rootScope.title = '';
                }
            }

            var createState = {
                name: 'create',
                url: '/create',
                templateUrl: 'form.html',
                controller: 'CreateController',
                onEnter: function($rootScope) {
                    $rootScope.title = 'New KB';
                },
                onExit: function($rootScope) {
                    $rootScope.title = '';
                }
            }

            var updateState = {
                name: 'update',
                url: '/update/:id',
                templateUrl: 'form.html',
                controller: 'UpdateController',
                resolve: {
                    doc: function($stateParams, $q, es) {
                        var deferred = $q.defer();
                        es.get({
                            index: 'sands_dev_kb',
                            type: 'docs',
                            id: $stateParams.id,
                        }, function(error, response){
                            response._source.tags = response._source.tags.join('; ');
                            deferred.resolve(angular.extend({
                                _id: response._id
                            }, response._source));
                        });
                        return deferred.promise;
                    }
                },
                onEnter: function($rootScope, doc) {
                    $rootScope.title = 'Update ' + doc.title;
                },
                onExit: function($rootScope) {
                    $rootScope.title = '';
                }
            }

            $stateProvider
                .state(mainState)
                .state(mainCategoryState)
                .state(viewState)
                .state(createState)
                .state(updateState)
                ;
            $urlRouterProvider.otherwise('/main');
        })

        .controller('MainController', function($scope, docs, categories, tags){
            $scope.docs = docs;
            $scope.categories = categories;
            $scope.tags = tags;
            console.log(docs)
        })

        .controller('ViewController', function($scope, doc, es, $state){
            $scope = angular.extend($scope, doc);
            $scope.delete = function() {
                if(confirm('Are you sure you want to delete ' + doc.title + '?')) {
                    es.delete({
                        index: 'sands_dev_kb',
                        type: 'docs',
                        id: doc._id,
                        refresh: true,
                    }, function (error, response) {
                        $state.go('main');
                    });
                }
            }
        })

        .controller('CreateController', function($scope, es, $state) {
            $scope.form = {
                title: '',
                category: '',
                contents: '',
                tags: '',
            };
            $scope.save = function() {
                es.create({
                    index: 'sands_dev_kb',
                    type: 'docs',
                    body: {
                        title: $scope.form.title,
                        category: $scope.form.category,
                        contents: $scope.form.contents,
                        tags: $scope.form.tags.split(';').map(function(tag){
                            return tag.trim();
                        }),
                    }
                }, function (error, doc) {
                    if(doc) {
                        $state.go('view', {id: doc._id})
                    }
                });
            }
        })

        .controller('UpdateController', function($scope, es, $state, doc) {
            $scope.form = angular.extend({}, doc);
            $scope.save = function() {
                console.log(doc)
                es.update({
                    index: 'sands_dev_kb',
                    type: 'docs',
                    id: doc._id,
                    body: {
                        doc: {
                            title: $scope.form.title,
                            category: $scope.form.category,
                            contents: $scope.form.contents,
                            tags: $scope.form.tags.split(';').map(function(tag){
                                return tag.trim();
                            }),
                        }
                    }
                }, function (error, doc) {
                    if(doc) {
                        $state.go('view', {id: doc._id})
                    }
                });
            }
        })

        ;
</script>
@endsection
