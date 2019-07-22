<?php

declare(strict_types=1);

namespace Direction\Domain\Event;

use Direction\Domain\Entity\Direction;
use Jettyn\Core\Domain\DomainEvent;
use Jettyn\Core\ValueObject\Uuid;

final class DirectionCreated implements DomainEvent
{
    /** @var Uuid */
    private $DirectionId;

    /** @var string */
    private $portalOriginalOrderId;

    /** @var string */
    private $portalOrderId;

    /** @var \DateTimeImmutable */
    private $recordedAt;

    public function __construct(Uuid $DirectionId, string $portalOriginalOrderId, string $portalOrderId)
    {
        $this->DirectionId             = $DirectionId;
        $this->portalOriginalOrderId    = $portalOriginalOrderId;
        $this->portalOrderId            = $portalOrderId;
        $this->recordedAt               = new \DateTimeImmutable;
    }

    public static function from(Direction $Direction)
    {
        return new self(
            $Direction->getId(),
            $Direction->getPortalOriginalOrderId(),
            $Direction->getPortalOrderId()
        );
    }

    public function aggregateId(): string
    {
        return (string)$this->DirectionId;
    }

    /**
     * @return Uuid
     */
    public function getDirectionId(): Uuid
    {
        return $this->DirectionId;
    }

    /**
     * @return string
     */
    public function getPortalOriginalOrderId(): string
    {
        return $this->portalOriginalOrderId;
    }

    /**
     * @return Uuid
     */
    public function getPortalOrderId(): string
    {
        return $this->portalOrderId;
    }

    public function recordedAt(): \DateTimeImmutable
    {
        return $this->recordedAt;
    }

    public function serialize(): array
    {
        return [
            'Direction_id' => (string)$this->DirectionId,
            'portal_original_order_id' => $this->portalOriginalOrderId,
            'portal_order_id' => $this->portalOrderId
        ];
    }
}
