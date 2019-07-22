<?php

namespace Direction\Application\View;

/**
 * GoogleDirectionRouteLegStepTransitDetailsView
 * @author Renato Teixeira Bueno <renatotbueno@gmail.com>
 */
class GoogleDirectionVechicleView
{
    private $name;
    private $type;
    private $icon;
    private $localIcon;

    public function __construct(
        $name,
        $type,
        $icon,
        $localIcon
    )
    {
        $this->name = $name;
        $this->type = $type;
        $this->icon = $icon;
        $this->localIcon = $localIcon;
    }

    public static function fromApiResponse($vehicle)
    {
        return new static(
            isset($vehicle['name']) ? $vehicle['name'] : null,
            isset($vehicle['type']) ? $vehicle['type'] : null,
            isset($vehicle['icon']) ? $vehicle['icon'] : null,
            isset($vehicle['local_icon']) ? $vehicle['local_icon'] : null
        );
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'type' => $this->type,
            'icon' => $this->icon,
            'local_icon' => $this->localIcon
        ];
    }
}