<?php

// ...

// now how are bans defined...

$libBan = new kalanis\kw_bans\Bans(
    null,
    new kalanis\kw_bans\Sources\File(__DIR__ . DIRECTORY_SEPARATOR . 'ip4.txt'),
    new kalanis\kw_bans\Sources\File(__DIR__ . DIRECTORY_SEPARATOR . 'name.txt')
);

if ($libBan->has(
    '10.0.0.1', 'anonymous'
)) {
    die('Accessing user is banned!');
}
