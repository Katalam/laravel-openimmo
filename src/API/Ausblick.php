<?php
namespace Ujamii\OpenImmo\API;

use JMS\Serializer\Annotation\XmlAttribute;
use JMS\Serializer\Annotation\XmlRoot;

/**
 * Class Ausblick
 *
 * @package Ujamii\OpenImmo\API
 * @XmlRoot("ausblick") 
 */
class Ausblick {

	/**
	 */
	const BLICK_BERGE = 'BERGE';

	/**
	 */
	const BLICK_FERNE = 'FERNE';

	/**
	 */
	const BLICK_MEER = 'MEER';

	/**
	 */
	const BLICK_SEE = 'SEE';

	/**
	 * optional
	 *
	 * @XmlAttribute 
	 * @see BLICK_* constants
	 * @var string
	 */
	protected $blick;

	/**
	 * @return string
	 */
	public function getBlick(): string {
		return $this->blick;
	}

	/**
	 * @param string $blick Setter for blick
	 * @return Ausblick
	 */
	public function setBlick(string $blick) {
		$this->blick = $blick;
		return $this;
	}
}
