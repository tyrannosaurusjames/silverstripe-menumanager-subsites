<?php

namespace Guttmann\SilverStripe;

use DataExtension;
use FieldList;
use HiddenField;
use Subsite;
use MenuSet;
use DB;

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

    public function requireDefaultRecords()
    {
        $subsites = Subsite::all_sites();
        $defaultSetNames = $this->owner->config()->get('default_sets') ?: array();
        Subsite::$use_session_subsiteid = true;

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
        Subsite::$use_session_subsiteid = false;
    }
}
