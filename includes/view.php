<?php 

function mavl_grid_view($response, $type) {
  switch($type){
    case 'albums': 
      mavl_albums_grid_view($response);
      break;
    case 'videos':
      mavl_videos_grid_view($response);
      break;
    case 'video': 
      mavl_video_view($response);
      break;
    default: break;
  }
}

function mavl_albums_grid_view( $response, $options = array() ) {
  $items = $response['body']['data'];
  $per_page = $response['body']['per_page'];
  $total = ( $items ) ? $response['body']['total'] : 0;
  $page = $response['body']['page'];
  $previous = $response['body']['paging']['previous'];
  $next = $response['body']['paging']['next'];
  $pages = ($per_page) ? ceil(($total / $per_page)) : 0;
?>
  <div class="mavl-vimeo-albums-container">
    <div class='mavl-vimeo-albums'>
      <h1 class="mavl-title">All Albums</h1>
      <div class="mavl-breadcrumbs"></div>

      <?php if( $items ) : ?>
        
        <div class="mavl-vimeo-grid mavl-vimeo-albums-grid">
          <ul class="mavl-vimeo-list">
          <?php $cnt = 0;
            foreach($items as $item):
              $image_url = $item['pictures']['sizes'][2]['link'];
              $src = $image_url ? $image_url : plugin_dir_url( __FILE__ ) . '../assets/images/album.jpg';
          ?><li class="mavl-item">
              <a href="<?php echo esc_url( mavl_generate_link($item['uri']) ); ?>" rel="nofollow"><img class="mavl-item-image" src="<?php echo esc_url( $src ); ?>" width="295" height="166"/></a>
              <div class="mavl-overlay">
                <span class="text"><a href="<?php echo esc_url( mavl_generate_link($item['uri']) ); ?>"><?php echo esc_html( $item['name'] ); ?></a></span>
              </div>
            </li><?php 
            if(++$cnt >= 3) break;
            endforeach; // foreach $items ?>
          
          </ul>
        </div>

      <?php else: ?>
      
        <p>No albums found.</p>
     
      <?php endif; // Check $items ?> 
      
      
    </div><!-- .mavl-vimeo-albums -->
  </div><!-- .mavl-vimeo-albums-container -->

<?php
}

function mavl_videos_grid_view($response, $options = array()) {
$items = $response['body']['data'];
$per_page = $response['body']['per_page'];
$total = ( $items ) ? $response['body']['total'] : 0;
$page = $response['body']['page'];
$previous = $response['body']['paging']['previous'];
$next = $response['body']['paging']['next'];
$pages = ($per_page) ? ceil(($total / $per_page)) : 0;

if (isset($_GET['albums'])){
  $album_id = $_GET['albums'];
  $album_data = mavl_album_data( $album_id );
  if (isset($album_data['body'])) {
    $album_name = $album_data['body']['name']; 
  }
}

?>
  <div class="mavl-vimeo-albums-container">
    <div class='mavl-vimeo-videos'>
      <h1 class="mavl-title"><?php 
        if ( isset($options['label']) ) 
          echo $options['label'];
        else if (isset($album_name))
          echo $album_name;
        else
          echo 'Videos'; 
      ?></h1>
      
      <div class="mavl-breadcrumbs">
      <?php if( !(isset($options['breadcrumbs']) && $options['breadcrumbs'] == 'false') ): ?>
        <a href="<?php echo mavl_generate_link('/'); ?>">All Albums</a>
        <?php if ( isset($options['keyword']) ) echo "&rarr; Search for '". $options['keyword'] . "'"; ?>
        <?php if ( isset($album_name) ) echo "&rarr; ". $album_name; ?>
      <?php endif; ?>
      </div>

      <?php if( $items ) : ?>
        
        <div class="mavl-vimeo-grid mavl-vimeo-videos-grid">
          <ul class="mavl-vimeo-list">
          <?php 
            foreach($items as $item):
              $link = $item['pictures']['sizes'][2]['link'];
              $src = $link ? $link : plugin_dir_url( __FILE__ ) . '../assets/images/vimeo-album.png';
              $video_name = $item['name'];
          ?><li class="mavl-item">
              <a href="<?php echo esc_url( mavl_generate_link($item['uri']) ); ?>" rel="nofollow"><img class="mavl-item-image" src="<?php echo esc_url( $src ); ?>" width="295" height="166"/></a>
              <div class="mavl-overlay">
                <span class="text"><a href="<?php echo esc_url( mavl_generate_link($item['uri']) ); ?>"><?php echo esc_html( $video_name ); ?></a></span>
              </div>
            </li><?php endforeach; // foreach $items ?>
          
          </ul>
        </div>
        
        <?php if ( !(isset($options['pagination']) && $options['pagination'] == 'false') && $pages != 0): ?>
          <div class="mavl-pagination">
            <div class="mavl-pagination-page">Page <?php echo $page . ' of ' . $pages; ?></div>
            <div class="mavl-previous-next">
              <?php if ($previous) : ?><span class="mavl-previous-link"><a href="<?php echo mavl_generate_link($previous); ?>">&larr;Previous</a></span><?php endif; ?>
              <?php if ($next) : ?><span class="mavl-next-link"><a href="<?php echo mavl_generate_link($next); ?>">Next &rarr;</a></span><?php endif; ?>
            </div>
          </div><!-- .mavl-pagination -->
        <?php endif; ?>
        
      
      <?php else: ?>
      
        <p>No videos found.</p>
     
      <?php endif; // Check $items ?> 
      
    </div><!-- .mavl-vimeo-videos -->
  </div><!-- .mavl-vimeo-albums-container -->

<?php
}

function mavl_video_view($response, $options = array()) {
$video_uri = explode("/",$response['body']['uri']);
$video_id = $video_uri[2];
$video_name = $response['body']['name']; 
?>

  <div class="mavl-vimeo-albums-container">
    <div class='mavl-vimeo-video'>
      <h1 class="mavl-title"><?php echo $video_name; ?></h1>
   
      <div class="mavl-breadcrumbs">
        <a href="<?php echo mavl_generate_link('/'); ?>">All Albums</a>
        <?php if ( isset($video_name) ) echo "&rarr; ". $video_name; ?>        
      </div>

      <div class="mavl-player-container">
        <iframe src="<?php echo esc_url('https://player.vimeo.com/video/' . $video_id .'?badge=0&amp;autopause=0&amp;player_id=0'); ?>" frameborder="0" title="<?php echo esc_attr( $response['body']['name'] ); ?>" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>
      </div>
        
    </div><!-- .mavl-vimeo-video -->
  </div><!-- .mavl-vimeo-albums-container -->

<?php
}