<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ImageRenderer
 *
 * @author Christophe
 */
class ImageRenderer
{
    private $sourceFile;
    private $destFile;
    
    public function __construct($source, $dest)
    {
        $this->sourceFile = $source;
        $this->destFile = $dest;
    }
    
    public function doThumb()
    {
        $dest_x = 0; // On colle l'image sur l'autre a 0 en abscisse
        $dest_y = 0; // On colle l'image sur l'autre a 0 en ordonnee
        $src_departx = 0; // on part de 50 en largeur
        $src_departy = 0; // on part de 20 en hauteur
        $src_largeur = 280; // on copie de 50 en largeur
        $src_hauteur = 280; // on copie de 20 en hauteur

        // ------

        $destination = imagecreatetruecolor($src_largeur,$src_hauteur);// on creer une image de la taille du cadre à copier
        $source = imagecreatefromjpeg($this->sourceFile); // celle qui sera copiée

        imagecopy($destination, $source, $dest_x, $dest_y, $src_departx, $src_departy, $src_largeur, $src_hauteur);

        imagepng($destination, $this->destFile);
        
        
    }
}
