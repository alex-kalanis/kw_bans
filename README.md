# kw_bans

[![Build Status](https://app.travis-ci.com/alex-kalanis/kw_bans.svg?branch=master)](https://app.travis-ci.com/github/alex-kalanis/kw_bans)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alex-kalanis/kw_bans/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alex-kalanis/kw_bans/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/alex-kalanis/kw_bans/v/stable.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_bans)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.3-8892BF.svg)](https://php.net/)
[![Downloads](https://img.shields.io/packagist/dt/alex-kalanis/kw_bans.svg?v1)](https://packagist.org/packages/alex-kalanis/kw_bans)
[![License](https://poser.pugx.org/alex-kalanis/kw_bans/license.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_bans)
[![Code Coverage](https://scrutinizer-ci.com/g/alex-kalanis/kw_bans/badges/coverage.png?b=master&v=1)](https://scrutinizer-ci.com/g/alex-kalanis/kw_bans/?branch=master)

Check if desired contact is blocked by your system.

## PHP Installation

```
{
    "require": {
        "alex-kalanis/kw_bans": "1.0"
    }
}
```

(Refer to [Composer Documentation](https://github.com/composer/composer/blob/master/doc/00-intro.md#introduction) if you are not
familiar with composer)


## PHP Usage

1.) Use your autoloader (if not already done via Composer autoloader)

2.) Add some external packages with connection to the local or remote services.

3.) Connect the "kalanis\kw_bans\Bans" into your app. Extends it for setting your case.

4.) Extend your libraries by interfaces inside the package.

5.) Just call setting and render

## Why?

The comparison cannot be done by direct querying over database - even if the database
engine supports parts like IP address then it isn't possible to match content due necessity
to access affected bits directly - so then the external library.
