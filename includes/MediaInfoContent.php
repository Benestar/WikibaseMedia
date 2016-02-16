<?php

namespace WikibaseMedia;

use InvalidArgumentException;
use MWException;
use Wikibase\Content\EntityHolder;
use Wikibase\DataModel\Entity\Entity;
use Wikibase\EntityContent;
use WikibaseMedia\DataModel\MediaInfo;

/**
 * @licence GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class MediaInfoContent extends EntityContent {

	/**
	 * @var EntityHolder
	 */
	private $mediumHolder;

	/**
	 * Do not use to construct new stuff from outside of this class,
	 * use the static newFoobar methods.
	 *
	 * In other words: treat as protected (which it was, but now
	 * cannot be since we derive from Content).
	 *
	 * @protected
	 *
	 * @param EntityHolder $mediumHolder
	 * @throws InvalidArgumentException
	 */
	public function __construct( EntityHolder $mediumHolder ) {
		parent::__construct( CONTENT_MODEL_WIKIBASE_MEDIAINFO );

		if ( $mediumHolder->getEntityType() !== MediaInfo::ENTITY_TYPE ) {
			throw new InvalidArgumentException( '$mediumHolder must contain a Medium entity!' );
		}

		$this->mediumHolder = $mediumHolder;
	}

	/**
	 * @return MediaInfo
	 */
	public function getMedium() {
		return $this->mediumHolder->getEntity( 'WikibaseMedia\DataModel\Medium' );
	}

	/**
	 * @return MediaInfo
	 */
	public function getEntity() {
		return $this->getMedium();
	}

	/**
	 * @return EntityHolder
	 */
	protected function getEntityHolder() {
		return $this->mediumHolder;
	}

	/**
	 * @return bool
	 */
	public function isStub() {
		return !$this->isRedirect()
		       && !$this->getMedium()->isEmpty()
		       && $this->getMedium()->getStatements()->isEmpty();
	}

	/**
	 * @param bool|null $hasLinks
	 *
	 * @return bool
	 */
	public function isCountable( $hasLinks = null ) {
		return !$this->isRedirect() && !$this->getMedium()->isEmpty();
	}

}
