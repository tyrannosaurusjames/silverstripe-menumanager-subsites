<?php

namespace Guttmann\SilverStripe;

use Heyday\MenuManager\MenuSet;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\Form;
use SilverStripe\Subsites\State\SubsiteState;

class MenuAdminExtension extends Extension
{
    public function updateEditForm(Form $form)
    {
        if ($this->owner->modelClass === MenuSet::class) {
            $gridFieldName = $this->extSanitiseClassName($this->owner->modelClass);
            $gridField = $form->Fields()->fieldByName($gridFieldName);
            $list = $gridField->getList();
            $filteredList = $list->filter(
                [
                    'SubsiteID' => SubsiteState::singleton()->getSubsiteId()
                ]
            );
            $gridField->setList($filteredList);
        }

        return $form;
    }

    /*
     * This is required as we can't call the model admins sanitiseClassName
     */
    public function extSanitiseClassName($class)
    {
        str_replace('\\', '-', $class);
    }
}
