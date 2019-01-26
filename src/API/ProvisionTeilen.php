<?php
namespace Ujamii\OpenImmo\API;

use JMS\Serializer\Annotation\XmlAttribute;
use JMS\Serializer\Annotation\XmlRoot;

/**
 * Class ProvisionTeilen
 *
 * @package Ujamii\OpenImmo\API
 * @XmlRoot("provision_teilen") 
 */
class ProvisionTeilen {

	/**
	 */
	const WERT_ABSOLUT = 'absolut';

	/**
	 */
	const WERT_PROZENT = 'prozent';

	/**
	 */
	const WERT_TEXT = 'text';

	/**
	 * optional
	 *
	 * @XmlAttribute 
	 * @see WERT_* constants
	 * @var string
	 */
	protected $wert;

	/**
	 * @return string
	 */
	public function getWert(): string {
		return $this->wert;
	}

	/**
	 * @param string $wert Setter for wert
	 * @return ProvisionTeilen
	 */
	public function setWert(string $wert) {
		$this->wert = $wert;
		return $this;
	}
}
