<?php

/*
 * This file is part of the MultiShip package.
 *
 * (c) 2013 Fraser Reed
 *      <fraser.reed@gmail.com>
 *      github.com/fraserreed
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace MultiShip\Label;


/**
 * MultiShip shipment label object
 *
 * @author fraserreed
 */
class ShipmentLabel
{
    /**
     * @var string
     */
    protected $imageFormat;

    /**
     * @var string
     */
    protected $imageDescription;

    /**
     * @var string
     */
    protected $graphicImage;

    /**
     * @var string
     */
    protected $htmlImage;

    /**
     * @var string
     */
    protected $pdfImage;

    /**
     * @param string $imageFormat
     */
    public function setImageFormat( $imageFormat )
    {
        $this->imageFormat = $imageFormat;
    }

    /**
     * @return string
     */
    public function getImageFormat()
    {
        return $this->imageFormat;
    }

    /**
     * @param string $imageDescription
     */
    public function setImageDescription( $imageDescription )
    {
        $this->imageDescription = $imageDescription;
    }

    /**
     * @return string
     */
    public function getImageDescription()
    {
        return $this->imageDescription;
    }

    /**
     * @param string $graphicImage
     */
    public function setGraphicImage( $graphicImage )
    {
        $this->graphicImage = $graphicImage;
    }

    /**
     * @return string
     */
    public function getGraphicImage()
    {
        return $this->graphicImage;
    }

    /**
     * @param string $htmlImage
     */
    public function setHtmlImage( $htmlImage )
    {
        $this->htmlImage = $htmlImage;
    }

    /**
     * @return string
     */
    public function getHtmlImage()
    {
        return $this->htmlImage;
    }

    /**
     * @param string $pdfImage
     */
    public function setPdfImage( $pdfImage )
    {
        $this->pdfImage = $pdfImage;
    }

    /**
     * @return string
     */
    public function getPdfImage()
    {
        return $this->pdfImage;
    }
}

?>