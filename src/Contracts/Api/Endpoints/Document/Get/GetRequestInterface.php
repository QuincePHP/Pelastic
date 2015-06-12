<?php namespace Quince\Pelastic\Contracts\Api\Endpoints\Document\Get;

use Quince\Pelastic\Contracts\Api\Request\RequestInterface;
use Quince\Pelastic\Contracts\DocumentInterface;

interface GetRequestInterface extends RequestInterface {

    /**
     * Set id
     *
     * @param $id
     * @return $this
     */
    public function setId($id);

    /**
     * A proxy to set id
     *
     * @param $id
     * @return $this
     */
    public function id($id);

    /**
     * Get from document
     *
     * @param DocumentInterface $document
     * @return $this
     */
    public function fromDocument(DocumentInterface $document);

    /**
     * Get document id
     *
     * @return string
     */
    public function getDocumentId();

    /**
     * Get document id
     *
     * @return string
     */
    public function getId();

    /**
     * Set version
     *
     * @param $version
     * @return $this
     */
    public function setVersion($version);

    /**
     * Only perform a HEAD request to check that document exists
     *
     * @return $this
     */
    public function onlyCheck();

    /**
     * Should the request be only checked with a HEAD request
     *
     * @return bool
     */
    public function shouldBeOnlyChecked();

    /**
     * Only load source attributes
     *
     * @return $this
     */
    public function onlySource();

    /**
     * Should the request only load sources?
     *
     * @return bool
     */
    public function shouldOnlyLoadSource();

    /**
     * Set fields params
     *
     * @param array $fields
     * @return $this
     */
    public function setFields(array $fields);

    /**
     * Set parent param
     *
     * @param $parent
     * @return $this
     */
    public function setParent($parent);

    /**
     * Set preference
     *
     * @param $pref
     * @return $this
     */
    public function setPreference($pref);

    /**
     * Include this source fields
     *
     * @param array $fields
     * @return $this
     */
    public function includeSource(array $fields);

    /**
     * Exclude this source fields
     *
     * @param array $fields
     * @return $this
     */
    public function excludeSource(array $fields);

    /**
     * Should be realtime
     *
     * @param bool $realtime
     * @return $this
     */
    public function realtime($realtime);

    /**
     * Set version type param
     *
     * @param $versionType
     * @return $this
     */
    public function setVersionType($versionType);

    /**
     * Should add source or not
     *
     * @param bool $source
     * @return $this
     */
    public function setSource($source);

    /**
     * Set routing params
     *
     * @param $routing
     * @return $this
     */
    public function setRouting($routing);

    /**
     * Set refresh param
     *
     * @param $refresh
     * @return $this
     */
    public function setRefresh($refresh);

    /**
     * Set index
     *
     * @param $index
     * @return $this
     */
    public function setIndex($index);

    /**
     * Get index
     *
     * @param $index
     * @return mixed
     */
    public function getIndex($index);

    /**
     * Set type
     *
     * @param $type
     * @return $this
     */
    public function setType($type);
}