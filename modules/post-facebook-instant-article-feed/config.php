<?php
/**
 * post-facebook-instant-article-feed config file
 * @package post-facebook-instant-article-feed
 * @version 0.0.1
 * @upgrade true
 */

return [
    '__name' => 'post-facebook-instant-article-feed',
    '__version' => '0.0.1',
    '__git' => 'https://github.com/getphun/post-facebook-instant-article-feed',
    '__files' => [
        'modules/post-facebook-instant-article-feed' => [
            'install',
            'remove',
            'update'
        ],
        'theme/site/post/facebook-instant-article' => [
            'install',
            'remove'
        ]
    ],
    '__dependencies' => [
        'post',
        'db-mysql'
    ],
    '_services' => [],
    '_autoload' => [
        'classes' => [
            'Cinstant'                                                          => 'modules/post-facebook-instant-article-feed/third-party/Cinstant.php',
            'SitePostFacebookInstantArticleFeed\\Controller\\FeedController'    => 'modules/post-facebook-instant-article-feed/controller/FeedController.php',
            'PostFacebookInstantArticleFeed\\Model\\PostFbInstantArticle'       => 'modules/post-facebook-instant-article-feed/model/PostFbInstantArticle.php',
            'SitePostFacebookInstantArticleFeed\\Event\\PostEvent'              => 'modules/post-facebook-instant-article-feed/event/PostEvent.php'
        ],
        'files' => []
    ],
    '_routes' => [
        'site' => [
            'sitePostFacebookInstantArticleFeed' => [
                'rule' => '/post/instant.xml',
                'handler' => 'SitePostFacebookInstantArticleFeed\\Controller\\Feed::index'
            ]
        ]
    ],
    
    'events' => [
        'post:updated' => [
            'post-facebook-instant-article-feed' => 'SitePostFacebookInstantArticleFeed\\Event\\PostEvent::updated'
        ],
        'post:deleted' => [
            'post-facebook-instant-article-feed' => 'SitePostFacebookInstantArticleFeed\\Event\\PostEvent::deleted'
        ]
    ]
];