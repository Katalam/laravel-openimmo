<?php
namespace Ujamii\OpenImmo\API;

use JMS\Serializer\Annotation\XmlAttribute;
use JMS\Serializer\Annotation\XmlRoot;

/**
 * Class Stellplatzart
 *
 * @package Ujamii\OpenImmo\API
 * @XmlRoot("stellplatzart") 
 */
class Stellplatzart {

	/**
	 * optional
	 *
	 * @XmlAttribute 
	 * @var boolean
	 */
	protected $carport;

	/**
	 * optional
	 *
	 * @XmlAttribute 
	 * @var boolean
	 */
	protected $duplex;

	/**
	 * optional
	 *
	 * @XmlAttribute 
	 * @var boolean
	 */
	protected $freiplatz;

	/**
	 * optional
	 *
	 * @XmlAttribute 
	 * @var boolean
	 */
	protected $garage;

	/**
	 * optional
	 *
	 * @XmlAttribute 
	 * @var boolean
	 */
	protected $parkhaus;

	/**
	 * optional
	 *
	 * @XmlAttribute 
	 * @var boolean
	 */
	protected $tiefgarage;

	/**
	 * @return boolean
	 */
	public function getCarport(): bool {
		return $this->carport;
	}

	/**
	 * @return boolean
	 */
	public function getDuplex(): bool {
		return $this->duplex;
	}

	/**
	 * @return boolean
	 */
	public function getFreiplatz(): bool {
		return $this->freiplatz;
	}

	/**
	 * @return boolean
	 */
	public function getGarage(): bool {
		return $this->garage;
	}

	/**
	 * @return boolean
	 */
	public function getParkhaus(): bool {
		return $this->parkhaus;
	}

	/**
	 * @return boolean
	 */
	public function getTiefgarage(): bool {
		return $this->tiefgarage;
	}

	/**
	 * @param boolean $carport Setter for carport
	 * @return Stellplatzart
	 */
	public function setCarport(bool $carport) {
		$this->carport = $carport;
		return $this;
	}

	/**
	 * @param boolean $duplex Setter for duplex
	 * @return Stellplatzart
	 */
	public function setDuplex(bool $duplex) {
		$this->duplex = $duplex;
		return $this;
	}

	/**
	 * @param boolean $freiplatz Setter for freiplatz
	 * @return Stellplatzart
	 */
	public function setFreiplatz(bool $freiplatz) {
		$this->freiplatz = $freiplatz;
		return $this;
	}

	/**
	 * @param boolean $garage Setter for garage
	 * @return Stellplatzart
	 */
	public function setGarage(bool $garage) {
		$this->garage = $garage;
		return $this;
	}

	/**
	 * @param boolean $parkhaus Setter for parkhaus
	 * @return Stellplatzart
	 */
	public function setParkhaus(bool $parkhaus) {
		$this->parkhaus = $parkhaus;
		return $this;
	}

	/**
	 * @param boolean $tiefgarage Setter for tiefgarage
	 * @return Stellplatzart
	 */
	public function setTiefgarage(bool $tiefgarage) {
		$this->tiefgarage = $tiefgarage;
		return $this;
	}
}