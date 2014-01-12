<?php

namespace Perso\Tools\Classes;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Perso\Tools\Classes\ResizeImage;

abstract class Picture {

    /**
     * @var string
     *
     * @ORM\Column(name="picture", type="string", length=25)
     */
    public $picture;

    /**
     * @Assert\Image(
     *     minWidth = 200,
     *     minHeight = 200
     * )
     */
    public $file;
    public $temp;

    public function setTemp($temp) {
        $this->temp = $temp;
    }

    public function getTemp() {
        return $this->temp;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile() {
        return $this->file;
    }

    /**
     * Set picture
     *
     * @param string $picture
     * @return User
     */
    public function setPicture($picture) {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string 
     */
    public function getPicture() {
        return $this->picture;
    }

    /**
     * ********************   Partie upload picture   **************************
     */
    public function getAbsolutePath() {
        return null === $this->picture ? null : $this->getUploadRootDir() . '/' . $this->picture;
    }

    public function getWebPath() {
        return null === $this->picture ? null : $this->getUploadDir() . '/' . $this->picture;
    }

    public function getUploadRootDir() {
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    public function getUploadDir() {
        return 'uploads/profile';
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null) {
        $this->file = $file;
        // check if we have an old image path
        if (isset($this->picture)) {
            // store the old name to delete after the update
            $this->temp = $this->picture;
            $this->picture = null;
        } else {
            $this->picture = $this->getNewFilename();
        }
    }

    protected function preUpload() {
        if (null !== $this->getFile()) {
            $this->picture = $this->getNewFilename(10);
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    protected function upload() {
        if (null === $this->getFile()) {
            return;
        }

        $this->getFile()->move($this->getUploadRootDir(), $this->picture);

        $this->compression();

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            @unlink($this->getUploadRootDir() . '/' . $this->temp);
            // clear the temp image path
            $this->temp = null;
        }
        $this->file = null;
    }


    protected function removeUpload() {
        if ($file = $this->getAbsolutePath()) {
            @unlink($file);
        }
    }

    public function getNewFilename($nb = 8) {
        $str = 'abcdefghijklmnopqrstuvwcyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $Uid = uniqid(mt_rand(), true);

        return substr(str_shuffle($str . $Uid), 0, $nb) . $this->getExtension();
    }

    public function getExtension() {
        return '.' . $this->getFile()->getClientOriginalExtension();
    }

    public function compression() {
        $resizeObj = new ResizeImage($this->getAbsolutePath());
        // Redimensionement de l'image (options: exact, portrait, landscape, auto, crop)
        $resizeObj->resizeImage(900, 600, 'auto');
        // Sauvegarde de l'image
        $resizeObj->saveImage($this->getAbsolutePath(), 80);
    }

}
