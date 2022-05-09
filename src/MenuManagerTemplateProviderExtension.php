<?php

namespace Guttmann\SilverStripe;

use SilverStripe\Core\Extension;
use SilverStripe\ORM\DataList;
use SilverStripe\Subsites\State\SubsiteState;

class MenuManagerTemplateProviderExtension extends Extension
{
    /**
     * Update MenuSet finding code to account for active subsite
     *
     * @param DataList $possibleMatches
     * @return void
     */
    public function updateFindMenuSetByName(&$possibleMatches)
    {
        $subsiteId = SubsiteState::singleton()->getSubsiteId();
        $possibleMatches = $possibleMatches->filter('SubsiteID', $subsiteId);
    }
}
