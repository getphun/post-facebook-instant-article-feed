<?php
/**
 * Post instant events
 * @package post-facebook-instant-article-feed
 * @version 0.0.1
 * @upgrade false
 */

namespace SitePostFacebookInstantArticleFeed\Event;
use PostFacebookInstantArticleFeed\Model\PostFbInstantArticle as PFbIArticle;

class PostEvent{
    
    static function general($object, $old=null){
        if($old)
            PFbIArticle::remove(['post'=>$old->id]);
        elseif($object)
            PFbIArticle::remove(['post'=>$object->id]);
    }
    
    static function updated($object, $old=null){
        self::general($object, $old);
    }
    
    static function deleted($object){
        self::general($object);
    }
}
