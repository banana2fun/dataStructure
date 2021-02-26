<?php

namespace Api\Http\FillableRequests\Cart\Models;

/**
 * Class BookingTourist
 * Информация о туристах для бронирования
 *
 * @package Api\Http\FillableRequests\Cart\Models
 */
class BookingTourist
{
    /** @var string */
    public $name;
    /** @var string */
    public $surname;
    /** @var string */
    public $middleName;
    /** @var string */
    public $email;
    /** @var string */
    public $gender;
    /** @var string */
    public $birthday;
    /** @var string */
    public $documentNumber;
    /** @var string */
    public $documentType;
    /** @var string */
    public $expirationDate;
    /** @var string */
    public $citizen;
    /** @var string */
    public $roomId;
    /** @var string */
    public $phone;
    /** @var string */
    public $id;
    /** @var string */
    public $visaId;
    /** @var string */
    public $variantId;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return BookingTourist
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     * @return BookingTourist
     */
    public function setSurname(string $surname): self
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    /**
     * @param string|null $middleName
     * @return BookingTourist
     */
    public function setMiddleName(?string $middleName): self
    {
        $this->middleName = $middleName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return BookingTourist
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     * @return BookingTourist
     */
    public function setGender(string $gender): self
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBirthday(): ?string
    {
        return $this->birthday;
    }

    /**
     * @param string|null $birthday
     * @return BookingTourist
     */
    public function setBirthday(?string $birthday): self
    {
        $this->birthday = $birthday;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDocumentNumber(): ?string
    {
        return $this->documentNumber;
    }

    /**
     * @param string|null $documentNumber
     * @return BookingTourist
     */
    public function setDocumentNumber(?string $documentNumber): self
    {
        $this->documentNumber = $documentNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getDocumentType(): string
    {
        return $this->documentType ?? '';
    }

    /**
     * @param string|null $documentType
     * @return BookingTourist
     */
    public function setDocumentType(?string $documentType): self
    {
        $this->documentType = $documentType;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getExpirationDate(): ?string
    {
        return $this->expirationDate;
    }

    /**
     * @param string|null $expirationDate
     * @return BookingTourist
     */
    public function setExpirationDate(?string $expirationDate): self
    {
        $this->expirationDate = $expirationDate;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCitizen(): ?string
    {
        return $this->citizen;
    }

    /**
     * @param string|null $citizen
     * @return BookingTourist
     */
    public function setCitizen(?string $citizen): self
    {
        $this->citizen = $citizen;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRoomId(): ?string
    {
        return $this->roomId;
    }

    /**
     * @param string|null $roomId
     * @return BookingTourist
     */
    public function setRoomId(?string $roomId): self
    {
        $this->roomId = $roomId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     * @return BookingTourist
     */
    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     * @return BookingTourist
     */
    public function setId(?string $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getVisaId(): ?string
    {
        return $this->visaId;
    }

    /**
     * @param string|null $visaId
     * @return BookingTourist
     */
    public function setVisaId(?string $visaId): self
    {
        $this->visaId = $visaId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getVariantId(): ?string
    {
        return $this->variantId;
    }

    /**
     * @param string|null $variantId
     * @return BookingTourist
     */
    public function setVariantId(?string $variantId): self
    {
        $this->variantId = $variantId;
        return $this;
    }
}