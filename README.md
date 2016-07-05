# Embed Remote Content Filter

## Description:
This text filter allows the user to embed content from many external contents providers.
The filter is using oEmbed for grabbing the external content. The list of supported Providers is available here:
http://oembed.com/#section7.

The list can be refreshed at a user defined interval.
As new providers are added to this list, the plugin will automatically support them without having to be upgraded.

Support for custom providers is planned.


##Installation:
Download the source files.
Unzip the package
Copy the "embedrc" folder to moodle/filter on the Moodle server

OR

clone the git repository to moodle/filter/embedrc.
Login as an admin on the Moodle site and install the filter.

##To use:
By default the embedrc filter is disabled. You can turn it on under Plugins > Filters.

All supported providers are enabled per default. Restrictions can be enabled in the filter settings.

The filter can work in two ways:

1. If you add a link to the desired remote content the link will be replaced with the embed code.

2. The filter will work with the atto-embedrc plugin which lets you embed the content using the atto text editor.

## Acknowledgements

This filter is based on moodle-filter_oembed maintained by Mike Churchward, James McQuillan, Vinayak (Vin) Bhalerao, Josh Gavant and Rob Dolin.
It is available at GitHub https://github.com/MSOpenTech/moodle-filter_oembed.

Many thanks for that!
