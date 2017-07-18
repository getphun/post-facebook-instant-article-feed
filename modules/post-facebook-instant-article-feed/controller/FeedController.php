<?php
/**
 * FB Instant Article Feed
 * @package post-facebook-instant-article-feed
 * @version 0.0.1
 * @upgrade true
 */

namespace SitePostFacebookInstantArticleFeed\Controller;
use Post\Model\Post;
use PostFacebookInstantArticleFeed\Model\PostFbInstantArticle as PFbIArticle;
use Core\Library\View;

class FeedController extends \SiteController
{
    public function indexAction(){
        // get 10 post that's not yet in instant article
        $sql = "
            SELECT `p`.* FROM `post` AS `p`
                LEFT JOIN `post_fb_instant_article` AS `fb`
                    ON `p`.`id` = `fb`.`post`
            WHERE `fb`.`content` IS NULL
                AND `p`.`status` = 4
            ORDER BY `p`.`updated` DESC
            LIMIT 10";
        
        $posts = Post::query($sql);
        if($posts){
            $posts = \Formatter::formatMany('post', $posts, false, ['content', 'user']);
            foreach($posts as $post){
                $post_content = new \Cinstant($post->content->value);
                $post->instant = $post_content->article;
                $html = new View('site', 'post/facebook-instant-article/post', ['post'=>$post]);
                $post->i_content = $html->content;
                PFbIArticle::create([
                    'post' => $post->id,
                    'content' => $post->i_content
                ]);
            }
        }else{
            $posts = [];
        }
        
        $this->res->addHeader('Content-Type', 'application/xml; charset=UTF-8');
        $this->respond('post/facebook-instant-article/feed', [
            'posts' => $posts,
            'last_update' => date('r'),
            'feed' => (object)[
                'title' => $this->setting->frontpage_title,
                'url'   => $this->router->to('siteHome'),
                'description' => $this->setting->frontpage_description
            ]
        ]);
    }
}