<?php

namespace Guttmann\SilverStripe;

use Heyday\MenuManager\MenuSet;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HiddenField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\DB;
use SilverStripe\Subsites\Model\Subsite;
use SilverStripe\Subsites\State\SubsiteState;

class MenuSetExtension extends DataExtension
{
    private static $has_one = array(
        'Subsite' => Subsite::class
    );

    public function updateCMSFields(FieldList $fields)
    {
        $fields->push(new HiddenField('SubsiteID'));
    }

    public function onBeforeWrite()
    {
        if (!$this->owner->SubsiteID) {
            $this->owner->SubsiteID = SubsiteState::singleton()->getSubsiteId();
        }
    }

    public function requireDefaultRecords()
    {
        $subsites = Subsite::all_sites();
        $defaultSetNames = $this->owner->config()->get('default_sets') ?: array();
        $subsites->each(function ($subsite) use ($defaultSetNames) {
            Subsite::changeSubsite($subsite->ID);

            foreach ($defaultSetNames as $name) {
                $existingRecord = MenuSet::get()->filter([
                    'Name' => $name,
                    'SubsiteID' => $subsite->ID,
                ])->first();

                if (!$existingRecord) {
                    $set = new MenuSet();
                    $set->Name = $name;
                    $set->write();

                    DB::alteration_message("MenuSet '$name' created for Subsite", 'created');
                }
            }
        });
    }
}
