<?php

namespace Guttmann\SilverStripe;

use DataExtension;
use FieldList;
use HiddenField;
use Subsite;

class MenuSetExtension extends DataExtension
{

    private static $has_one = array(
        'Subsite' => 'Subsite'
    );

    public function updateCMSFields(FieldList $fields)
    {
        $fields->push(new HiddenField('SubsiteID'));
    }

    public function onBeforeWrite()
    {
        $this->owner->SubsiteID = Subsite::currentSubsiteID();
    }

}
