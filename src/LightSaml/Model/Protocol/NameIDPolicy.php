<?php

namespace LightSaml\Model\Protocol;

use LightSaml\Model\Context\DeserializationContext;
use LightSaml\Model\Context\SerializationContext;
use LightSaml\Model\AbstractSamlModel;
use LightSaml\SamlConstants;

class NameIDPolicy extends AbstractSamlModel
{
    /**
     * @var string|null
     */
    protected $format;

    /**
     * @var bool|null
     */
    protected $allowCreate;

    /**
     * @var string|null
     */
    protected $spNameQualifier;

    /**
     * @param string|bool|null $allowCreate
     *
     * @return NameIDPolicy
     */
    public function setAllowCreate($allowCreate)
    {
        if ($allowCreate === null) {
            $this->allowCreate = null;
        } elseif (is_string($allowCreate) || is_int($allowCreate)) {
            $this->allowCreate = strcasecmp($allowCreate, 'true') == 0 || $allowCreate === true || $allowCreate == 1;
        } else {
            $this->allowCreate = (bool) $allowCreate;
        }

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getAllowCreate()
    {
        return $this->allowCreate;
    }

    /**
     * @return string|null
     */
    public function getAllowCreateString()
    {
        if ($this->allowCreate === null) {
            return;
        }

        return $this->allowCreate ? 'true' : 'false';
    }

    /**
     * @param string|null $format
     *
     * @return NameIDPolicy
     */
    public function setFormat($format)
    {
        $this->format = (string) $format;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param string|null $spNameQualifier
     *
     * @return NameIDPolicy
     */
    public function setSPNameQualifier($spNameQualifier)
    {
        $this->spNameQualifier = $spNameQualifier;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSPNameQualifier()
    {
        return $this->spNameQualifier;
    }

    /**
     * @param \DOMNode             $parent
     * @param SerializationContext $context
     *
     * @return void
     */
    public function serialize(\DOMNode $parent, SerializationContext $context)
    {
        $result = $this->createElement('NameIDPolicy', SamlConstants::NS_PROTOCOL, $parent, $context);

        $this->attributesToXml(array('Format', 'SPNameQualifier', 'AllowCreate'), $result);
    }

    /**
     * @param \DOMElement            $node
     * @param DeserializationContext $context
     *
     * @return void
     */
    public function deserialize(\DOMElement $node, DeserializationContext $context)
    {
        $this->checkXmlNodeName($node, 'NameIDPolicy', SamlConstants::NS_PROTOCOL);

        $this->attributesFromXml($node, array('Format', 'SPNameQualifier', 'AllowCreate'));
    }
}