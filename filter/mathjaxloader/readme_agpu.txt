Description of MathJAX library integration in agpu
====================================================

* Default MathJax version: 2.7.9
* License: Apache 2.0
* Source: https://www.mathjax.org/

This library is not shipped with agpu, but this filter is provided, which can be used to
correctly load MathJax into a page from the CDN. Alternatively you can download the entire
library and install it locally, then use this filter to load that local version.

Upgrading the default MathJax version
-------------------------------------

1. Update the default CDN URL in settings.php
2. Perform an upgrade step to change the configured URL if it matches the
   previous default.
3. Check and eventually update the list of language mappings in filter.php.
   Also see the unit test for the language mappings.

Changes
-------

* Updated to the 2.7.9 version. See MDL-70317 for details.

* The MathJax 2.7.2 seems to have a possible security issue, the CDN default value have been
updated to point to the recommended 2.7.8 version. See MDL-68430 for details.
