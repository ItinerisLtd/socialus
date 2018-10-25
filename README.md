# Socialus

[![Packagist Version](https://img.shields.io/packagist/v/itinerisltd/socialus.svg)](https://packagist.org/packages/itinerisltd/socialus)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/itinerisltd/socialus.svg)](https://packagist.org/packages/itinerisltd/socialus)
[![Packagist Downloads](https://img.shields.io/packagist/dt/itinerisltd/socialus.svg)](https://packagist.org/packages/itinerisltd/socialus)
[![GitHub License](https://img.shields.io/github/license/itinerisltd/socialus.svg)](https://github.com/ItinerisLtd/socialus/blob/master/LICENSE)
[![Hire Itineris](https://img.shields.io/badge/Hire-Itineris-ff69b4.svg)](https://www.itineris.co.uk/contact/)

<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->


- [Goal](#goal)
- [Installation](#installation)
- [Usage](#usage)
- [FAQs](#faqs)
  - [Will you add support for older PHP versions?](#will-you-add-support-for-older-php-versions)
  - [It looks awesome. Where can I find some more goodies like this?](#it-looks-awesome-where-can-i-find-some-more-goodies-like-this)
  - [This isn't on wp.org. Where can I give a ⭐️⭐️⭐️⭐️⭐️ review?](#this-isnt-on-wporg-where-can-i-give-a-%EF%B8%8F%EF%B8%8F%EF%B8%8F%EF%B8%8F%EF%B8%8F-review)
- [Feedback](#feedback)
- [Change Log](#change-log)
- [Security](#security)
- [Credits](#credits)
- [License](#license)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Goal

[Socialus](https://github.com/ItinerisLtd/socialus) makes sharing pages to social networks dead simple.

## Installation

### Traditional WordPress Theme

Require the package into your theme with Composer with:
```bash
$ composer require itinerisltd/socialus
```

### Sage
Require the package into Sage:
```bash
$ composer require itineris/socialus -o
```

## Usage

### Traditional WordPress Theme

Render the output!
```php
$socialus = new \Itineris\Socialus\Socialus();
echo $socialus->render();
```

### Sage

Add it to a Controller:
```php
# sage/app/Controllers/App.php

namespace App\Controllers;

use Sober\Controller\Controller;
use Itineris\Socialus\Socialus;

class App extends Controller
{
    public function socialus()
    {
        return new Socialus();
    }
}
```

Finally, render the output into your Blade template:
```blade
{!! $socialus->render() !!}
```

## FAQs

### Will you add support for older PHP versions?

Never! This plugin will only works on [actively supported PHP versions](https://secure.php.net/supported-versions.php).

Don't use it on **end of life** or **security fixes only** PHP versions.

### It looks awesome. Where can I find some more goodies like this?

- Articles on [Itineris' blog](https://www.itineris.co.uk/blog/)
- More projects on [Itineris' GitHub profile](https://github.com/itinerisltd)
- Follow [@itineris_ltd](https://twitter.com/itineris_ltd) on Twitter
- Hire [Itineris](https://www.itineris.co.uk/services/) to build your next awesome site

### This isn't on wp.org. Where can I give a ⭐️⭐️⭐️⭐️⭐️ review?

Thanks! Glad you like it. It's important to make my boss know somebody is using this project. Instead of giving reviews on wp.org, consider:

- tweet something good with mentioning [@itineris_ltd](https://twitter.com/itineris_ltd)
- star this [Github repo](https://github.com/ItinerisLtd/socialus)
- watch this [Github repo](https://github.com/ItinerisLtd/socialus)
- write blog posts
- submit pull requests
- [hire Itineris](https://www.itineris.co.uk/services/)

## Feedback

**Please provide feedback!** We want to make this library useful in as many projects as possible.
Please submit an [issue](https://github.com/ItinerisLtd/socialus/issues/new) and point out what you do and don't like, or fork the project and make suggestions.
**No issue is too small.**

## Change Log

Please see [CHANGELOG](./CHANGELOG.md) for more information on what has changed recently.

## Security

If you discover any security related issues, please email [hello@itineris.co.uk](mailto:hello@itineris.co.uk) instead of using the issue tracker.

## Credits

[Socialus](https://github.com/ItinerisLtd/socialus) is a [Itineris Limited](https://www.itineris.co.uk/) project created by [Lee Hanbury-Pickett](https://github.com/codepuncher).

Full list of contributors can be found [here](https://github.com/ItinerisLtd/socialus/graphs/contributors).

## License

[Socialus](https://github.com/ItinerisLtd/socialus) is licensed under the [MIT License](https://opensource.org/licenses/MIT).
Please see [License File](./LICENSE) for more information.
