<?php

namespace WikibaseMedia;

use InvalidArgumentException;
use Wikibase\DataModel\Entity\Entity;
use Wikibase\DataModel\Entity\EntityId;
use Wikibase\DataModel\Entity\EntityIdParser;
use Wikibase\Lib\Store\EntityContentDataCodec;
use Wikibase\Repo\Content\EntityHandler;
use Wikibase\Repo\Store\EntityPerPage;
use Wikibase\Repo\Validators\EntityConstraintProvider;
use Wikibase\Repo\Validators\ValidatorErrorLocalizer;
use Wikibase\Repo\WikibaseRepo;
use Wikibase\TermIndex;
use WikibaseMedia\DataModel\MediaInfo;
use WikibaseMedia\DataModel\MediaInfoId;

/**
 * @licence GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class MediaInfoHandler extends EntityHandler {

	public static function newFromGlobalState() {
		$wikibaseRepo = WikibaseRepo::getDefaultInstance();

		return new self(
			$entityPerPage = $wikibaseRepo->getStore()->newEntityPerPage(),
			$termIndex = $wikibaseRepo->getStore()->getTermIndex(),
			$codec = $wikibaseRepo->getEntityContentDataCodec(),
			$constraintProvider = $wikibaseRepo->getEntityConstraintProvider(),
			$errorLocalizer = $wikibaseRepo->getValidatorErrorLocalizer(),
			$wikibaseRepo->getEntityIdParser()
			// $legacyFormatDetector = $wikibaseRepo->getLegacyFormatDetectorCallback()
		);
	}

	/**
	 * @param EntityPerPage $entityPerPage
	 * @param TermIndex $termIndex
	 * @param EntityContentDataCodec $contentCodec
	 * @param EntityConstraintProvider $constraintProvider
	 * @param ValidatorErrorLocalizer $errorLocalizer
	 * @param EntityIdParser $entityIdParser
	 * @param callable|null $legacyExportFormatDetector
	 */
	public function __construct(
		EntityPerPage $entityPerPage,
		TermIndex $termIndex,
		EntityContentDataCodec $contentCodec,
		EntityConstraintProvider $constraintProvider,
		ValidatorErrorLocalizer $errorLocalizer,
		EntityIdParser $entityIdParser,
		$legacyExportFormatDetector = null
	) {
		parent::__construct(
			CONTENT_MODEL_WIKIBASE_MEDIAINFO,
			$entityPerPage,
			$termIndex,
			$contentCodec,
			$constraintProvider,
			$errorLocalizer,
			$entityIdParser,
			$legacyExportFormatDetector
		);
	}

	/**
	 * @return string
	 */
	protected function getContentClass() {
		return '\WikibaseMedia\MediumContent';
	}

	/**
	 * @return MediaInfo
	 */
	public function makeEmptyEntity() {
		return new MediaInfo();
	}

	/**
	 * @return MediaInfoId
	 */
	public function makeEntityId( $id ) {
		return new MediaInfoId( $id );
	}

	/**
	 * @return string
	 */
	public function getEntityType() {
		return MediaInfo::ENTITY_TYPE;
	}

}