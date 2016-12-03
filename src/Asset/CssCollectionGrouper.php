<?php

namespace Drupal\css_inline\Asset;

use Drupal\Core\Asset\CssCollectionGrouper as CoreCssCollectionGrouper;

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
        $item['group'] = $item['group'] - 1;
      }
    }
    return parent::group($css_assets);
  }

}
