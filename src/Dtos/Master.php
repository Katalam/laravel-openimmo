<?php

declare(strict_types=1);

namespace Katalam\OpenImmo\Dtos;

use JMS\Serializer\Annotation\Inline;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlAttribute;
use JMS\Serializer\Annotation\XmlRoot;

/**
 * Class Master
 * Frei wählbare alphanumerische Kennung um Objekte einem Übergeordneten Objekt zuzuordnen.
 * Das Eltern Objekte hat in "gruppen_kennung" die gleiche ID wie "master". Anwendung z.b. in Neubau Projekten.
 * Damit die Anzeige des Master Objektes gesteuert werden kann, wird im Master ein Flag
 *  visible eingesetzt. Das Attribut ist dann zwingend anzugeben
 *
 * @XmlRoot("master")
 */
class Master
{
    /**
     * @Type("bool")
     *
     * @XmlAttribute
     *
     * @SerializedName("visible")
     * required
     */
    protected bool $visible = false;

    /**
     * @Inline
     *
     * @Type("string")
     */
    protected ?string $value = null;

    public function __construct(bool $visible = false, ?string $value = null)
    {
        $this->visible = $visible;
        $this->value = $value;
    }

    public function getVisible(): bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): Master
    {
        $this->visible = $visible;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): Master
    {
        $this->value = $value;

        return $this;
    }
}
