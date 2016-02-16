<?php

namespace WikibaseMedia\DataModel;


use InvalidArgumentException;
use Wikibase\DataModel\Entity\EntityDocument;
use Wikibase\DataModel\Entity\EntityId;
use Wikibase\DataModel\Statement\StatementList;
use Wikibase\DataModel\Statement\StatementListHolder;
use Wikibase\DataModel\Term\DescriptionsProvider;
use Wikibase\DataModel\Term\LabelsProvider;
use Wikibase\DataModel\Term\TermList;

class MediaInfo implements EntityDocument, LabelsProvider, DescriptionsProvider, StatementListHolder {

	const ENTITY_TYPE = 'medium';

	/**
	 * @var MediaInfoId|null
	 */
	private $id;

	/**
	 * @var TermList
	 */
	private $labels;

	/**
	 * @var TermList
	 */
	private $descriptions;

	/**
	 * @var StatementList
	 */
	private $statements;

	/**
	 * @param MediaInfoId|null $id
	 * @param TermList|null $labels
	 * @param TermList|null $descriptions
	 * @param StatementList|null $statements
	 */
	public function __construct(
		MediaInfoId $id = null,
		TermList $labels = null,
		TermList $descriptions = null,
		StatementList $statements = null
	) {
		$this->id = $id;
		$this->labels = $labels ?: new TermList();
		$this->descriptions = $descriptions ?: new TermList();
		$this->statements = $statements ?: new StatementList();
	}

	/**
	 * @return string
	 */
	public function getType() {
		return self::ENTITY_TYPE;
	}

	/**
	 * @return EntityId|null
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param MediaInfoId $id
	 */
	public function setId( $id ) {
		if ( !( $id instanceof MediaInfoId ) ) {
			throw new InvalidArgumentException( '$id must be an instance of MediumId' );
		}

		$this->id = $id;
	}

	/**
	 * @return TermList
	 */
	public function getLabels() {
		return $this->labels;
	}

	/**
	 * @return TermList
	 */
	public function getDescriptions() {
		return $this->descriptions;
	}

	/**
	 * @return StatementList
	 */
	public function getStatements() {
		return $this->statements;
	}

	/**
	 * @param StatementList $statements
	 */
	public function setStatements( StatementList $statements ) {
		$this->statements = $statements;
	}

	/**
	 * @return bool
	 */
	public function isEmpty() {
		return $this->labels->isEmpty()
			&& $this->descriptions->isEmpty()
			&& $this->statements->isEmpty();
	}

	/**
	 * @see EntityDocument::equals
	 *
	 * @param mixed $target
	 *
	 * @return bool
	 */
	public function equals( $target ) {
		if ( $this === $target ) {
			return true;
		}

		return $target instanceof self
		       && $this->labels->equals( $target->labels )
		       && $this->descriptions->equals( $target->descriptions )
		       && $this->statements->equals( $target->statements );
	}

	/**
	 * @see EntityDocument::copy
	 *
	 * @return MediaInfo
	 */
	public function copy() {
		return unserialize( serialize( $this ) );
	}

}
