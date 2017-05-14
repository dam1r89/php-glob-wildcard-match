# Glob Wildcard Matching

Simple class for matching wildcard patterns.

- Supports only `*` and `?` tokens
- Escape other regexp symbols
- Returns true/false

Code sample:

```php
<?php

use dam1r89\GlobMatch\GlobMatch;

$glob = new GlobMatch();
$glob->match('pattern *', 'pattern is matched'); // => true
```



Advanced alternatives:

- https://github.com/nick-jones/globby
- https://github.com/rkrx/php-wildcards