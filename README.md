# SilverStripe menu manager subsites integration

This module enables per subsite menu sets using [Heyday's Menu Manager module](https://github.com/heyday/silverstripe-menumanager).

## Installation

Install via composer:

    composer require guttmann/silverstripe-menumanager-subsites dev-master

No other configuration is required. Once installed any menu sets created will be
linked to the currently selected Subsite at the time of creation.

## Usage

Menu sets can still be accessed from templates via ```$MenuSet("Your Menu Set").MenuItems``` but if you want
to ensure each Subsite only accesses its own MenuSets you can use this in your templates instead:

    <% loop $SubsiteMenuSet("Your Menu Set").MenuItems %>
        <a href="$Link" class="$LinkingMode">$MenuTitle</a>
    <% end_loop %>
