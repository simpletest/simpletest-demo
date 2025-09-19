## SimpleTest Demo

This repository is a tiny demo that shows how to use the SimpleTest library with
Composer PSR-4 autoloading for your application code and a PSR-4 dev autoload for tests.

### What is here

- `src/Hello.php` — example class (App\Hello::world()).
- `tests/` — test files (namespace `App\Tests`) and a runner:
	- `tests/TestOfHelloUsingAutoloader.php` — test that relies on Composer autoload.
	- `tests/TestOfHelloUsingDirectIncludes.php` — test that demonstrates direct includes (but still uses Composer for App classes).
	- `tests/run_all.php` — runner that includes all test files safely and triggers SimpleTest autorun once.
- `composer.json` — contains:
	- `autoload` (PSR-4): `"App\\": "src/"`
	- `autoload-dev` (PSR-4): `"App\\Tests\\": "tests/"`
	- `scripts`: convenience scripts for running tests

### How it works

- Composer autoload maps `App\` to `src/` so your classes are autoloaded.
- Tests are namespaced under `App\Tests` and registered in `autoload-dev` so Composer can autoload them during development.
- SimpleTest itself is not PSR-4 autoloaded; test files explicitly require SimpleTest's `autorun.php` so autorun will discover and run tests on script shutdown.

### Common tasks

1) Regenerate Composer autoload files (recommended after edits):

```bash
composer dump-autoload -o
```

2) Run all tests with the runner (single SimpleTest run):

```bash
php tests/run_all.php
```

3) Run tests via Composer scripts

```bash
# runs the runner which includes all tests
composer run tests:all

# run the two example tests individually (keeps separate outputs)
composer run tests:single
```

4) Run a single test file directly

```bash
php tests/TestOfHelloUsingAutoloader.php
```

### Troubleshooting

- "Cannot declare class ... because the name is already in use": this can happen if Composer's optimized autoloader preloads test classes and you also require their files — use `tests/run_all.php` (it checks for existing classes before requiring files) or avoid double-including test files.
- If tests don't find your App classes, run `composer dump-autoload` to refresh autoload maps.
