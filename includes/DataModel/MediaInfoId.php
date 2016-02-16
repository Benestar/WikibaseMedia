<?php

namespace WikibaseMedia\DataModel;

use InvalidArgumentException;
use Wikibase\DataModel\Entity\EntityId;

/**
 * @licence GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class MediaInfoId extends EntityId {

	const PATTERN = '/^M[1-9]\d*$/i';

	/**
	 * @param string $idSerialization
	 *
	 * @throws InvalidArgumentException
	 */
	public function __construct( $idSerialization ) {
		$this->assertValidIdFormat( $idSerialization );
		$this->serialization = strtoupper( $idSerialization );
	}

	private function assertValidIdFormat( $idSerialization ) {
		if ( !is_string( $idSerialization ) ) {
			throw new InvalidArgumentException( '$idSerialization must be a string; got ' . gettype( $idSerialization ) );
		}

		if ( !preg_match( self::PATTERN, $idSerialization ) ) {
			throw new InvalidArgumentException( '$idSerialization must match ' . self::PATTERN );
		}
	}

	/**
	 * @see EntityId::getEntityType
	 *
	 * @return string
	 */
	public function getEntityType() {
		return 'medium';
	}

	/**
	 * @see Serializable::serialize
	 *
	 * @return string
	 */
	public function serialize() {
		return json_encode( array( 'item', $this->serialization ) );
	}

	/**
	 * @see Serializable::unserialize
	 *
	 * @param string $value
	 */
	public function unserialize( $value ) {
		list( , $this->serialization ) = json_decode( $value );
	}

}