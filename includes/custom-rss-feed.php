<?php
/**
* Template Name: RSS Feed
*/
// Include the necessary files
require_once ABSPATH . WPINC . '/feed.php';

// News Feed URL
$feed_url = 'https://spotlightstudios.co.uk/feed/?rand=';
$rss_feed1 = fetch_feed($feed_url);
$feed_items1 = $rss_feed1->get_items();

// Promotions Feed URL
$feed_url_promotions = 'https://spotlightstudios.co.uk/promotions/feed/?rand=';
$rss_feed2 = fetch_feed($feed_url_promotions);
$feed_items2 = $rss_feed2->get_items();

$news_feed_array = [];
$promotion_feed_array = [];


//News Feed
if(get_option('ss_rss_feed_link') == 1 && $feed_items1 && !is_wp_error($rss_feed1)){
    $key = 0;
    foreach ($feed_items1 as $item) { 
        if( $key <=2 ){
            $news_feed_array[$key]= array(
                'featured_image' => $item->get_item_tags('','featured_image')[0]['data'],
                'title' => $item->get_title(),
                'description'=>$item->get_description(),
                'link'=> $item->get_permalink(),
            );
         }
        $key++;
    }
}

//Promotions Feed
if(get_option('ss_rss_feed_link_promotion') == 1 && $feed_items2 && !is_wp_error($rss_feed2)){
    $key = 0;
    foreach ($feed_items2 as $item) { 
        if( $key <= 2){
            $promotion_feed_array[$key]= array(
                'featured_image' => $item->get_item_tags('','featured_image')[0]['data'],
                'title' => $item->get_title(),
                'description'=>$item->get_description(),
                'link'=> $item->get_permalink(),
            );
        }
        $key++;
    }
}
// echo '<pre>';
// print_r($promotion_feed_array);
// die;

if(!empty($news_feed_array) && !empty($promotion_feed_array)){
    $a3 = merge($news_feed_array, $promotion_feed_array);
}else if(!empty($news_feed_array) && empty($promotion_feed_array)){
    $a3 = $news_feed_array;
}else if(empty($news_feed_array) && !empty($promotion_feed_array)){
    $a3 = $promotion_feed_array;
}

function merge($a1, $a2)
{
    // echo '<pre>';
    // print_r($a1);
    // // print_r($a2);
    // die;
    $a3 = [];
    // $len = count($a1);
    $lenA = count($a1);
    $lenB = count($a2);

    $len = max($lenA, $lenB);

    for($i=0;$i<$len;$i++)
    {
        if($i < $lenA){
            $a3 []= $a1[$i];
        }

        if($i < $lenB){
            $a3 []= $a2[$i];
        }
    }
    $a3 = array_filter($a3);
    return $a3;
}

foreach ($a3 as $item) { 
   ?>
    <li>
        <div class="uk-card uk-card-default">
            <div class="uk-card-media-top">
                <?php if($item['featured_image'] != ''){ ?>
                    <img src="<?php echo $item['featured_image'];?>" width="1800" height="1200" alt="">
                <?php }?>
            </div>
            <div class="uk-card-body">
                <h3 class="uk-card-title"><?php echo $item['title'];?></h3>
                <p><?php echo strip_tags(substr($item['description'], 0, 120));?></p> 
                <a href="<?php echo $item['link'] ?>" target="_blank" class="learn_more">Learn More</a>
            </div>
        </div>
    </li> 
<?php }
?>