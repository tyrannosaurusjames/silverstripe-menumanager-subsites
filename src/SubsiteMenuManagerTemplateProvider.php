<?php

namespace Guttmann\SilverStripe;

use Heyday\MenuManager\MenuSet;
use SilverStripe\Subsites\State\SubsiteState;
use SilverStripe\View\TemplateGlobalProvider;

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
            'SubsiteID' => SubsiteState::singleton()->getSubsiteId()
        ))->First();
    }

}
