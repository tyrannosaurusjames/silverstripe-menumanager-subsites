<?php

namespace Guttmann\SilverStripe;

use Heyday\MenuManager\MenuSet;
use SilverStripe\Core\Extension;
use SilverStripe\Subsites\State\SubsiteState;

class MenuAdminExtension extends Extension
{
    public function updateEditForm($form)
    {
        $gridField = $form->Fields()->fieldByName(MenuSet::class);
        if($gridField) {
            $list = $gridField->getList();
            $filteredList = $list->filter(array(
                'SubsiteID' => SubsiteState::singleton()->getSubsiteId()
            ));
            $gridField->setList($filteredList);
        }
    }
}
