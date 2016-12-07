<?php

namespace Drupal\css_inline\Asset;

use Drupal\Core\Asset\CssCollectionGrouper as CoreCssCollectionGrouper;

/**
 * The default aggregation group for inline CSS files added to the page.
 */
const CSS_AGGREGATE_INLINE = 200;

/**
 * Groups CSS assets.
 */
class CssCollectionGrouper extends CoreCssCollectionGrouper {

  /**
   * {@inheritdoc}
   */
  public function group(array $css_assets) {
    // Alter inline group so that it isn't aggregated with regular files.
    foreach ($css_assets as &$item) {
      if (!empty($item['inline'])) {
        $item['group'] = CSS_AGGREGATE_INLINE;
      }
    }
    return parent::group($css_assets);
  }

}
