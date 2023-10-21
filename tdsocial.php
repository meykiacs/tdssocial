<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use TdSocial\CPTResource\Model\CPT;
use TdSocial\CPTResource\Model\CPTResource;
use TdSocial\CPTResource\Service\RegisterCPTResource;
use TdSocial\Models\Meta\SocialMeta;

/**
 * Plugin Name: tdsocial
 * Description: A plugin for social network
 * Author:      meykiacs
 */

defined('ABSPATH') or exit;

require __DIR__ . '/vendor/autoload.php';

$tds_containerBuilder = new ContainerBuilder();
$tds_containerBuilder->addDefinitions([
  'prefix'  => 'tds',
  'plugin.filepath' => __FILE__,
  'textDomain' => DI\value('tdsocial'),
  'rest.namespace' => DI\value('tdsocial/v1'),
  'cpt.social' => function (ContainerInterface $c) {
    $cpt = new CPT('social', 'Social');
    $cpt->metas[] = new SocialMeta();
    $cptResource = new CPTResource($cpt);
    return $cptResource;
  },
]);

$tds_container = $tds_containerBuilder->build();


// register social posttype
$tds_container->get(RegisterCPTResource::class)->add($tds_container->get('cpt.social'))->register();


function tds_getResourceList(string $postType, int $maxNumber = -1) {

  $resourceList = [];
  $query = new \WP_Query(

    [
      'post_type' => $postType,
      'posts_per_page' => $maxNumber,
    ]
  );

  if ($query->have_posts()) {
    while ($query->have_posts()) {
      $query->the_post();
      $id = get_the_ID();
      $resource = array(
        'id'  =>  get_the_ID(),
        'type'  =>  get_post_type(get_the_ID()),
        'title' => get_the_title(),
        'content' => get_the_content(),
        'permalink' => get_permalink(),
        'featured_media_url' => get_the_post_thumbnail_url($id, 'medium'),
        'featured_media' => get_post_thumbnail_id($id),
        'meta'  =>  ['_tds_social' => get_post_meta($id, '_tds_social', true)]
      );
      array_push($resourceList, $resource);
    }
  }
  wp_reset_query();

  return $resourceList;
}

function tds_render() {
  global $tds_container;
  $prefix = 'tds';
  $postTypeWithLang = 'tds_social';

  // Get the CPTResource instance
  $cptResource = $tds_container->get('cpt.social');

  $data = tds_getResourceList($postTypeWithLang);

?>
  <pre style="display: none !important" id="social">
  <?php echo wp_json_encode($data, JSON_HEX_TAG); ?>
  </pre>
  <div style="display: none !important" id="social-data" data-fetched="1" data-rest-url="<?php echo esc_attr(get_rest_url(null, 'wp/v2/tds_social')); ?>">
  </div>
<?php
}
