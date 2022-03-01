<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdvertismentRepository")
 */
class Advertisment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $seuil_hum_high;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $seuil_hum_low;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $seuil_light_high;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $seuil_light_low;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $seuil_rain_high;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $seuil_rain_low;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $seuil_temp_high;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $seuil_temp_low;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $video_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $time;

    /**
     * @ORM\Column(type="integer")u
     */
    private $user_id;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $display_time;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeuilHumHigh(): ?int
    {
        return $this->seuil_hum_high;
    }

    public function setSeuilHumHigh(?int $seuil_hum_high): self
    {
        $this->seuil_hum_high = $seuil_hum_high;

        return $this;
    }

    public function getSeuilHumLow(): ?int
    {
        return $this->seuil_hum_low;
    }

    public function setSeuilHumLow(?int $seuil_hum_low): self
    {
        $this->seuil_hum_low = $seuil_hum_low;

        return $this;
    }

    public function getSeuilLightHigh(): ?int
    {
        return $this->seuil_light_high;
    }

    public function setSeuilLightHigh(?int $seuil_light_high): self
    {
        $this->seuil_light_high = $seuil_light_high;

        return $this;
    }

    public function getSeuilLightLow(): ?int
    {
        return $this->seuil_light_low;
    }

    public function setSeuilLightLow(?int $seuil_light_low): self
    {
        $this->seuil_light_low = $seuil_light_low;

        return $this;
    }

    public function getSeuilRainHigh(): ?int
    {
        return $this->seuil_rain_high;
    }

    public function setSeuilRainHigh(?int $seuil_rain_high): self
    {
        $this->seuil_rain_high = $seuil_rain_high;

        return $this;
    }

    public function getSeuilRainLow(): ?int
    {
        return $this->seuil_rain_low;
    }

    public function setSeuilRainLow(?int $seuil_rain_low): self
    {
        $this->seuil_rain_low = $seuil_rain_low;

        return $this;
    }

    public function getSeuilTempHigh(): ?int
    {
        return $this->seuil_temp_high;
    }

    public function setSeuilTempHigh(?int $seuil_temp_high): self
    {
        $this->seuil_temp_high = $seuil_temp_high;

        return $this;
    }

    public function getSeuilTempLow(): ?int
    {
        return $this->seuil_temp_low;
    }

    public function setSeuilTempLow(?int $seuil_temp_low): self
    {
        $this->seuil_temp_low = $seuil_temp_low;

        return $this;
    }

    public function getVideoId(): ?string
    {
        return $this->video_id;
    }

    public function setVideoId(string $video_id): self
    {
        $this->video_id = $video_id;

        return $this;
    }

    public function getTime(): ?int
    {
        return $this->time;
    }

    public function setTime(int $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getDisplayTime(): ?\DateTimeInterface
    {
        return $this->display_time;
    }

    public function setDisplayTime(?\DateTimeInterface $display_time): self
    {
        $this->display_time = $display_time;

        return $this;
    }
}
