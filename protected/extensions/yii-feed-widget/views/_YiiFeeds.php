<?php
/**
 * FileDoc: 
 * View Partial for YiiFeedWidget.
 * This extension depends on both idna convert and Simple Pie php libraries
 *  
 * PHP version 5.3
 * 
 * @category Extensions
 * @package  YiiFeedWidget
 * @author   Richard Walker <richie@mediasuite.co.nz>
 * @license  BSD License http://www.opensource.org/licenses/bsd-license.php
 * @link     http://mediasuite.co.nz
 * @see      simplepie.org
 * @see      http://www.phpclasses.org/browse/file/5845.html
 * 
 */
?>

<?php foreach ($items as $item):

	$img =  stristr ( $item->get_content() , "<img"); 
    $second = strpos($img, ">");
    $img = substr($img, 0, $second);  
    $src = substr($img, strpos($img, "src=") + 5 ) ;                
    $params = preg_split('[\"|\']', $src, 2);                  
    if($params[0] == "" || $params[0] == "/" || $params[0] == " "){
      $src = "/images/default.jpg";
    }
    else{
      $src = $params[0];
    }
?>
<div class="yii-feed-widget-item noticia">
	<img src="<?php echo $src ?>" width="50" height="50" alt="<?php echo $item->get_title(); ?>" />
    <h3>
        <?php 
            if(strlen($item->get_title()) > 75) $titulo = substr($item->get_title(), 0, 75). ' ...';
            else $titulo = $item->get_title();?>
        <a href="<?php echo $item->get_permalink(); ?>">
            <?php echo $titulo ?>
        </a>
    </h3>
    <div class="meta"><time><?php echo $item->get_date('j F, g:i'); ?></time> - <span><?php echo $item->get_category()->get_term(); ?></span></div>
</div>
<?php endforeach; ?>
