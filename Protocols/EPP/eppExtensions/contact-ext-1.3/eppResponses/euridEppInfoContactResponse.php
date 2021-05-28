<?php
namespace Metaregistrar\EPP;

class euridEppInfoContactResponse extends eppInfoContactResponse
{
    /**
     *
     * @return euridEppContact
     */
    public function getContact() {
        $postalinfo = $this->getContactPostalInfo();
        $contact = new euridEppContact($postalinfo, $this->getContactEmail(), $this->getContactVoice(), $this->getContactFax());

        $contact->setId($this->getContactId());
        $contact->setStatus($this->getContactStatus());

        /* fill the eurid extra fields */
        $contact->setContactExtType($this->getExtType());
        $contact->setContactExtLang($this->getLanguage());
        $contact->setContactExtVat($this->getVat());

        // only registrant contacts have the naturalPerson and whoisEmail fields
        if ($this->getExtType() === 'registrant') {
            $contact->setContactExtNaturalPerson($this->getNaturalPerson());
            $contact->setContactExtWhoisEmail($this->getWhoisEmail());
        }

        return $contact;
    }

    /**
     *
     * @return string
     */
    public function getExtType()
    {
        return $this->queryPath('/epp:epp/epp:response/epp:extension/contact-ext:infData/contact-ext:type');
    }

    /**
     *
     * @return string
     */
    public function getLanguage() {
        return $this->queryPath('/epp:epp/epp:response/epp:extension/contact-ext:infData/contact-ext:lang');
    }

    /**
     *
     * @return string
     */
    public function getVat() {
        return $this->queryPath('/epp:epp/epp:response/epp:extension/contact-ext:infData/contact-ext:vat');
    }

    /**
     *
     * @return string   true or false
     */
    public function getNaturalPerson() {
        return $this->queryPath('/epp:epp/epp:response/epp:extension/contact-ext:infData/contact-ext:naturalPerson');
    }

    /**
     * @return string
     */
    public function getWhoisEmail() {
        return $this->queryPath('/epp:epp/epp:response/epp:extension/contact-ext:infData/contact-ext:whoisEmail');
    }
}