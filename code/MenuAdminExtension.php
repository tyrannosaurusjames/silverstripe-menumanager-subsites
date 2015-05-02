<?php

namespace Guttmann\SilverStripe;

use Extension;
use Subsite;

class MenuAdminExtension extends Extension
{

    public function updateEditForm($form)
    {
        $gridField = $form->Fields()->fieldByName('MenuSet');

        $list = $gridField->getList();
        $filteredList = $list->filter(array(
            'SubsiteID' => Subsite::currentSubsiteID()
        ));

        $gridField->setList($filteredList);
    }

}
