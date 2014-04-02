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
foreach ($items as $item):
    if($layout != 'pc')
    {
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
    }
    date_default_timezone_set('America/Bogota');
    setlocale(LC_ALL, 'es_ES.UTF-8');
    $f = strtotime( $item->get_date('j-F-Y G:i:s') );
?>
<div class="yii-feed-widget-item noticia">
	<?php if($layout != 'pc'): ?>
        <img src="<?php echo $src ?>" width="215" alt="<?php echo $item->get_title(); ?>" />
    <?php endif; ?>
    <h3>
        <?php 
            if(mb_strlen($item->get_title()) > 90) $titulo = mb_substr($item->get_title(), 0, 90). ' ...';
            else $titulo = $item->get_title();?>
        <a href="<?php echo $item->get_permalink(); ?>" target="_blank" title="Ver la noticia <?php echo str_replace('"', "'", $titulo) ?> en el portal de Noticias Telemedellín">
            <?php echo $titulo ?>
        </a>
    </h3>
    <div class="meta">
        <time datetime="<?php echo $item->get_date('Y-m-d G:i:s') ?>"><?php echo ucfirst(strftime('%B %e, %l:%M', $f)) . ' ' . date('a', $f); ?></time> - <span><?php echo $item->get_category()->get_term(); ?></span>
    </div>
</div>
<?php endforeach; ?>