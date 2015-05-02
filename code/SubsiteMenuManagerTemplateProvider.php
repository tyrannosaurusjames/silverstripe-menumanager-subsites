<?php

namespace Guttmann\SilverStripe;

use MenuSet;
use Subsite;
use TemplateGlobalProvider;

class SubsiteMenuManagerTemplateProvider implements TemplateGlobalProvider
{

    public static function get_template_global_variables()
    {
        return array(
            'SubsiteMenuSet' => 'SubsiteMenuSet'
        );
    }

    public static function SubsiteMenuSet($name)
    {
        return MenuSet::get()->filter(array(
            'Name' => $name,
            'SubsiteID' => Subsite::currentSubsiteID()
        ))->First();
    }

}
