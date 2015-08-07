<?php
/**
 * Created by Rem.
 * Author: Dmitry Kushneriv
 * Email: remkwadriga@yandex.ua
 * Date: 06-08-2015
 * Time: 09:27 AM
 */

namespace interfaces;


interface AssetManagerInterface
{
    /**
     * addCss
     * @param string $css
     */
    public function addCss($css);

    /**
     * addJs
     * @param string $js
     */
    public function addJs($js);

    /**
     * addFont
     * @param string $font
     */
    public function addFont($font);

    /**
     * displayScc
     * @param string $collection
     */
    public function displayScc($collection = null);

    /**
     * displayJs
     * @param string $collection
     */
    public function displayJs($collection = null);

    /**
     * displayFonts
     * @param string $collection
     */
    public function displayFonts($collection = null);

    /**
     * displayFonts
     * @param string $collection
     */
    public function displayScripts($collection = null);

    /**
     * getCollection
     * @param string $collection
     * @return \abstracts\AssetAbstract|null
     */
    public function getCollection($collection);

    /**
     * addCollections
     * @param array $collections
     * @param \abstracts\AssetAbstract $dependent
     */
    public function addCollections(array $collections, $dependent = null);
}