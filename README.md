# wok_gpxviewer
This is a [TYPO3](https://typo3.org) extension, which provides a plugin for integration of [GPXViewer](https://www.j-berkemeier.de/GPXViewer) from Jürgen Berkemeier.

## What does it do?
With including the [GPXViewer](https://www.j-berkemeier.de/GPXViewer) javascript one can display GPX tracks, routes, waypoints in Google Maps or Openstreetmap. Please refer to the [GPXViewer website](https://www.j-berkemeier.de/GPXViewer) for more informations about the features of [GPXViewer](https://www.j-berkemeier.de/GPXViewer).

This extension/plugin for [TYPO3](https://typo3.org) integrate most of the features of [GPXViewer](https://www.j-berkemeier.de/GPXViewer). For some examples please refer to [my website](https://wolfgangkleinbach.de/test/GPXViewer). I will also try to do some documentation for the use of the extension there.

## What prerequisites are needed?
* [TYPO3](https://typo3.org) 10.4.19 and above.
* The [bootstrap_package](https://www.bootstrap-package.com/) is highly recommended. I only use the extension/plugin with the bootstrap_package and it's ScssPHP compiler and therefore the layout might be broken if you don't (please refer to "How to set up?"). I tested the [bootstrap_package](https://www.bootstrap-package.com/) versions 11.0.2, 11.0.3.
* For some features you need [exiftool](https://exiftool.org) installed on your server.
* Probably you need API keys for use of Google maps or OSM. Find more information about API keys [here](https://www.j-berkemeier.de/GPXViewer/#Apikey).
* You don't necessarily need GPX files, you even can create a GPXViewer content element and add your own waypoints or waypoint images with GPS coordinates. You need to know the coordinates from another source. This extension does not provide a way to determine GPS coordinates from a map.
* Commercial use of [GPXViewer](https://www.j-berkemeier.de/GPXViewer) of Jürgen Berkemeier is restricted. Read more about this and other restrictions [here](https://www.j-berkemeier.de/GPXViewer/#Rechtliches).
* The use of this TYPO3 extension is only restricted insofar as [GPXViewer](https://www.j-berkemeier.de/GPXViewer) and other provided resources are underlying restrictions.

## How to set up?
* Download and install the extension [wok_gpxviewer](https://github.com/zeichensatz/wok_gpxviewer).
* Create a new page in [TYPO3](https://typo3.org) backend or edit an existing one.
* Create an extension template for that page or edit an existing template and `"Include static (from extensions)"` for `GPXViewer (wok_gpxviewer)`. Please include the GPXViewer template after your bootstrap_package templates.
* Change to `Constant Editor` and edit the settings for GPXViewer if needed.
* Now you can create a content element of type `plugin` and then select `GPXViewer tracks display`.
* In the tab `Plug-in` you are able to add GPX files for display in the frontend. There are several tabs with settings to explore. Hopefully most of them are self explaining. If not, don't hesitate to contact me (see below).
* If you're not using the bootstrap_package, please do the following:
  * Set the constant `plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.scss = false`. This setting will cause the use of CSS file `wok_gpxviewer/Resources/Public/CSS/custom.css`. 
  * Best practice is to copy the CSS file `wok_gpxviewer/Resources/Public/CSS/custom.css` into your CSS file folder. Then set the constant `plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.cssFile = ToYourCssFile`. Please check, if your CSS file will be included in the source text of your page. If not, path/name is most probably not correct yet.

## How can you give your feedback
* I would like to hear from you, how you're using the extension and what can be improved.
  * You can write me a mail, see [my website](https://wolfgangkleinbach.de) for contact data.
  * You can add issues or pull requests on [github](https://github.com/zeichensatz/wok_gpxviewer).

## Todos
* Check button formatting for imgdivs: perhaps change to a tag? This would mean changes in the javascript too.
* Map+imgdiv+profiles: Some minor problems in display
* make each map/imgdiv/profiles scaleable from backend
* more examples
* more documentation
* create TER version
* check compatibility with extension_builder 10.0.1
