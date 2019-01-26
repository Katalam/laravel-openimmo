<?php
namespace Ujamii\OpenImmo\API;

use JMS\Serializer\Annotation\XmlAttribute;
use JMS\Serializer\Annotation\XmlRoot;

/**
 * Class Nutzungsart
 *
 * @package Ujamii\OpenImmo\API
 * @XmlRoot("nutzungsart") 
 */
class Nutzungsart {

	/**
	 * optional
	 *
	 * @XmlAttribute 
	 * @var boolean
	 */
	protected $anlage;

	/**
	 * required
	 *
	 * @XmlAttribute 
	 * @var boolean
	 */
	protected $gewerbe;

	/**
	 * optional
	 *
	 * @XmlAttribute 
	 * @var boolean
	 */
	protected $waz;

	/**
	 * required
	 *
	 * @XmlAttribute 
	 * @var boolean
	 */
	protected $wohnen;

	/**
	 * @return boolean
	 */
	public function getAnlage(): bool {
		return $this->anlage;
	}

	/**
	 * @return boolean
	 */
	public function getGewerbe(): bool {
		return $this->gewerbe;
	}

	/**
	 * @return boolean
	 */
	public function getWaz(): bool {
		return $this->waz;
	}

	/**
	 * @return boolean
	 */
	public function getWohnen(): bool {
		return $this->wohnen;
	}

	/**
	 * @param boolean $anlage Setter for anlage
	 * @return Nutzungsart
	 */
	public function setAnlage(bool $anlage) {
		$this->anlage = $anlage;
		return $this;
	}

	/**
	 * @param boolean $gewerbe Setter for gewerbe
	 * @return Nutzungsart
	 */
	public function setGewerbe(bool $gewerbe) {
		$this->gewerbe = $gewerbe;
		return $this;
	}

	/**
	 * @param boolean $waz Setter for waz
	 * @return Nutzungsart
	 */
	public function setWaz(bool $waz) {
		$this->waz = $waz;
		return $this;
	}

	/**
	 * @param boolean $wohnen Setter for wohnen
	 * @return Nutzungsart
	 */
	public function setWohnen(bool $wohnen) {
		$this->wohnen = $wohnen;
		return $this;
	}
}
