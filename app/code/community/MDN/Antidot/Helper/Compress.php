<?php

/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @copyright  Copyright (c) 2009 Maison du Logiciel (http://www.maisondulogiciel.com)
 * @author : Olivier ZIMMERMANN
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class MDN_Antidot_Helper_Compress extends Mage_Core_Helper_Abstract {
    
    /**
     * Compress files
     * 
     * @param array|string $files
     * @param string $zipFile
     * @return boolean
     */
    public function zip($files, $zipFile) 
    {
        $files = (array)$files;
        try {
            if(class_exists('ZipArchive')) {
                $zip = new ZipArchive();
                if(!$zip->open($zipFile, ZipArchive::CREATE)) {
                    throw new Exception("cannot open ".$zipFile." for writing");
                }

                foreach($files as $file) {
                    $zip->addFile($file, basename($file));
                }
                $zip->close($zip);
            }
        } catch (Exception $e) {
            $files = array_map('basename', $files);
            exec('cd /tmp && zip '.$zipFile.' '.implode(' ', $files));
        }
        
        if(!file_exists($zipFile)) {
            throw new Exception('Could not zip the file');
        }
    }
}