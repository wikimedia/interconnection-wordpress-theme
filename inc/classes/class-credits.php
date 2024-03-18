<?php
/**
 * Class to capture and store requested images during page load.
 *
 * Source: Reaktiv
 *
 * @package Interconnection
 */

namespace Interconnection;

/**
 * Class for handling images to show credit after page load..
 */
class Credits {
	/**
	 * Requested image IDs.
	 *
	 * @var array
	 */
	public $image_ids = array();

	/**
	 * Holds image matches from preg_match_all().
	 *
	 * @var array
	 */
	public $image_matches = array();

	/**
	 * Post, post, or other request ID.
	 *
	 * Used to build cache.
	 *
	 * @var int
	 */
	public $request_id = 0;

	/**
	 * Indicates to pause the capture of image_ids.
	 *
	 * @var bool
	 */
	public $pause = false;

	/**
	 * The instance of this object.
	 *
	 * @var Credits
	 */
	protected static $instance;

	/**
	 * Gets the instance of this object.
	 *
	 * @param int $request_id The ID for the request.
	 *
	 * @return Credits
	 */
	public static function get_instance( $request_id = 0 ) {
		if ( empty( static::$instance ) ) {
			static::$instance = new static( $request_id );
		}

		return static::$instance;
	}

	/**
	 * Credits constructor.
	 *
	 * @param int $request_id The ID for the request.
	 */
	public function __construct( $request_id ) {
		$this->request_id = $request_id;
		$this->image_ids  = $this->get_cache();

		if ( false === $this->image_ids ) {
			$this->image_ids = array();

			add_filter( 'the_content', array( $this, 'set_images_from_content' ), 10, 2 );
			add_filter( 'wp_get_attachment_image_src', array( $this, 'set_id_from_att_src' ), 10, 4 );
		}
	}

	/**
	 * Retrieve the image credit metadata for a specific attachment.
	 *
	 * @param int $image_id Attachment ID.
	 * @return array Associative array of [ author, license, license_url, url ] credit data.
	 */
	public static function get_image_credits( $image_id ) : array {
		$credit_info  = get_post_meta( $image_id, 'credit_info', true );
		$author       = ! empty( $credit_info['author'] ) ? $credit_info['author'] : '';
		$license      = ! empty( $credit_info['license'] ) ? $credit_info['license'] : '';
		$url          = ! empty( $credit_info['url'] ) ? $credit_info['url'] : '';

		if ( is_int( stripos( $license, 'Public domain' ) ) ) {
			$license_url = 'https://en.wikipedia.org/wiki/Public_domain';
		} elseif ( is_int( stripos( $license, 'GFDL' ) ) && is_int( stripos( $license, '1.2' ) ) ) {
			$license_url = 'https://commons.wikimedia.org/wiki/Commons:GNU_Free_Documentation_License,_version_1.2';
		} elseif ( is_int( stripos( $license, 'CC0' ) ) ) {
			$license_url = 'https://creativecommons.org/publicdomain/zero/1.0/';
		} elseif ( is_int( stripos( $license, 'CC' ) ) && is_int( stripos( $license, 'BY' ) ) && is_int( stripos( $license, 'SA' ) ) && is_int( stripos( $license, '4.0' ) ) ) {
			$license_url = 'https://creativecommons.org/licenses/by-sa/4.0/';
		} elseif ( is_int( stripos( $license, 'CC' ) ) && is_int( stripos( $license, 'BY' ) ) && is_int( stripos( $license, 'SA' ) ) & is_int( stripos( $license, '3.0' ) ) ) {
			$license_url = 'https://creativecommons.org/licenses/by-sa/3.0/';
		} elseif ( is_int( stripos( $license, 'CC' ) ) && is_int( stripos( $license, 'BY' ) ) && is_int( stripos( $license, 'SA' ) ) & is_int( stripos( $license, '2.0' ) ) ) {
			$license_url = 'https://creativecommons.org/licenses/by-sa/2.0/';
		} elseif ( is_int( stripos( $license, 'CC' ) ) && is_int( stripos( $license, 'BY' ) ) && ! is_int( stripos( $license, 'SA' ) ) && is_int( stripos( $license, '4.0' ) ) ) {
			$license_url = 'https://creativecommons.org/licenses/by/4.0/';
		} elseif ( is_int( stripos( $license, 'CC' ) ) && is_int( stripos( $license, 'BY' ) ) && ! is_int( stripos( $license, 'SA' ) ) && is_int( stripos( $license, '3.0' ) ) ) {
			$license_url = 'https://creativecommons.org/licenses/by/3.0/';
		} elseif ( is_int( stripos( $license, 'CC' ) ) && is_int( stripos( $license, 'BY' ) ) && ! is_int( stripos( $license, 'SA' ) ) && is_int( stripos( $license, '2.5' ) ) ) {
			$license_url = 'https://creativecommons.org/licenses/by/2.5/';
		} elseif ( is_int( stripos( $license, 'CC' ) ) && is_int( stripos( $license, 'BY' ) ) && ! is_int( stripos( $license, 'SA' ) ) && is_int( stripos( $license, '2.0' ) ) ) {
			$license_url = 'https://creativecommons.org/licenses/by/2.0/';
		} else {
			$license_url = ! empty( $credit_info['license_url'] ) ? $credit_info['license_url'] : '';
		}

		return [
			'author'      => $author,
			'license'     => $license,
			'license_url' => $license_url,
			'url'         => $url,
		];
	}

