<?php
/**
 * Class Canonical_Sanitizer.
 *
 * @package   Google\Web_Stories
 * @copyright 2020 Google LLC
 * @license   https://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @link      https://github.com/googleforcreators/web-stories-wp
 */

/**
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Web_Stories\AMP;

use DOMNodeList;
use Google\Web_Stories_Dependencies\AMP_Base_Sanitizer;
use Google\Web_Stories_Dependencies\AmpProject\Html\Attribute;
use Google\Web_Stories_Dependencies\AmpProject\Html\Tag;
use DOMElement;

/**
 * Canonical sanitizer class.
 *
 * Ensures link[rel=canonical] exists on the page,
 * as some plugins might have removed it in the meantime
 * or the user might be viewing a draft.
 *
 * Only needed when the AMP plugin is not active, as the plugin
 * handles that already.
 *
 * @see \AMP_Theme_Support::ensure_required_markup()
 * @link https://github.com/googleforcreators/web-stories-wp/issues/4193
 * @link https://github.com/googleforcreators/web-stories-wp/pull/8169
 *
 * @since 1.1.0
 */
class Canonical_Sanitizer extends AMP_Base_Sanitizer {
	/**
	 * Sanitize the HTML contained in the DOMDocument received by the constructor.
	 *
	 * @since 1.1.0
	 *
	 * @return void
	 */
	public function sanitize() {
		$canonical_url = $this->args['canonical_url'];

		$query = $this->dom->xpath->query( '//link[@rel="canonical"]', $this->dom->head );

		// Remove any duplicate items first.
		if ( $query instanceof DOMNodeList && $query->length > 1 ) {
			for ( $i = 1; $i < $query->length; $i++ ) {
				$node = $query->item( $i );
				if ( $node ) {
					$this->dom->head->removeChild( $node );
				}
			}
		}

		/**
		 * DOMElement
		 *
		 * @var DOMElement $rel_canonical
		 */
		$rel_canonical = $query instanceof DOMNodeList ? $query->item( 0 ) : null;

		if ( ! $rel_canonical instanceof DOMElement ) {
			$rel_canonical = $this->dom->createElement( Tag::LINK );

			if ( $rel_canonical instanceof DOMElement ) {
				$rel_canonical->setAttribute( Attribute::REL, Attribute::REL_CANONICAL );
				$this->dom->head->appendChild( $rel_canonical );
			}
		}

		// Ensure link[rel=canonical] has a non-empty href attribute.
		if ( empty( $rel_canonical->getAttribute( Attribute::HREF ) ) ) {
			$rel_canonical->setAttribute( Attribute::HREF, (string) $canonical_url );
		}
	}
}
