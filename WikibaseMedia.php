<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

if ( !defined( 'WB_VERSION' ) ) {
	die( 'WikibaseMedia requires Wikibase to be installed.' );
}

if ( defined( 'WIKIBASE_MEDIA_VERSION' ) ) {
	// Do not initialize more than once.
	return 1;
}

define( 'WIKIBASE_MEDIA_VERSION', '0.1 alpha' );

if ( is_readable( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

call_user_func( function() {
	global $wgExtensionCredits, $wgContentHandlers, $wgHooks;

	$wgExtensionCredits['wikibase-media'][] = array(
		'path' => __DIR__,
		'name' => 'Wikibase Media',
		'version' => WIKIBASE_MEDIA_VERSION,
		'author' => array(
			'[https://www.mediawiki.org/wiki/User:Bene* Bene*]',
		),
		'url' => 'https://www.mediawiki.org/wiki/Extension:Wikibase Media',
		'descriptionmsg' => 'wikibase-media-desc',
		'license-name' => 'GPL-2.0+'
	);

	define( 'CONTENT_MODEL_WIKIBASE_MEDIAINFO', 'wikibase-media' );

	$wgContentHandlers[CONTENT_MODEL_WIKIBASE_MEDIAINFO] = '\WikibaseMedia\MediumHandler::newFromGlobalState';

	$mediaInfoDefinition = array(
		'serializer-factory-callback' => function( \Wikibase\DataModel\SerializerFactory $serializerFactory ) {
			return new \WikibaseMedia\DataModel\Serialization\MediaInfoSerializer(
				$serializerFactory->newTermListSerializer(),
				$serializerFactory->newStatementListSerializer()
			);
		},
		'deserializer-factory-callback' => function( \Wikibase\DataModel\DeserializerFactory $deserializerFactory ) {
			return new \WikibaseMedia\DataModel\Serialization\MediaInfoDeserializer(
				$deserializerFactory->newTermListDeserializer(),
				$deserializerFactory->newStatementListDeserializer()
			);
		},
		'change-factory-callback' => function( array $fields ) {
			return new \Wikibase\EntityChange( $fields );
		}
	);

	$wgHooks['WikibaseRepoEntityTypes'][] = function( &$entityTypeDefinitions ) use ( $mediaInfoDefinition ) {
		$entityTypeDefinitions['mediainfo'] = array_merge(
			$mediaInfoDefinition,
			array(
				'content-model' => CONTENT_MODEL_WIKIBASE_MEDIAINFO
			)
		);
	};

	$wgHooks['WikibaseRepoEntityTypes'][] = function( &$entityTypeDefinitions ) use ( $mediaInfoDefinition ) {
		$entityTypeDefinitions['mediainfo'] = $mediaInfoDefinition;
	};

} );