	/**
	 * Pauses capture of the image_ids.
	 */
	public function pause() {
		$this->pause = true;
	}

	/**
	 * Resumes capture of the image_ids.
	 */
	public function resume() {
		$this->pause = false;
	}

	/**
	 * Gets the cache.
	 *
	 * @return bool|mixed
	 */
	public function get_cache() {
		$cache_key = md5( sprintf( 'wmf_image_credits_%s', $this->request_id ) );

		return wp_cache_get( $cache_key );
	}

	/**
	 * Adds the requested image ID to the list of IDs if not previously set.
	 *
	 * @param bool $bool     Override bool value used to replace downsize logic.
	 * @param int  $image_id The image ID.
	 *
	 * @return mixed
	 */
	public function set_id( $bool, $image_id ) {
		if ( true !== $this->pause && ! in_array( $image_id, $this->image_ids, true ) ) {
			$this->image_ids[] = $image_id;
		}

		return $bool;
	}

	public function set_id_from_att_src( $image, $attachment_id, $size, $icon ) {
		if ( true !== $this->pause && ! in_array( $attachment_id, $this->image_ids, true ) ) {
			$this->image_ids[] = $attachment_id;
		}
		return $image;
	}

	/**
	 * Does a preg_match_all to get image sources if there is no caption.
	 *
	 * @param string $content The content.
	 *
	 * @return string
	 */
	public function set_images_from_content( $content ) {
		preg_match_all( '/src="([^" >]+?)"(?!.*?\[\/caption\])/', $content, $this->image_matches );

		$this->process_image_matches();

		return $content;
	}

	/**
	 * Processes the matched images to get image IDs for credits.
	 */
	public function process_image_matches() {
		$urls = isset( $this->image_matches[1] ) ? $this->image_matches[1] : '';

		if ( empty( $urls ) || ! is_array( $urls ) ) {
			return;
		}

		foreach ( $urls as $url ) {
			$image_id = wpcom_vip_attachment_url_to_postid( $url );

			// It might be a thumbnail size ( suffix '-dddxddd' )
			if ( empty( $image_id ) ) {
				$url_substr = strtok($url, '?'); // remove anything after ? in url
				$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $url_substr );
				$image_id = wpcom_vip_attachment_url_to_postid( $attachment_url );
			}

			if ( empty( $image_id ) ) {
				continue;
			}

			$this->set_id( true, $image_id );
		}
	}

	/**
	 * Gets the image IDs.
	 *
	 * @return array
	 */
	public function get_ids() {
		return $this->image_ids;
	}
}
