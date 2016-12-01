<?php

namespace Drupal\css_inline;

use Drupal\Core\Asset\CssCollectionRenderer as CoreCssCollectionRenderer;

class CssCollectionRenderer extends CoreCssCollectionRenderer {

  /**
   * {@inheritdoc}
   */
  public function render(array $css_assets) {;
    $elements = [];
    $standard_css_assets = [];
    foreach ($css_assets as $css_asset) {
      if ($css_asset['type'] == 'inline') {
        $element = [
          '#type' => 'html_tag',
          '#tag' => 'style',
          '#value' => $this->getCssFileContents($css_asset['data']),
          '#attributes' => [
            'type' => 'text/css',
          ],
          '#browsers' => $css_asset['browsers'],
        ];
        $elements[] = $element;
      }
      else {
        $standard_css_assets[] = $css_asset;
      }
    }
    return array_merge(parent::render($standard_css_assets), $elements);
  }

  /**
   * Get CSS file contents.
   *
   * @param string $path
   */
  protected function getCssFileContents($path) {
    if (!file_exists($path)) {
      throw new \Exception('Invalid CSS asset path.');
    }
    ob_start();
    require $path;
    $contents = ob_get_contents();
    ob_end_clean();
    return $contents;
  }
}
