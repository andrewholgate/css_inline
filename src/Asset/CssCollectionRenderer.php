<?php

namespace Drupal\css_inline\Asset;

use Drupal\Core\Asset\CssCollectionRenderer as CoreCssCollectionRenderer;

/**
 * Renders CSS assets inline.
 *
 * Reinstates the ability to add CSS inline using Drupal Libraries and the flag:
 * css/example-asset.css: { inline: true }
 *
 * There has been lot of discussion around the removal of inline CSS/JS support that can be followed here:
 * https://www.drupal.org/node/2391025
 */

class CssCollectionRenderer extends CoreCssCollectionRenderer {

  /**
   * {@inheritdoc}
   */
  public function render(array $css_assets) {
    $elements = [];

    // Defaults for inline STYLE elements.
    $style_element_defaults = array(
      '#type' => 'html_tag',
      '#tag' => 'style',
    );

    foreach ($css_assets as $css_asset) {
      if (!empty($css_asset['inline'])) {
        // Render inline element.
        $element = $style_element_defaults;
        $element['#value'] = $this->getCssFileContents($css_asset['data']);
        $element['#attributes']['media'] = $css_asset['media'];
        $element['#browsers'] = $css_asset['browsers'];
        $elements[] = $element;
      }
      else {
        // Render standard elements one at a time to respect weights using Cores function.
        $elements[] = current(parent::render([$css_asset]));
      }
    }
    return $elements;
  }

  /**
   * Get CSS file contents.
   *
   * @param string $path
   */
  protected function getCssFileContents($path) {
    if (!file_exists($path)) {
      throw new \Exception('Invalid CSS asset path: ' . $path);
    }
    return file_get_contents($path);
  }
}
