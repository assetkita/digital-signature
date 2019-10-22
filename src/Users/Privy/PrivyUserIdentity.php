<?php

namespace Assetku\DigitalSignature\Users\Privy;

class PrivyUserIdentity
{
    /**
     * @var string
     */
    protected $nama;

    /**
     * @var string
     */
    protected $nik;

    /**
     * @var string
     */
    protected $tanggalLahir;

    /**
     * @var string
     */
    protected $tempatLahir;

    /**
     * PrivyUserIdentity constructor.
     *
     * @param $privyUserIdentity
     */
    public function __construct($privyUserIdentity)
    {
        $this->nama = $privyUserIdentity->nama;
        $this->nik = $privyUserIdentity->nik;
        $this->tanggalLahir = $privyUserIdentity->tanggalLahir;
        $this->tempatLahir = $privyUserIdentity->tempatLahir;
    }

    /**
     * Get the digital signature user's identity nama
     *
     * @return string
     */
    public function getNama()
    {
        return $this->nama;
    }

    /**
     * Get the digital signature user's identity nik
     *
     * @return string
     */
    public function getNik()
    {
        return $this->nik;
    }

    /**
     * Get the digital signature user's identity tanggal lahir
     *
     * @return string
     */
    public function getTanggalLahir()
    {
        return $this->tanggalLahir;
    }

    /**
     * Get the digital signature user's tempat lahir
     *
     * @return string
     */
    public function getTempatLahir()
    {
        return $this->tempatLahir;
    }
}
