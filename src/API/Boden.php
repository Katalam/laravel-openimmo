<?php
namespace Ujamii\OpenImmo\API;

use JMS\Serializer\Annotation\XmlAttribute;
use JMS\Serializer\Annotation\XmlRoot;

/**
 * Class Boden
 *
 * @package Ujamii\OpenImmo\API
 * @XmlRoot("boden") 
 */
class Boden {

	/**
	 * optional
	 *
	 * @XmlAttribute 
	 * @var boolean
	 */
	protected $dielen;

	/**
	 * optional
	 *
	 * @XmlAttribute 
	 * @var boolean
	 */
	protected $doppelboden;

	/**
	 * optional
	 *
	 * @XmlAttribute 
	 * @var boolean
	 */
	protected $estrich;

	/**
	 * optional
	 *
	 * @XmlAttribute 
	 * @var boolean
	 */
	protected $fertigparkett;

	/**
	 * optional
	 *
	 * @XmlAttribute 
	 * @var boolean
	 */
	protected $fliesen;

	/**
	 * optional
	 *
	 * @XmlAttribute 
	 * @var boolean
	 */
	protected $granit;

	/**
	 * optional
	 *
	 * @XmlAttribute 
	 * @var boolean
	 */
	protected $kunststoff;

	/**
	 * optional
	 *
	 * @XmlAttribute 
	 * @var boolean
	 */
	protected $laminat;

	/**
	 * optional
	 *
	 * @XmlAttribute 
	 * @var boolean
	 */
	protected $linoleum;

	/**
	 * optional
	 *
	 * @XmlAttribute 
	 * @var boolean
	 */
	protected $marmor;

	/**
	 * optional
	 *
	 * @XmlAttribute 
	 * @var boolean
	 */
	protected $parkett;

	/**
	 * optional
	 *
	 * @XmlAttribute 
	 * @var boolean
	 */
	protected $stein;

	/**
	 * optional
	 *
	 * @XmlAttribute 
	 * @var boolean
	 */
	protected $teppich;

	/**
	 * optional
	 *
	 * @XmlAttribute 
	 * @var boolean
	 */
	protected $terrakotta;

	/**
	 * @return boolean
	 */
	public function getDielen(): bool {
		return $this->dielen;
	}

	/**
	 * @return boolean
	 */
	public function getDoppelboden(): bool {
		return $this->doppelboden;
	}

	/**
	 * @return boolean
	 */
	public function getEstrich(): bool {
		return $this->estrich;
	}

	/**
	 * @return boolean
	 */
	public function getFertigparkett(): bool {
		return $this->fertigparkett;
	}

	/**
	 * @return boolean
	 */
	public function getFliesen(): bool {
		return $this->fliesen;
	}

	/**
	 * @return boolean
	 */
	public function getGranit(): bool {
		return $this->granit;
	}

	/**
	 * @return boolean
	 */
	public function getKunststoff(): bool {
		return $this->kunststoff;
	}

	/**
	 * @return boolean
	 */
	public function getLaminat(): bool {
		return $this->laminat;
	}

	/**
	 * @return boolean
	 */
	public function getLinoleum(): bool {
		return $this->linoleum;
	}

	/**
	 * @return boolean
	 */
	public function getMarmor(): bool {
		return $this->marmor;
	}

	/**
	 * @return boolean
	 */
	public function getParkett(): bool {
		return $this->parkett;
	}

	/**
	 * @return boolean
	 */
	public function getStein(): bool {
		return $this->stein;
	}

	/**
	 * @return boolean
	 */
	public function getTeppich(): bool {
		return $this->teppich;
	}

	/**
	 * @return boolean
	 */
	public function getTerrakotta(): bool {
		return $this->terrakotta;
	}

	/**
	 * @param boolean $dielen Setter for dielen
	 * @return Boden
	 */
	public function setDielen(bool $dielen) {
		$this->dielen = $dielen;
		return $this;
	}

	/**
	 * @param boolean $doppelboden Setter for doppelboden
	 * @return Boden
	 */
	public function setDoppelboden(bool $doppelboden) {
		$this->doppelboden = $doppelboden;
		return $this;
	}

	/**
	 * @param boolean $estrich Setter for estrich
	 * @return Boden
	 */
	public function setEstrich(bool $estrich) {
		$this->estrich = $estrich;
		return $this;
	}

	/**
	 * @param boolean $fertigparkett Setter for fertigparkett
	 * @return Boden
	 */
	public function setFertigparkett(bool $fertigparkett) {
		$this->fertigparkett = $fertigparkett;
		return $this;
	}

	/**
	 * @param boolean $fliesen Setter for fliesen
	 * @return Boden
	 */
	public function setFliesen(bool $fliesen) {
		$this->fliesen = $fliesen;
		return $this;
	}

	/**
	 * @param boolean $granit Setter for granit
	 * @return Boden
	 */
	public function setGranit(bool $granit) {
		$this->granit = $granit;
		return $this;
	}

	/**
	 * @param boolean $kunststoff Setter for kunststoff
	 * @return Boden
	 */
	public function setKunststoff(bool $kunststoff) {
		$this->kunststoff = $kunststoff;
		return $this;
	}

	/**
	 * @param boolean $laminat Setter for laminat
	 * @return Boden
	 */
	public function setLaminat(bool $laminat) {
		$this->laminat = $laminat;
		return $this;
	}

	/**
	 * @param boolean $linoleum Setter for linoleum
	 * @return Boden
	 */
	public function setLinoleum(bool $linoleum) {
		$this->linoleum = $linoleum;
		return $this;
	}

	/**
	 * @param boolean $marmor Setter for marmor
	 * @return Boden
	 */
	public function setMarmor(bool $marmor) {
		$this->marmor = $marmor;
		return $this;
	}

	/**
	 * @param boolean $parkett Setter for parkett
	 * @return Boden
	 */
	public function setParkett(bool $parkett) {
		$this->parkett = $parkett;
		return $this;
	}

	/**
	 * @param boolean $stein Setter for stein
	 * @return Boden
	 */
	public function setStein(bool $stein) {
		$this->stein = $stein;
		return $this;
	}

	/**
	 * @param boolean $teppich Setter for teppich
	 * @return Boden
	 */
	public function setTeppich(bool $teppich) {
		$this->teppich = $teppich;
		return $this;
	}

	/**
	 * @param boolean $terrakotta Setter for terrakotta
	 * @return Boden
	 */
	public function setTerrakotta(bool $terrakotta) {
		$this->terrakotta = $terrakotta;
		return $this;
	}
}