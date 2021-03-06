<?php

namespace WikibaseMedia\DataModel\Serialization;

use Deserializers\Deserializer;
use Deserializers\DispatchableDeserializer;
use Deserializers\Exceptions\DeserializationException;
use Deserializers\TypedObjectDeserializer;
use Wikibase\DataModel\Statement\StatementList;
use Wikibase\DataModel\Term\TermList;
use WikibaseMedia\DataModel\MediaInfo;
use WikibaseMedia\DataModel\MediaInfoId;

/**
 * @licence GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class MediaInfoDeserializer extends TypedObjectDeserializer {

	/**
	 * @var Deserializer
	 */
	private $termListDeserializer;

	/**
	 * @var Deserializer
	 */
	private $statementListDeserializer;

	/**
	 * MediaInfoDeserializer constructor.
	 * @param Deserializer $termListDeserializer
	 * @param Deserializer $statementListDeserializer
	 */
	public function __construct( Deserializer $termListDeserializer, Deserializer $statementListDeserializer ) {
		parent::__construct( 'mediainfo', 'type' );

		$this->termListDeserializer = $termListDeserializer;
		$this->statementListDeserializer = $statementListDeserializer;
	}

	/**
	 * @since 1.0
	 *
	 * @param mixed $serialization
	 *
	 * @throws DeserializationException
	 * @return MediaInfo
	 */
	public function deserialize( $serialization ) {
		$this->assertCanDeserialize( $serialization );

		return new MediaInfo(
			$this->deserializeId( $serialization ),
			$this->deserializeLabels( $serialization ),
			$this->deserializeDescriptions( $serialization ),
			$this->deserializeStatements( $serialization )
		);
	}

	/**
	 * @param array $serialization
	 *
	 * @return MediaInfoId|null
	 */
	private function deserializeId( array $serialization ) {
		if ( array_key_exists( 'id', $serialization ) ) {
			return new MediaInfoId( $serialization['id'] );
		}

		return null;
	}

	/**
	 * @param array $serialization
	 *
	 * @return TermList|null
	 */
	private function deserializeLabels( array $serialization ) {
		if ( array_key_exists( 'labels', $serialization ) ) {
			return $this->termListDeserializer->deserialize( $serialization['labels'] );
		}

		return null;
	}

	/**
	 * @param array $serialization
	 *
	 * @return TermList|null
	 */
	private function deserializeDescriptions( array $serialization ) {
		if ( array_key_exists( 'descriptions', $serialization ) ) {
			return $this->termListDeserializer->deserialize( $serialization['descriptions'] );
		}

		return null;
	}

	/**
	 * @param array $serialization
	 *
	 * @return StatementList|null
	 */
	private function deserializeStatements( array $serialization ) {
		if ( array_key_exists( 'statements', $serialization ) ) {
			return $this->statementListDeserializer->deserialize( $serialization['statements'] );
		}

		return null;
	}

}